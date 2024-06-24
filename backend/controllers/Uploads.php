<?php 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/PlaCo/backend/models/User.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/PlaCo/backend/helpers/session_helper.php';
    session_start();

    class Uploads {
        private $userModel;
        private $maxFileSize = 5 * 1024 * 1024; 
        private $allowedExtensions = ['txt', 'pdf', 'jpg', 'png', 'docs', 'docx'];

        public function __construct(){
            $this->userModel = new User;
        }
        public function uploadFiles($files, $userId, $project_id) {
            
        $userDir = $_SERVER['DOCUMENT_ROOT'] . "/PlaCo/uploads/user_$userId/";

        if (!is_dir($userDir)) {
            mkdir($userDir, 0755, true);
        }

        $uploadedFiles = [];
        foreach ($files['name'] as $key => $fileName) {
            $fileTmpName = $files['tmp_name'][$key];
            $fileSize = $files['size'][$key];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if ($fileSize > $this->maxFileSize) {
                echo json_encode(['message' => "File $fileName exceeds the maximum size of 5MB"]);
                return false;
            }

            if (!in_array($fileExtension, $this->allowedExtensions)) {
                echo json_encode(['message' => "File $fileName has an invalid extension. Only txt, pdf, jpg, png, docs, docx are allowed."]);
                return false;
            }

            $targetFile = $userDir . basename($fileName);
            if (move_uploaded_file($fileTmpName, $targetFile)) {
                $uploadedFiles[] = $fileName;
                $this->userModel->saveUpload([
                    'project_item_id' => $project_id, 
                    'image_path' => $targetFile
                ]);
            }
        }

        if (!empty($uploadedFiles)) {
            return true;
        }

        return false;
        }
    }

    $uploads = new Uploads;

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            // $files = $_FILES['file'];
            $project_id = isset($_POST['project_id']) ? $_POST['project_id'] : null;
            // console_log($project_id);
            $files = isset($_FILES['file']) ? $_FILES['file'] : null;
            if ($files || isset($files['name'][0]) || !empty($files['name'][0])) {
                if (isset($_SESSION['id'])) {
                    $userId = $_SESSION['id'];
    
                    if ($uploads->uploadFiles($files, $userId, $project_id)) {
                        echo json_encode(['message' => 'Files successfully uploaded']);
                    } 
                } else {
                    echo json_encode(['message' => 'User not logged in']);
                }
            }
            break;
        default:
            http_response_code(405);
            echo json_encode(["message" => "Method Not Allowed"]);
            break;
    }

