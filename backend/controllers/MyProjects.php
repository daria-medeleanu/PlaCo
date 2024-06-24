<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/PlaCo/backend/models/User.php';

class MyProjects{
    private $userModel;

    public function __construct(){
        $this->userModel = new User();
        session_start();
    }

    public function getActiveProjects() {
        if (!isset($_SESSION['id'])) {
            http_response_code(401);
            echo json_encode(['status' => 'error', 'message' => 'User not authenticated']);
            return;
        }
        $userId = $_SESSION['id']; 
        $activeProjects = $this->userModel->getActiveProjectsByUserId($userId);
        echo json_encode($activeProjects);
    }
    public function getFinishedProjects() {
        if (!isset($_SESSION['id'])) {
            http_response_code(401);
            echo json_encode(['status' => 'error', 'message' => 'User not authenticated']);
            return;
        }
        $userId = $_SESSION['id']; 
        $activeProjects = $this->userModel->getFinishedProjectsByUserId($userId);
        echo json_encode($activeProjects);
    }
    public function getProjectsInProgress() {
        if (!isset($_SESSION['id'])) {
            http_response_code(401);
            echo json_encode(['status' => 'error', 'message' => 'User not authenticated']);
            return;
        }
        $userId = $_SESSION['id']; 
        $projects = $this->userModel->getProjectsInProgress($userId);
        echo json_encode($projects);
    }

}

$projects = new MyProjects();
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        header('Content-Type: application/json');
        if (isset($_GET['type'])) {
            switch ($_GET['type']) {
                case 'active_projects':
                    $projects->getActiveProjects();
                    break;
                case 'finished_projects':
                    $projects->getFinishedProjects();
                    break;
                case 'projects_in_progress':
                    $projects->getProjectsInProgress();
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
?>