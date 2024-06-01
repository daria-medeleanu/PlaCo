<?php 
    require_once '../libraries/Database.php';
    require_once '../helpers/session_helper.php';

    class User {
        private $db;
        
        public function __construct(){
            $this->db = new Database;
        }
        public function findUserByEmail($email) {
            $this->db->query('SELECT * FROM users WHERE email = :email');
            $this->db->bind(':email', $email);
            $row = $this->db->single();
            return $row ? true : false;
        }
        public function getUserByEmail($email) {
            $this->db->query('SELECT * FROM users WHERE email = :email');
            $this->db->bind(':email', $email);
            return $this->db->single();
        }
        public function register($data){
            // console_log('blabla');
            $this->db->query('INSERT INTO users (nume, prenume, email, password_hash, user_type) 
            VALUES (:nume, :prenume, :email, :password_hash, :user_type)');
            //bind values
            $this->db->bind(':nume', $data['nume']);
            $this->db->bind(':prenume', $data['prenume']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':password_hash', $data['password_hash']);
            $this->db->bind(':user_type', $data['user_type']);
    
            //execute
            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }
        public function login($email, $password) {
            if ($this->findUserByEmail($email)) {
                $user = $this->getUserByEmail($email);
                if (password_verify($password, $user->password_hash)) //functie predefinita sa verifice cu hash_ul
                {
                    return $user;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

    }


