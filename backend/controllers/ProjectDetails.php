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
    public function getProjectDetailsState() {
        if (!isset($_GET['project_id'])) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Project ID is required here']);
            return;
        }

        $projectId = $_GET['project_id'];
        $freelancerId = $_SESSION['id']; 
        $projectDetails = $this->userModel->getProjectDetailsState($projectId, $freelancerId);
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
        $freelancer=$this->userModel->getChosenFreelancer($projectId);
        $projectOffers = $this->userModel->getProjectOffers($projectId);
        $progressStatus = $this->userModel->getProjectProgressStatus($projectId);
    $projectData = [
        'projectDetails' => $projectDetails,
        'projectOffers' => $projectOffers,
        'progress' => $progressStatus,
        'freelancer'=>$freelancer
    ];

   // console_log($projectData);
    echo  json_encode($projectData);
    }

     public function finish($projectId) {
        $result = $this->userModel->finishProject($projectId);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Project marked as finished']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Failed to mark project as finished']);
        }
    }

    public function saveOffer() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $freelancer_id = $_SESSION['id']; // Assuming user ID is stored in the session
        $projectId = $data['project_id'];
        $budget_offered = $data['budget_offered'];
        $motivation = $data['motivation'];
        if ($this->userModel->saveOffer($freelancer_id, $projectId, $budget_offered, $motivation)) {
            echo json_encode(['status' => 'success', 'message' => 'Offer submitted successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Failed to submit offer']);
        }
    }
    public function chooseFreelancer() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $projectId = $data['project_id'];
        $freelancerChosenId = $data['freelancer_chosen_id'];

        if ($this->userModel->chooseFreelancer($projectId, $freelancerChosenId)) {
            echo json_encode(['status' => 'success', 'message' => 'Freelancer chosen successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Failed to choose freelancer']);
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
                case 'project_details_finishing':
                        $project->getProjectDetailsState();
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
            header('Content-Type: application/json');
            $data = json_decode(file_get_contents('php://input'), true);

            if (isset($data['type'])) {
                switch ($data['type']) {
                    case 'choose_freelancer':
                        $project->chooseFreelancer();
                        break;
                    case 'save_offer':
                        $project->saveOffer();
                        break;
                    case 'finish_project':
                        if (!isset($data['project_id'])) {
                            http_response_code(400);
                            echo json_encode(['status' => 'error', 'message' => 'Project ID is required']);
                            break;
                        }
                        $projectId = $data['project_id'];
                        $project->finish($projectId);
                            break;
                    default:
                        http_response_code(400);
                        echo json_encode(['status' => 'error', 'message' => 'Invalid action type']);
                        break;
                }
            } else {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'Action type is required']);
            }
    break;
    default:
        http_response_code(405);
        echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed']);
        break;
}
