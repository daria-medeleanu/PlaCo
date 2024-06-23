<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/PlaCo/backend/models/User.php';

class ProjectsController {
    private $userModel;

    public function __construct(){
        $this->userModel = new User();
    }

    // public function getProjects() {
    //     $projects = $this->userModel->getAllProjects();
    //     echo json_encode($projects); // Echo the projects as JSON
    // }
    public function getProjects() {
        $city = isset($_GET['city']) ? $_GET['city'] : null;
        $skills = isset($_GET['skills']) ? $_GET['skills'] : null;
        $search = isset($_GET['search']) ? $_GET['search'] : null;

        $projects = $this->userModel->getAllProjects($city, $skills, $search);
        echo json_encode($projects); // Echo the projects as JSON
    }
    
}
$projects = new ProjectsController();
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        header('Content-Type: application/json');
        if (isset($_GET['type'])) {
            switch ($_GET['type']) {
                case 'fetch_projects':
                    $projects->getProjects();
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