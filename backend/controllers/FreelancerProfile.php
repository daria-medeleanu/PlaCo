
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/PlaCo/backend/models/User.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/PlaCo/util/vendor/autoload.php';
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

class FreelancerProfile {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
        session_start();
    }

    public function displayProfile() {
        $headers = apache_request_headers();
        if (!isset($headers['Authorization'])) {
            http_response_code(401);
            echo json_encode(["message" => "Unauthorized"]);
            return;
        }

        $authHeader = $headers['Authorization'];
        $token = null;

        // Extract JWT token from Authorization header (Bearer token)
        if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        if (!$token) {
            http_response_code(401);
            echo json_encode(["message" => "Unauthorized"]);
            return;
        }

        try {
            // Decode and verify JWT token
            $publicKey = "Aceasta este o cheie supersecreta";
            $decoded = JWT::decode($token, new Key($publicKey, 'HS256'));

            // Check if the decoded token contains necessary information (like user ID)
            if (!isset($decoded->user_id)) {
                http_response_code(401);
                echo json_encode(["message" => "Unauthorized"]);
                return;
            }

            // Retrieve freelancer ID from query string
            $freelancerId = isset($_GET['id']) ? $_GET['id'] : null;
           // console_log($freelancerId );
            if (!$freelancerId) {
                http_response_code(400);
                echo json_encode(["message" => "Bad Request"]);
                return;
            }
            error_log("Freelancer ID: " . $freelancerId);
            // Retrieve user profile using freelancer ID
            $userProfile = $this->userModel->getUserProfileById($freelancerId);

            if (!$userProfile) {
                http_response_code(404);
                echo json_encode(["message" => "Profile not found"]);
                return;
            }

            // Return user profile as JSON response
            http_response_code(200);
            echo json_encode($userProfile);
            return;

        } catch (Exception $e) {
            http_response_code(401);
            echo json_encode(["message" => "Unauthorized"]);
            return;
        }
    }
}
$freelancer= new FreelancerProfile();
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        //console_log("aici");
        $freelancer->displayProfile();
        break;
    default:
        http_response_code(405); // Method Not Allowed
        echo json_encode(["message" => "Method Not Allowed"]);
        break;
}