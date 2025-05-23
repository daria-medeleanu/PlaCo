<?php 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/PlaCo/backend/libraries/Database.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/PlaCo/backend/helpers/session_helper.php';
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
            $sql = 'UPDATE user_profile SET name = :name, phone_number = :phone_number, email = :email, address = :address';
            if (isset($data['profile_picture'])) {
                $sql .= ', profile_picture = :profile_picture';
            }
            $sql .= ' WHERE id = :id';
            
            $this->db->query($sql);
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':phone_number', $data['phone_number']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':address', $data['address']);
            if (isset($data['profile_picture'])) {
                $this->db->bind(':profile_picture', $data['profile_picture']);
            }
            $this->db->bind(':id', $id);
            return $this->db->execute();
        }
        public function deleteProfile($id) {
            $this->db->query('DELETE FROM users WHERE id = :id');
            $this->db->bind(':id', $id);
    
            if($this->db->execute()) {
                $this->db->query('DELETE FROM user_profile WHERE id = :id');
                $this->db->bind(':id', $id);
                return $this->db->execute();
            } else {
                return false;
            }
        }
        public function saveUploadProject($data){
            $this->db->query('INSERT INTO images_projects (project_item_id, image_path) 
                              VALUES (:project_item_id, :image_path)');
            
            $this->db->bind(':project_item_id', $data['project_item_id']);
            $this->db->bind(':image_path', $data['image_path']);
    
            if ($this->db->execute()) {
                return $this->db->lastInsertId(); 
            } else {
                return false; 
            }
        }
        public function saveUploadPortfolio($data){
            $this->db->query('INSERT INTO images_portfolios (portfolio_item_id, image_path) 
                              VALUES (:portfolio_item_id, :image_path)');
            
            $this->db->bind(':portfolio_item_id', $data['portfolio_item_id']);
            $this->db->bind(':image_path', $data['image_path']);
            // console_log($data);
            if ($this->db->execute()) {
                return $this->db->lastInsertId(); 
            } else {
                return false; 
            }
        }

        public function saveProject($data) {
            $this->db->query('INSERT INTO project (title, description, currency, budget, city, owner_id) 
                              VALUES (:title, :description, :currency, :budget, :city, :owner_id)');
            
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':description', $data['description']);
            $this->db->bind(':currency', $data['currency']);
            $this->db->bind(':city', $data['city']);
            $this->db->bind(':budget', $data['budget']);
            $this->db->bind(':owner_id', $data['owner_id']);
    
            if ($this->db->execute()) {
                return $this->db->lastInsertId(); 
            } else {
                return false; 
            }
        }
        public function savePortfolio($data) {
            $this->db->query('INSERT INTO portfolio_item (title, description, owner_id) 
                              VALUES (:title, :description, :owner_id)');
            
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':description', $data['description']);
            $this->db->bind(':owner_id', $data['owner_id']);
    
            if ($this->db->execute()) {
                return $this->db->lastInsertId(); 
            } else {
                return false; 
            }
        }
        public function fetchTags() {
            $query = "SELECT * FROM tags";
            $this->db->query($query);
            return $this->db->resultSet();
        }
        public function fetchSkills() {
            $query = "SELECT * FROM skills";
            $this->db->query($query);
            return $this->db->resultSet();
        }
        public function getOrCreateTag($tagName) {
            if (!$this->tagExists($tagName)) {
                $this->insertTag($tagName);
            }
            return $this->getTagId($tagName);
        }
        public function getOrCreateSkill($skillName) {
            if (!$this->skillExists($skillName)) {
                $this->insertSkill($skillName);
            }
            return $this->getSkillId($skillName);
        }
        public function getTagId($tagName) {
            $this->db->query('SELECT id FROM tags WHERE tag_name = :tag_name');
            $this->db->bind(':tag_name', $tagName);
            return $this->db->single()->id;
        }
        public function getSkillId($skillName) {
            $this->db->query('SELECT id FROM skills WHERE skill_name = :skill_name');
            $this->db->bind(':skill_name', $skillName);
            return $this->db->single()->id;
        }
        public function tagExists($tag_name) {
            $query = "SELECT * FROM tags WHERE tag_name = :tag_name";
            $this->db->query($query);
            $this->db->bind(':tag_name', $tag_name);
            $this->db->execute();
            return $this->db->rowCount() > 0;
        }
        public function skillExists($skill_name) {
            $query = "SELECT * FROM skills WHERE skill_name = :skill_name";
            $this->db->query($query);
            $this->db->bind(':skill_name', $skill_name);
            $this->db->execute();
            return $this->db->rowCount() > 0;
        }
        public function insertTag($tag_name) {
            $query = "INSERT INTO tags (tag_name) VALUES (:tag_name)";
            $this->db->query($query);
            $this->db->bind(':tag_name', $tag_name);
            if ($this->db->execute()) {
                return array('status' => 'success', 'message' => 'Tag added successfully.');
            } else {
                return array('status' => 'error', 'message' => 'Failed to add tag.');
            }
        }
        public function insertSkill($skill_name) {
            $query = "INSERT INTO skills (skill_name) VALUES (:skill_name)";
            $this->db->query($query);
            $this->db->bind(':skill_name', $skill_name);
            if ($this->db->execute()) {
                return array('status' => 'success', 'message' => 'Skill added successfully.');
            } else {
                return array('status' => 'error', 'message' => 'Failed to add skill.');
            }
        }
        public function linkProjectTag($projectId, $tagId) {
            $this->db->query('INSERT INTO project_tags (project_id, tag_id) VALUES (:project_id, :tag_id)');
            $this->db->bind(':project_id', $projectId);
            $this->db->bind(':tag_id', $tagId);
            return $this->db->execute();
        }
        public function linkPortfolioSkill($portfolioId, $skillId) {
            $this->db->query('INSERT INTO portfolio_skills (portfolio_item_id, skill_id) VALUES (:portfolio_item_id, :skill_id)');
            $this->db->bind(':portfolio_item_id', $portfolioId);
            $this->db->bind(':skill_id', $skillId);
            return $this->db->execute();
        }
        
        public function getAllProjects($city = null, $skills = null, $search = null) {
            $query = "SELECT * FROM project WHERE 1=1";
            $bindParams = [];
    
            if ($city && $city!=='all') {
                $query .= " AND city = :city";
                $bindParams[':city'] = $city;
            }
    
            if ($search) {
                $query .= " AND (title LIKE :search OR description LIKE :search)";
                $bindParams[':search'] = '%' . $search . '%';
            }
    
            $this->db->query($query);
            foreach ($bindParams as $param => $value) {
                $this->db->bind($param, $value);
            }
    
            $projects = $this->db->resultSetAssoc();
    
            foreach ($projects as &$project) {
                $project['tags'] = $this->getProjectTags($project['id']);
            }
    
            if ($skills) {
                $skillsArray = explode(',', $skills);
                $projects = array_filter($projects, function($project) use ($skillsArray) {
                    $projectSkills = array_column($project['tags'], 'tag_name');
                    return !array_diff($skillsArray, $projectSkills);
                });
            }
    
            return $projects;
        }
    
        private function getProjectTags($projectId) {
            $query = "SELECT t.tag_name FROM project_tags pt
                      JOIN tags t ON pt.tag_id = t.id
                      WHERE pt.project_id = :project_id";
            $this->db->query($query);
            $this->db->bind(':project_id', $projectId);
            return $this->db->resultSetAssoc();
        }
        public function getPortfolioItemsByUserId($userId) {
            $query = "SELECT title FROM portfolio_item WHERE owner_id = :user_id";
            $this->db->query($query);
            $this->db->bind(':user_id', $userId);
            return $this->db->resultSetAssoc();
        }
        public function getActiveProjectsByUserId($userId) {
            $query = "SELECT id, title FROM project WHERE owner_id = :user_id AND state = 'activ'";
            $this->db->query($query);
            $this->db->bind(':user_id', $userId);
            return $this->db->resultSetAssoc();
        }
        public function getFinishedProjectsByUserId($userId) {
            $query = "SELECT id, title FROM project WHERE owner_id = :user_id AND state = 'finished'";
            $this->db->query($query);
            $this->db->bind(':user_id', $userId);
            return $this->db->resultSetAssoc();
        }
        public function getProjectsInProgress($userId) {
            $query = "SELECT id, title FROM project WHERE freelancer_chosen_id=:user_id";
            $this->db->query($query);
            $this->db->bind(':user_id', $userId);
            return $this->db->resultSetAssoc();
        }
        public function getFreelancers($city = null, $skills = null, $search = null) {
            $query = "SELECT * FROM user_profile WHERE user_type = 'freelancer'";
            $bindParams = [];
    
            if ($city && $city !== 'all') {
                $query .= " AND address LIKE :city";
                $bindParams[':city'] = '%' . $city . '%';
            }
    
            if ($search) {
                $query .= " AND (name LIKE :search OR address LIKE :search)";
                $bindParams[':search'] = '%' . $search . '%';
            }
    
            $this->db->query($query);
            foreach ($bindParams as $param => $value) {
                $this->db->bind($param, $value);
            }
    
            $freelancers = $this->db->resultSetAssoc();
    
            foreach ($freelancers as &$freelancer) {
                $freelancer['skills'] = $this->getFreelancerSkills($freelancer['id']);
            }
    
            if ($skills) {
                $skillsArray = explode(',', $skills);
                $freelancers = array_filter($freelancers, function($freelancer) use ($skillsArray) {
                    return !array_diff($skillsArray, $freelancer['skills']);
                });
            }
    
            return $freelancers;
        }
    
        private function getFreelancerSkills($freelancerId) {
            $query = "SELECT DISTINCT s.skill_name 
                      FROM skills s 
                      JOIN portfolio_skills ps ON s.id = ps.skill_id 
                      JOIN portfolio_item pi ON ps.portfolio_item_id = pi.id 
                      WHERE pi.owner_id = :freelancer_id";
            $this->db->query($query);
            $this->db->bind(':freelancer_id', $freelancerId);
            $skills = $this->db->resultSetAssoc();
    
            return array_column($skills, 'skill_name');
        }
        public function getProjectDetails($projectId, $freelancerId) {
            $query = "SELECT * FROM project WHERE id = :project_id";
            $this->db->query($query);
            $this->db->bind(':project_id', $projectId);
            $projectDetails = $this->db->single();

            $projectDetails->applied = $this->hasApplied($projectId, $freelancerId);

            return $projectDetails;
        }
        public function getProjectDetailsState($projectId, $freelancerId) {
            $query = "SELECT * FROM project WHERE id = :project_id";
            $this->db->query($query);
            $this->db->bind(':project_id', $projectId);
            $projectDetails = $this->db->single();

            $projectDetails->state = $this->hasFinished($projectId);

            return $projectDetails;
        }
        public function hasFinished($projectId) {
            $query = "SELECT state FROM project WHERE id = :project_id";
            $this->db->query($query);
            $this->db->bind(':project_id', $projectId);
            $result = $this->db->single();
        
            if ($result) {
                return $result->state === 'finished' ? true : false;
            } else {
                return false; 
            }
        }
        public function finishProject($projectId) {
            $query = "UPDATE project SET state = 'finished' WHERE id = :project_id";
            $this->db->query($query);
            $this->db->bind(':project_id', $projectId);
            return $this->db->execute();
        }

        public function getProjectDetailsClient($projectId) {
            $query = "SELECT * FROM project WHERE id = :project_id";
            $this->db->query($query);
            $this->db->bind(':project_id', $projectId);
            return $this->db->single();
        }
        public function getChosenFreelancer($projectId) {
            $query = "SELECT freelancer_chosen_id FROM project WHERE id = :project_id";
            $this->db->query($query);
            $this->db->bind(':project_id', $projectId);
            return $this->db->single();
        }
        public function getProjectOffers($projectId) {
            $query = "SELECT o.budget_offered, o.motivation, u.name, o.freelancer_id 
              FROM offers o
              INNER JOIN user_profile u ON o.freelancer_id = u.id
              WHERE o.project_id = :project_id";
            $this->db->query($query);
            $this->db->bind(':project_id', $projectId);
            return $this->db->resultSetAssoc();
        }
        
        public function hasApplied($projectId, $freelancerId) {
            $query = "SELECT COUNT(*) as count FROM offers WHERE project_id = :project_id AND freelancer_id = :freelancer_id";
            $this->db->query($query);
            $this->db->bind(':project_id', $projectId);
            $this->db->bind(':freelancer_id', $freelancerId);
            $result = $this->db->single();
            return $result->count > 0;
        }
    
        public function saveOffer($freelancer_id, $projectId, $budget_offered, $motivation) {
            $query = "INSERT INTO offers (project_id, freelancer_id, budget_offered, motivation) 
                      VALUES (:project_id, :freelancer_id, :budget_offered, :motivation)";
            $this->db->query($query);
            $this->db->bind(':project_id', $projectId);
            $this->db->bind(':freelancer_id', $freelancer_id);
            $this->db->bind(':budget_offered', $budget_offered);
            $this->db->bind(':motivation', $motivation);
    
            return $this->db->execute();
        }
        public function chooseFreelancer($projectId, $freelancerChosenId){
            $query ="UPDATE project SET freelancer_chosen_id=:freelancer_id, progress=true WHERE id = :project_id ";
            $this->db->query($query);
            $this->db->bind(':freelancer_id', $freelancerChosenId);
            $this->db->bind(':project_id', $projectId);
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }
        
        public function getProjectProgressStatus($projectId) {
            $query = "SELECT progress FROM project WHERE id = :project_id";
            $this->db->query($query);
            $this->db->bind(':project_id', $projectId);
            $result = $this->db->single();
            return $result ? $result->progress : false;
        }
        

    }


