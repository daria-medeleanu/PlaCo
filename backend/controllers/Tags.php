<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../helpers/session_helper.php';

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
                    echo json_encode($result);
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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = isset($_POST['action']) ? $_POST['action'] : '';
            switch ($action) {
                case 'addTag':
                    $tags->addTag();
                    break;
                default:
                    echo json_encode(array('status' => 'error', 'message' => 'Invalid action post.'));
                    break;
            }

         } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $action = isset($_GET['action']) ? $_GET['action'] : '';
        switch ($action) {
            case 'fetchTags':
                $tags->fetchTags();
                break;
            default:
                echo json_encode(array('status' => 'error', 'message' => 'Invalid action get.'));
                break;
        }
    }  else {
        http_response_code(405);
        echo json_encode(["message" => "Method Not Allowed"]);
    }