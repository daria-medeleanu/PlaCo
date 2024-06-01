<?php 
    require_once '../models/User.php';
    require_once '../helpers/session_helper.php';
    
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
                redirect("../../frontend/ClientLoggedIn/client_profile.php");
            } elseif ($loggedInUser->user_type == 'freelancer') {
                redirect("../../frontend/FreelancerLoggedIn/freelancer_profile.php");
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
}

    $init = new Users;

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        switch($_POST['type']){
            case 'register':
                $init->register();
                break;
            case 'login':
                $init->login();
                break;
            default:
            redirect("./SignUp.php");
        }
        
    }
