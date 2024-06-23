<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/PlaCo/backend/models/User.php';

class ProjectsController {
    private $userModel;

    public function __construct(){
        $this->userModel = new User();
    }

    public function getProjects() {
        return $this->userModel->getAllProjects();
    }
}

$projectsController = new ProjectsController();
$projects = $projectsController->getProjects();
header('Content-Type: application/json');
echo json_encode($projects);