<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/PlaCo/backend/models/User.php';

class Freelancers {
    private $userModel;

    public function __construct(){
        $this->userModel = new User();
        session_start(); // Start the session
    }

    public function getFreelancers() {
        $city = isset($_GET['city']) ? $_GET['city'] : null;
        $skills = isset($_GET['skills']) ? $_GET['skills'] : null;
        $search = isset($_GET['search']) ? $_GET['search'] : null;

        $freelancers = $this->userModel->getFreelancers($city, $skills, $search);
        echo json_encode($freelancers);
    }
}

$freelancers = new Freelancers();
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        header('Content-Type: application/json');
        $freelancers->getFreelancers();
        break;
    
    default:
        http_response_code(405);
        echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed']);
        break;
}