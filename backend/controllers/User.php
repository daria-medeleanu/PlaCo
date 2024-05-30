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
                'user_type' => "client"
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

            // all tests have passed
            if($this->userModel->register($data)){
                redirect("../../frontend/Login/LoginPage.php");
            }else{
                die("Something went wrong");
            }

        }
}
    $init = new Users;

    //Ensure that user is sending a post request
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        switch($_POST['type']){
            case 'register':
                $init->register();
                break;
            default:
            redirect("./Signup.php");
        }
    }