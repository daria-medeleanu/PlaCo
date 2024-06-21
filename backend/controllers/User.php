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
                'psw-conf' => trim($data['psw-conf']),
                'user_type' => trim($data['user_type'])
            ];


            //validare inputuri 
            if(empty($data['prenume']) || empty($data['nume']) || empty($data['email']) || empty($data['password_hash']) || empty($data['psw-conf']) ){
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
            } else if($data['password_hash'] !== $data['psw-conf']){
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
            // session_start();
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
    }
    $init = new Users;
    header('Content-Type: application/json');
    switch($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            $data = json_decode(file_get_contents("php://input"), true);
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
            break;
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"),true);
            if($data){
                console_log('aici intra');
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