<?php 
    require_once '../librarie/Database.php';

    class User {
        private $db;
        
        public function __construct(){
            $this->db = new Database;
        }

        public function register($data){
            $this->db->query('INSERT INTO users (usersName, usersEmail, usersUid, usersPwd) 
            VALUES (:name, :email, :Uid, :password)');
            //bind values
            $this->db->bind(':name', $data['usersName']);
            $this->db->bind(':email', $data['usersEmail']);
            $this->db->bind(':Uid', $data['usersUid']);
            $this->db->bind(':password', $data['usersPwd']);
    
            //execute
            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }

    }


