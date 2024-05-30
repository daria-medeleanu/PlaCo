<? php 
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
                'fname' => trim($_POST['fname']),
                'lname' => trim($_POST['lname']),
                'email' => trim($_POST['email']),
                'psw' => trim($_POST['psw']),
                'psw-conf' => trim($_POST['psw-conf'])
            ];

            //validare inputuri 
            if(empty($data['fname']) || empty($data['lname']) || empty($data['email']) || empty($data['psw']) || empty($data['psw-conf'])){
                flash("register", "Please fill out all inputs");
                redirect("../../frontend/Login/SignUp.php");
            }

            // if(!preg_match("/^[a-zA-Z0-9]*$/", $data['usersUid'])){
            //     flash("register", "Invalid username");
            //     redirect("../signup.php");
            // }

            // if(!filter_var($data['usersEmail'], FILTER_VALIDATE_EMAIL)){
            //     flash("register", "Invalid email");
            //     redirect("../signup.php");
            // }

            if(strlen($data['usersPwd']) < 6){
                flash("register", "Invalid password");
                redirect("../../frontend/Login/SignUp.php"); }
            // } else if($data['usersPwd'] !== $data['pwdRepeat']){
            //     flash("register", "Passwords don't match");
            //     redirect("../signup.php");
            // }

        }
    }