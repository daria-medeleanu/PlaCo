<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/PlaCo/backend/models/User.php';

class Portfolio{
    private $userModel;

    public function __construct(){
        $this->userModel = new User();
        session_start();
    }

    public function getPortfolioItems() {
        if (!isset($_SESSION['id'])) {
            http_response_code(401);
            echo json_encode(['status' => 'error', 'message' => 'User not authenticated']);
            return;
        }
        $userId = $_SESSION['id']; 
        $portfolioItems = $this->userModel->getPortfolioItemsByUserId($userId);
        echo json_encode($portfolioItems);
    }
}

$portfolio = new Portfolio();
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        header('Content-Type: application/json');
        $portfolio->getPortfolioItems();
        break;
    
    default:
        http_response_code(405);
        echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed']);
        break;
}
?>