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
    public function getProjectDetailsClient() {
        if (!isset($_GET['project_id'])) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Project ID is required here']);
            return;
        }

        $projectId = $_GET['project_id'];
        $projectDetails = $this->userModel->getProjectDetailsClient($projectId);
        $projectOffers = $this->userModel->getProjectOffers($projectId);
    
    $projectData = [
        'projectDetails' => $projectDetails,
        'projectOffers' => $projectOffers
    ];

   // console_log($projectData);
    echo  json_encode($projectData);
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

$project = new ProjectDetails();
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        header('Content-Type: application/json');
        if (isset($_GET['type'])) {
            switch ($_GET['type']) {
                case 'project_details':
                    $project->getProjectDetails();
                    break;
                case 'project_details_client':
                    $project->getProjectDetailsClient();
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
    case 'POST':
        $project->saveOffer();
        break;
    default:
        http_response_code(405);
        echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed']);
        break;
}
