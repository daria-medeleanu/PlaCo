<?php 

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
                    <button id="logoutButton" onclick="logout()">Log Out</button>
                    <button onclick="window.location.href='/home/settings_freelancer'">Settings</button>
                </div>
            </div>
        </div>
        <a href="javascript:void(0);" class="icon" onclick="toggleMenu()">
            <i class="fa fa-bars"></i>
        </a>
    </div>

    
    <section class="profile-info">
        <div class="profile-picture">
            <img src="/PlaCo/frontend/FreelancerLoggedIn/freelancer_profile/img/profile-icon.png" alt="Add Profile Picture">
        </div>
        <div class="info-text">
            <h2>Professional areas:</h2>
            <p>Name: <span id="profileName"></span></p>
            <p>Phone number: <span id="profilePhoneNumber"></span></p>
            <p>Email address: <span id="profileEmail"></span></p>
            <p>Address: <span id="profileAddress"></span></p>
            <p>Joining date:<span id="profileJoinDate"></span></p> 
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
    <script>
        const jwtToken = localStorage.getItem('jwt');
        document.addEventListener('DOMContentLoaded', async function() {
            try{
                const response = await fetch('/PlaCo/backend/controllers/User.php', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${jwtToken}`
                    }
                });

                if (!response.ok) {
                    if(response.status === 401){
                        window.location.href = '/home/login';
                    } else {
                        throw new Error('Network response was not ok.');
                    }
                }

                const profileData = await response.json();
                console.log('Fetched Profile Data:', profileData);
                    
                document.getElementById('profileName').textContent = profileData.name ? profileData.name : 'N/A';
                document.getElementById('profilePhoneNumber').textContent = profileData.phone_number ? profileData.phone_number : 'N/A';
                document.getElementById('profileEmail').textContent = profileData.email ? profileData.email : 'N/A';
                document.getElementById('profileAddress').textContent = profileData.address ? profileData.address : 'N/A';
                document.getElementById('profileJoinDate').textContent = profileData.joining_date ? profileData.joining_date : 'N/A';

            } catch (error) {
                console.error('Error fetching profile data:', error);
            }
        });
    </script>
    <script>
        function logout() {
            localStorage.removeItem('jwt');
            
            window.location.href = '/home/login';
        }
    </script>
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
</body>
</html>