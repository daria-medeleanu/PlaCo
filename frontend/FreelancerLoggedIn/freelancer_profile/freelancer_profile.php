<?php 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/PlaCo/backend/helpers/session_helper.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/PlaCo/backend/controllers/pages-controller.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/PlaCo/backend/models/User.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/PlaCo/backend/controllers/User.php';
    
    // session_start();
    // $usersController = new Users(); 
    // $userProfile = $usersController->displayProfile();

    // if (!$userProfile) {
    //     die("Profile not found.");
    // }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="/PlaCo/frontend/FreelancerLoggedIn/header/header.css"> 
    <link rel="stylesheet" href="/PlaCo/frontend/FreelancerLoggedIn/freelancer_profile/style/freelancer_profile.css"> 
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
            <div class="options-nav-bar">
                <a href="/PlaCo/frontend/FreelancerLoggedIn/search_for_jobs/search_for_jobs.html" class="nav-btn-left">Search for jobs</a>
            </div>
            <div class="menu-btn-right btn-dissapear">
                <input type="checkbox" id="profile-toggle">
                <label for="profile-toggle" >Profile</label>
                <div class="menu" id="profile-menu">
                    <button onclick="window.location.href='#'">My Profile</button>
                    <button onclick="window.location.href='/home/my_portfolio'">My Portfolio</button>
                    <button onclick="window.location.href='/home/home'">Log Out</button>
                    <button onclick="window.location.href='/home/settings_freelancer'">Settings</button>
                </div>
            </div>
        </div>
        <a href="javascript:void(0);" class="icon" onclick="toggleMenu()">
            <i class="fa fa-bars"></i>
        </a>
    </div>

    <script>
        function toggleMenu() {
            var navRight = document.querySelector('.nav-right');
            navRight.classList.toggle('collapsed');
        }    
    
        document.addEventListener('click', function(event) {
            var profileToggle = document.getElementById('profile-toggle');
            var profileMenu = document.getElementById('profile-menu');
            var target = event.target;
            
            if (!target.closest('.menu-btn-right')) {
                profileMenu.style.display = 'none';
                profileToggle.checked = false;
            }
        });

        document.getElementById('profile-toggle').addEventListener('click', function(event) {
            var profileMenu = document.getElementById('profile-menu');
            profileMenu.style.display = this.checked ? 'block' : 'none';
            event.stopPropagation();
        });
    </script>
    <section class="profile-info">
        <div class="profile-picture">
            <img src="<?php echo $userProfile->profile_picture ? $userProfile->profile_picture : '/PlaCo/frontend/FreelancerLoggedIn/freelancer_profile/img/profile-icon.png';?>" alt="Add Profile Picture">
        </div>
        <div class="info-text">
            <h2>Professional areas:</h2>
            <p>Name: <?php echo htmlspecialchars($userProfile->name); ?></p>
            <p>Phone number: <?php echo htmlspecialchars ($userProfile->phone_number);?></p>
            <p>Email address: <?php echo htmlspecialchars($userProfile->email);?></p>
            <p>Address: <?php echo htmlspecialchars($userProfile->address);?></p>
            <p>Joining date:<?php echo htmlspecialchars($userProfile->joining_date); ?></p>
        </div>
    </section>
     <section class="box">
        <div class="btn-see-projects">
            <div class="boxBtn"><a href="/home/my_portfolio" > See Portfolio</a> </div>
        </div>
        <div class="btn-edit-profile">
            <div class="boxBtn"><a href="/home/settings_freelancer" >Edit Profile</a> </div>
        </div>
    </section>
    <section class="review">
        <h2>Reviews</h2>
        <h3>user10</h3>
        <p> 5 stele, calificat</p>
        <h3>userAnaMaria</h3>
        <p> mi-a stricat gresia din baie</p>
    </section>
   
</body>
</html>