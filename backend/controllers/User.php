<?php 
    require_once __DIR__ . '/../models/User.php';
    require_once __DIR__ . '/../helpers/session_helper.php';
    
    class Users {
        private $userModel;

        public function __construct(){
            $this->userModel = new User;
        }

        public function register(){
            //saitizam data primita din post 
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            //init data 
            $data = [
                'prenume' => trim($_POST['prenume']),
                'nume' => trim($_POST['nume']),
                'email' => trim($_POST['email']),
                'password_hash' => trim($_POST['password_hash']),
                // 'psw-conf' => trim($_POST['psw-conf']),
                'user_type' => trim($_POST['user_type'])
            ];


            //validare inputuri 
            if(empty($data['prenume']) || empty($data['nume']) || empty($data['email']) || empty($data['password_hash']) || empty(trim($_POST['psw-conf'])) ){
                flash("register", "Please fill out all inputs");
                redirect("../../frontend/Login/SignUp.php");
            }

            if(!preg_match("/^[a-zA-Z]*$/", $data['prenume'])){
                flash("register", "Invalid first name. Don't use special characters or numbers!");
                redirect("../../frontend/Login/SignUp.php");
            } 

            if(!preg_match("/^[a-zA-Z]*$/", $data['nume'])){
                flash("register", "Invalid last name. Don't use special characters or numbers!");
                redirect("../../frontend/Login/SignUp.php");
            } 

          
            if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                flash("register", "Invalid email");
                redirect("../../frontend/Login/SignUp.php");
            }

            if(strlen($data['password_hash']) < 6){
                flash("register", "Invalid password");
                redirect("../../frontend/Login/SignUp.php"); 
            } else if($data['password_hash'] !== trim($_POST['psw-conf'])){
                flash("register", "Passwords don't match");
                redirect("../../frontend/Login/SignUp.php");
            }

            if($this->userModel->findUserByEmail($data['email'])){
                flash("register", "Email already used");
                redirect("../../frontend/Login/SignUp.php");
            }

            $data['password_hash'] = password_hash($data['password_hash'], PASSWORD_DEFAULT);

            // all tests have passed
            if($this->userModel->register($data)){
                redirect("../../frontend/Login/LoginPage.php");
            }else{
                die("Something went wrong");
            }

        }
        public function login(){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    
            //Init data
            $data=[
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password'])
            ];
    
            if(empty($data['email']) || empty($data['password'])){
                flash("login", "Please fill out all inputs");
                header("location: ../../frontend/Login/LoginPage.php");
                exit();
            }
                //Check for user/email
            if($this->userModel->findUserByEmail($data['email'])){
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);
                if($loggedInUser){
                    //Create session
                    $this->createUserSession($loggedInUser);
                }else{
                    flash("login", "Password Incorrect");
                    redirect("../../frontend/Login/LoginPage.php");
                }
            }else{
                flash("login", "No user found");
                redirect("../../frontend/Login/LoginPage.php");
            }
        }  
        public function createUserSession($loggedInUser){
            $_SESSION['id'] = $loggedInUser->id;
            $_SESSION['user_type'] = $loggedInUser->user_type;
            $_SESSION['email'] = $loggedInUser->email;
            if ($loggedInUser->user_type == 'client') {
                redirect("../../frontend/ClientLoggedIn/client_profile/client_profile.php");
            } elseif ($loggedInUser->user_type == 'freelancer') {
                redirect("../../frontend/FreelancerLoggedIn/freelancer_profile/freelancer_profile.php");
            } else {
                redirect("../../frontend/Login/LoginPage.php");
            }
        }  
        public function logout(){
            unset($_SESSION['id']);
            unset($_SESSION['user_type']);
            unset($_SESSION['email']);
            session_destroy();
            redirect("../../frontend/Login/LoginPage.php");
        }
        public function displayProfile(){
            if(!isset($_SESSION)){
                session_start();
            }
            if(!isset($_SESSION['id'])){
                redirect("../../frontend/Login/LoginPage.php");
            }
            $userProfile = $this->userModel->getUserProfileById($_SESSION['id']);
            
            if(!$userProfile){
                die("aici Profile not found.");
            }
            return $userProfile;
        }
        public function updateProfile($data){
            if(!isset($_SESSION)){
                session_start();
            }
            if(!isset($_SESSION['id'])){
                redirect("../../frontend/Login/LoginPage.php");
            }
            $userId = $_SESSION['id'];
            $updatedData = [
                'name' => trim($data['name']),
                'phone_number' => trim($data['phone_number']),
                'email' => trim($data['email']),
                'address' => trim($data['address'])
            ];
            if($this->userModel->updateProfile($userId, $updatedData)){
                header('Content-Type: application/json');
                echo json_encode(['message' => 'Profile updated successfully']);
                } else {
                    http_response_code(500);
                    header('Content-Type: application/json');
                    echo json_encode(['message' => 'Failed to update profile']);
                    // redirect("../../frontend/FreelancerLoggedIn/freelancer_profile/freelancer_profile.php");
                    
                    }
                // redirect("../../frontend/FreelancerLoggedIn/freelancer_profile/freelancer_profile.php");
        }
        public function deleteProfile(){
            if(!isset($_SESSION)){
                session_start();
            }
    
            if(!isset($_SESSION['id'])){
                header('Content-Type: application/json');
                echo json_encode(['message' => 'Unauthorized']);
                exit();
            }
    
            $userId = $_SESSION['id'];
            if($this->userModel->deleteProfile($userId)){
                session_destroy();
                header('Content-Type: application/json');
                echo json_encode(['message' => 'Profile deleted successfully']);
            } else {
                http_response_code(500);
                header('Content-Type: application/json');
                echo json_encode(['message' => 'Failed to delete profile']);
            }
        }

}

    $init = new Users;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_POST['type']) {
        case 'register':
            $init->register();
            break;
        case 'login':
            $init->login();
            break;
        default:
            redirect("./SignUp.php");
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);
    // if ($data && $data['type'] === 'update_profile') {
        $init->updateProfile($data);
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            $init->deleteProfile();
}  
// else {
//         http_response_code(405);
//         echo json_encode(["message" => "Invalid request."]);
// }
