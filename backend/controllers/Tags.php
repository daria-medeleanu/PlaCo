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
                    default:
                        http_response_code(400);
                        echo json_encode(['status' => 'error', 'message' => 'Invalid action type']);
                        break;
                }
        break;

    case 'GET':
        $tags->fetchTags();
        break;

    default:
        http_response_code(405);
        echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed']);
        break;
}
