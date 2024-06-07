<?php 
    // require_once '../libraries/Database.php';
    // require_once '../helpers/session_helper.php';
    require_once __DIR__ . '/../libraries/Database.php';
    require_once __DIR__ . '/../helpers/session_helper.php';
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
                $name = $data['nume'] . ' ' . $data['prenume'];
                $joining_date = date('Y-m-d');
                
                $this->db->query('INSERT INTO user_profile (email, name, joining_date, user_type) 
                                VALUES (:email, :name, :joining_date, :user_type)');
                $this->db->bind(':email', $data['email']);
                $this->db->bind(':name', $name);
                $this->db->bind(':joining_date', $joining_date);
                $this->db->bind(':user_type',$data['user_type']);
                return $this->db->execute();
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
        public function getUserProfileById($id){
            $this->db->query('SELECT * FROM user_profile where id = :id');
            $this->db->bind(':id',$id);
            return $this->db->single();
        }
        public function updateProfile($id, $data){
            $this->db->query('UPDATE user_profile SET name = :name, phone_number = :phone_number, email = :email, address = :address WHERE id = :id');
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':phone_number', $data['phone_number']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':address', $data['address']);
            $this->db->bind(':id', $id);
            return $this->db->execute();
        }

    }


