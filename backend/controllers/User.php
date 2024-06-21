<?php 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/PlaCo/backend/models/User.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/PlaCo/backend/helpers/session_helper.php';
    class Users {
        private $userModel;

        public function __construct(){
            $this->userModel = new User;
        }

        public function register($data){
            $data = [
                'prenume' => trim($data['prenume']),
                'nume' => trim($data['nume']),
                'email' => trim($data['email']),
                'password_hash' => trim($data['password_hash']),
                'user_type' => trim($data['user_type'])
            ];


            //validare inputuri 
            if(empty($data['prenume']) || empty($data['nume']) || empty($data['email']) || empty($data['password_hash']) || empty(trim($_POST['psw-conf'])) ){
                http_response_code(400);
                echo json_encode(["message" => "Please fill out all inputs"]);
                return;
            }

            if(!preg_match("/^[a-zA-Z]*$/", $data['prenume'])){
                http_response_code(400);
                echo json_encode(["message" => "Invalid name. Don't use special characters or numbers!"]);
                return;
            } 

            if(!preg_match("/^[a-zA-Z]*$/", $data['nume'])){
                http_response_code(400);
                echo json_encode(["message" => "Invalid name. Don't use special characters or numbers!"]);
                return;
            } 

          
            if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                http_response_code(400);
                echo json_encode(["message" => "Invalid email"]);
                return;
            }

            if(strlen($data['password_hash']) < 6){
                http_response_code(400);
                echo json_encode(["message" => "Invalid password"]);
                return; 
            } else if($data['password_hash'] !== trim($_POST['psw-conf'])){
                http_response_code(400);
                echo json_encode(["message" => "Passwords don't match"]);
                return;
            }

            if($this->userModel->findUserByEmail($data['email'])){
                http_response_code(400);
                echo json_encode(["message" => "Email already used"]);
                return;
            }

            $data['password_hash'] = password_hash($data['password_hash'], PASSWORD_DEFAULT);

            // all tests have passed
            if($this->userModel->register($data)){
                http_response_code(201);
                echo json_encode(["message" => "User registered successfully"]);
            }else{
                http_response(500);
                echo json_encode(["message" => "Something went wrong"]);
            }
        }
        public function login($data){

            $data = [
                'email' => trim($data['email']),
                'password' => trim($data['password'])
            ];
    
            if(empty($data['email']) || empty($data['password'])){
                http_response_code(400);
                echo json_encode(["message" => "Please fill out all inputs"]);
                return;
            }
                //Check for user/email
            if($this->userModel->findUserByEmail($data['email'])){
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);
                if($loggedInUser){
                    //Create session
                    $this->createUserSession($loggedInUser);
                }else{
                    http_response_code(401);
                    echo json_encode(["message" => "Password Incorrect"]);
                }
            }else{
                http_response_code(404);
                echo json_encode(["message" => "No user found"]);
            }
        }  
        public function createUserSession($loggedInUser){
            session_start();
            $_SESSION['id'] = $loggedInUser->id;
            $_SESSION['user_type'] = $loggedInUser->user_type;
            $_SESSION['email'] = $loggedInUser->email;
            // if ($loggedInUser->user_type == 'client') {
            //     redirect("/home/client_profile");
            // } elseif ($loggedInUser->user_type == 'freelancer') {
            //     redirect("/home/freelancer_profile");
            // } else {
            //     redirect("/home/login");
            // }
            http_response_code(200);
            echo json_encode(["message" => "Login successful"]);
        }  
        public function logout(){
            unset($_SESSION['id']);
            unset($_SESSION['user_type']);
            unset($_SESSION['email']);
            session_destroy();
            redirect("/home/login");
            http_response_code(200);
            echo json_encode(["message" => "Logout successful"]);
        }
        public function displayProfile(){
            if(!isset($_SESSION)){
                session_start();
            }
            if(!isset($_SESSION['id'])){
                // redirect("/home/home");
                http_response_code(401);
                echo json_encode(["message" => "Unauthorized"]);
                return;
            }
            $userProfile = $this->userModel->getUserProfileById($_SESSION['id']);
            
            if(!$userProfile){
                http_response_code(404);
                echo json_encode(["message" => "Profile not found"]);
                return;
                // die("aici Profile not found.");
            }
            // return $userProfile;
            echo json_encode($userProfile);
        }
        public function updateProfile($data){
            if(!isset($_SESSION)){
                session_start();
            }
            if(!isset($_SESSION['id'])){
                http_response_code(401);
                echo json_encode(["message" => "Unauthorized"]);
                return;
                // redirect("login");
            }
            $userId = $_SESSION['id'];
            $updatedData = [
                'name' => trim($data['name']),
                'phone_number' => trim($data['phone_number']),
                'email' => trim($data['email']),
                'address' => trim($data['address'])
            ];
            if($this->userModel->updateProfile($userId, $updatedData)){
                // header('Content-Type: application/json');
                // echo json_encode(['message' => 'Profile updated successfully']);
                // } else {
                //     http_response_code(500);
                //     header('Content-Type: application/json');
                //     echo json_encode(['message' => 'Failed to update profile']);
                //     // redirect("../../frontend/FreelancerLoggedIn/freelancer_profile/freelancer_profile.php");
                    
                //     }
                // redirect("../../frontend/FreelancerLoggedIn/freelancer_profile/freelancer_profile.php");
                echo json_encode(['message' => 'Profile updated successfully']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Failed to update profile']);
            } 
        }
        public function deleteProfile(){
            if(!isset($_SESSION)){
                session_start();
            }
    
            if(!isset($_SESSION['id'])){
                // header('Content-Type: application/json');
                // echo json_encode(['message' => 'Unauthorized']);
                // exit();
                http_response_code(401);
                echo json_encode(['message' => 'Unauthorized']);
                return;
            }
    
            $userId = $_SESSION['id'];
            if($this->userModel->deleteProfile($userId)){
                session_destroy();
                // header('Content-Type: application/json');
                echo json_encode(['message' => 'Profile deleted successfully']);
            } else {
                http_response_code(500);
                // header('Content-Type: application/json');
                echo json_encode(['message' => 'Failed to delete profile']);
            }
        }
        // public function postProject() {
        //     $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        //     $files = [];
        //     $uploadDir ='./uploads/';
        
        //     if (!is_dir($uploadDir)) {
        //         mkdir($uploadDir, 0755, true);
        //     }
        //     if (!empty($_FILES['file']['name'])) {
                
        //         foreach ($_FILES['file']['tmp_name'] as $key => $tmp_name) {
        //             $filename = basename($_FILES['file']['name'][$key]);
        //             $targetFile = $uploadDir . $filename;
        
        //             if (move_uploaded_file($tmp_name, $targetFile)) {
        //                 $files[] = $targetFile;
        //             } else {
        //                 error_log("Failed to move uploaded file: " . $filename);
        //             }
        //         }
        //     }
        
        //     $data = [
        //         'title' => trim($_POST['title']),
        //         'description' => trim($_POST['description']),
        //         'files' => implode(',', $files),
        //         //'currency' => trim($_POST['currency']),
        //         'owner_id' => $_SESSION['id']
        //     ];
            
        //     if ($this->userModel->saveProject($data)) {
        //         flash('project_message', 'Project posted successfully');
        //       //  redirect('../../frontend/ClientLoggedIn/client_profile/client_profile.php');
        //     } else {
        //         flash('project_message', 'Something went wrong');
        //         redirect('/home/post_a_project');
        //     }
        // }
    }
    $init = new Users;
    error_log('VERIFICARE'); // Log to server log
    error_log('Request Method: ' . $_SERVER['REQUEST_METHOD']);
    error_log('Request Data: ' . file_get_contents("php://input"));
    switch($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            // $data = json_decode(file_get_contents("php://input"). true);
            // error_log('POST request received'); // Log to server log

            // if(isset($data['type'])){
            //     switch($data['type']){
            //         case 'register':
            //             $init->register($data);
            //             break;
            //         case 'login':
            //             $init->login($data);
            //             break;
            //         default:
            //             http_response_code(400);
            //             echo json_encode(["message" => "Invalid request type"]);
            //             break;
            //     }
            // }
            // break;
            header('Content-Type: application/json');
            $data = json_decode(file_get_contents("php://input"), true);
            if(isset($data['type'])){
                switch($data['type']){
                    case 'register':
                        $init->register($data);
                        break;
                    case 'login':
                        $init->login($data);
                        break;
                    default:
                        http_response_code(400);
                        echo json_encode(["message" => "Invalid request type"]);
                        break;
                }
            } else {
                http_response_code(400);
                echo json_encode(["message" => "Request type not set"]);
            }
            break;
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"),true);
            if($data){
                $init->updateProfile($data);
            } else {
                http_response_code(400);
                echo json_encode(["message" => "Invalid data"]);
            }
            break;
        case 'DELETE':
            $init->deleteProfile();
            break;
        case 'GET':
            $init->displayProfile();
            break;
        default:
            http_response_code(405);
            echo json_encode(["message" => "Method Not Allowed"]);
            break;
    }
    // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //     if (isset($_POST['type'])) {
    //         switch ($_POST['type']) {
    //             case 'register':
    //                 $init->register();
    //                 break;
    //             case 'login':
    //                 $init->login();
    //                 break;
    //             case 'post_project':
    //                 $init->postProject();
    //                 break;
    //             default:
    //                 redirect("/home/register");
    //                 break;
    //         }
    //     }
    // } elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    //     $data = json_decode(file_get_contents("php://input"), true);
    //     if ($data && isset($data['type']) && $data['type'] === 'update_profile') {
    //         $init->updateProfile($data);
    //     } else {
    //         http_response_code(405);
    //         echo json_encode(["message" => "Invalid request."]);
    //     }
    // } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    //     $init->deleteProfile();
    // } elseif($_SERVER['REQUEST_METHOD'] === 'GET'){
    //     $userProfile = $init->displayProfile();
    //     echo json_encode($userProfile);
    //     // exit;
    // } else {
    //     http_response_code(405);
    //     echo json_encode(["message" => "Method Not Allowed"]);
    // }
    