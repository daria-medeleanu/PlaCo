<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/PlaCo/backend/models/User.php';

class ProjectDetails {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
        session_start(); // Start the session
    }

    public function getProjectDetails() {
        if (!isset($_GET['project_id'])) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Project ID is required here']);
            return;
        }

        $projectId = $_GET['project_id'];
        $freelancerId = $_SESSION['id']; 
        $projectDetails = $this->userModel->getProjectDetails($projectId, $freelancerId);
        echo json_encode($projectDetails);
    }

    public function saveOffer() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $data['freelancer_id'] = $_SESSION['id']; // Assuming user ID is stored in the session

        if ($this->userModel->saveOffer($data)) {
            echo json_encode(['status' => 'success', 'message' => 'Offer submitted successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Failed to submit offer']);
        }
    }
}

$projectController = new ProjectDetails();
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $projectController->getProjectDetails();
        break;
    case 'POST':
        $projectController->saveOffer();
        break;
    default:
        http_response_code(405);
        echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed']);
        break;
}
