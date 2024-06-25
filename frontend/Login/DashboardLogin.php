<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . '/PlaCo/backend/helpers/session_helper.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/PlaCo/backend/controllers/pages-controller.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PlaCo Dashboard</title>
    <link rel="stylesheet" href="/PlaCo/frontend/Login/style/DashboardLogin.css"> 
    <link rel="shortcut icon" type="image/x-icon" href="/PlaCo/frontend/Login/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="header">
        <div class="nav-left">
            <a class="logo-pic" href="/home/home">
                <img src="/PlaCo/frontend/Login/logo.png" class="logo" alt="Logo">
                <div class="nav-btn-left">PlaCo</div>
            </a>
        </div>
        <div class="nav-right">
            <a href="/home/HowItWorks" class="nav-btn-left btn-dissapear">How it works</a>
            <div class="login-btn-wrapper">
                <a class="nav-btn-right" href="/home/login">Login</a>
            </div>
        </div>
        <a href="javascript:void(0);" class="icon" onclick="toggleMenu()">
            <i class="fa fa-bars"></i>
        </a>
    </div>
    <section class="box">
        <video src="/PlaCo/frontend/Login/video-start.mp4" autoplay muted loop></video>
        <h3>

        Welcome to PlaCo, a platform connecting construction professionals with potential clients. Whether you're looking for interior finishes, structural work, or a general contractor who can manage subcontractors, we have a wide range of professionals to meet your needs.
        </h3>
        <div class="btn-cr-acc-menu">
            <div class="boxBtn"><a href="/home/register" > Hire a freelancer</a> </div>
            <div class="boxBtn"><a href="/home/register"> Start Freelancing</a></div>
        </div>

    </section>

    <script>
        function toggleMenu() {
            var navRight = document.querySelector('.nav-right');
            navRight.classList.toggle('collapsed');
        }    
    </script>

    <section class="info">
        <h2>Features</h2>
        <p>PlaCo allows you to find and hire construction firms based on your project needs. You can browse through company profiles, view their past work, and read client reviews. 
            Our platform supports various construction specialties including interior finishes, structural work, and general contracting 
        </p>
        <p>Our platform provides detailed company profiles that include contact information, geographic areas of service, professional areas, and a portfolio of completed works. 
            Clients can view images of past projects to gauge the quality of work. After project completion, clients can rate the companies and leave comments, which help maintain the quality and reliability of our service providers.
        </p>

        <p>PlaCo offers a comprehensive platform where clients can seamlessly connect with a diverse array of construction firms.
             Our services cater to a wide range of professional specialties, including but not limited to, interior finishes, structural works, and general contracting.
              We enable clients to browse detailed profiles of construction companies, view extensive portfolios of completed projects, and read authentic reviews from previous clients. 
            This ensures that you make well-informed decisions when selecting a professional for your project.
        </p>
        
       
        <h2>How It Works</h2>
        <p>Our platform simplifies the process of hiring construction professionals. Clients can easily upload their technical project plans, work estimates, or detailed descriptions of the tasks they need to complete. Upon submission, they receive competitive price quotes from a variety of construction firms. PlaCo also supports the organization of auctions for specific project stages, allowing clients to select the best offer. Furthermore, if your project requires specialized expertise across different areas, you can choose different companies for each specific task, ensuring that you get the best professional for every aspect of your project.</p>
        
        
        <h2>Reviews</h2>
        <p>Client feedback is crucial for maintaining the quality of services on PlaCo. 
            After completing a project, clients can rate their experience and provide comments. 
            These reviews help other clients make informed decisions and allow companies to improve their services based on constructive feedback.
        </p>
        
    </section>
</body>
</html>