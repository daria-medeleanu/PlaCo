<?php
require_once './backend/controllers/pages-controller.php';

// Cream o instanță a controllerului și gestionăm cererea
$controller = new PagesController();
$view = new View();

try {
    $page = $controller->handleRequest();
    $view->render($page);
} catch (Exception $e) {
    echo $e->getMessage();
}
