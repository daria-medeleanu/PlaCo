<?php

class PagesController {
    private $pages = [
       'home' => '/../../frontend/Login/DashboardLogin.php',
       'HowItWorks'=> '/../../frontend/Login/HowItWorks.php',
       'ForgotPassword'=> '/../../frontend/Login/ForgotPass.php',
       'login'=> '/../../frontend/Login/LoginPage.php',
       'register'=> '/../../frontend/SignUp.php',
       'add_to_portfolio'=> '/../../frontend/FreelancerLoggedIn/FreelancerProfile/add_to_portfolio.php',
       'freelancer_profile'=>'/../../frontend/FreelancerLoggedIn/FreelancerProfile/freelancer_profile.php',
       'my_portfolio'=>'/../../frontend/FreelancerLoggedIn/FreelancerProfile/my_portfolio.php',
       'project'=>'/../../frontend/FreelancerLoggedIn/search_for_jobs/project.php',
       'search_for_jobs'=>'/../../frontend/FreelancerLoggedIn/search_for_jobs/search_for_jobs.php',
       'settings_freelancer'=>'/../../frontend/FreelancerLoggedIn/settings/settings.php',
        'active_projects'=>'/../../frontend/ClientLoggedIn/client_profile/active_projects.php',
        'client_profile'=>'/../../frontend/ClientLoggedIn/client_profile/client_profile.php',
        'finished_projects'=>'/../../frontend/ClientLoggedIn/client_profile/finished_projects.php',
        'post_a_project'=>'/../../frontend/ClientLoggedIn/client_profile/post_a_new_project.php',
        'discover_freelancers'=>'/../../frontend/ClientLoggedIn/discover_freelancers/discover_freelancers.php',
        'settings_client'=>'/../../frontend/ClientLoggedIn/settings/settings.php',
    ];

    public function handleRequest() {
        $page = $_GET['page'] ?? 'home';

        if (array_key_exists($page, $this->pages)) {
            return $this->pages[$page];
        } else {
            throw new Exception("Pagina nu a fost găsită");
        }
    }
}

class View {
    public function render($page) {
        require_once __DIR__ . $page;
    }
}

try {
    $controller = new PagesController();
    $view = new View();

    $page = $controller->handleRequest();
    $view->render($page);
} catch (Exception $e) {
    echo $e->getMessage();
}

