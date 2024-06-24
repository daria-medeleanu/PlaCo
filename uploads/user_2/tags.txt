<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/PlaCo/backend/models/User.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/PlaCo/backend/helpers/session_helper.php';

class Tags {
    private $userModel;

    public function __construct(){
        $this->userModel = new User;
    }

    public function fetchTags() {
        $tags = $this->userModel->fetchTags();
        echo json_encode($tags);
    }
    public function fetchSkills() {
        $skills = $this->userModel->fetchSkills();
        echo json_encode($skills);
    }

    public function addTag() {
        $data = json_decode(file_get_contents('php://input'), true);
    
        if (isset($data['tag_name'])) {
            $tag_name = trim($data['tag_name']);
    
            if (!$this->userModel->tagExists($tag_name)) {
                $result = $this->userModel->insertTag($tag_name);
                echo json_encode(['status' => 'success', 'message' => 'Tag added successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Tag already exists']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Tag name is required']);
        }
    }
    public function addSkill() {
        $data = json_decode(file_get_contents('php://input'), true);
    
        if (isset($data['skill_name'])) {
            $skill_name = trim($data['skill_name']);
    
            if (!$this->userModel->skillExists($skill_name)) {
                $result = $this->userModel->insertSkill($skill_name);
                echo json_encode(['status' => 'success', 'message' => 'Skill added successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Skill already exists']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Skill name is required']);
        }
    }
}

$tags = new Tags;

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
         header('Content-Type: application/json');
            $data = json_decode(file_get_contents('php://input'), true);
                switch ($data['type']) {
                    case 'add_tag':
                        $tags->addTag();
                        break;
                    case 'add_skill':
                            $tags->addSkill();
                            break;
                    default:
                        http_response_code(400);
                        echo json_encode(['status' => 'error', 'message' => 'Invalid action type']);
                        break;
                }
        break;

    case 'GET':
        header('Content-Type: application/json');
        if (isset($_GET['type'])) {
            switch ($_GET['type']) {
                case 'fetch_tags':
                    $tags->fetchTags();
                    break;
                case 'fetch_skills':
                    $tags->fetchSkills();
                    break;
                default:
                    http_response_code(400);
                    echo json_encode(['status' => 'error', 'message' => 'Invalid type']);
                    break;
            }
        } else {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Type is required']);
        }
        break;


    default:
        http_response_code(405);
        echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed']);
        break;
}
