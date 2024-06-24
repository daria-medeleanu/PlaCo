<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects in progress</title>
    <link rel="stylesheet" href="/PlaCo/frontend/FreelancerLoggedIn/header/header.css"> 
    <link rel="stylesheet" href="/PlaCo/frontend/ClientLoggedIn/client_profile/style/active_projects.css"> 
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
                <a href="/home/search_for_jobs" class="nav-btn-left">Search for jobs</a>
            </div>
            <div class="menu-btn-right btn-dissapear">
                <input type="checkbox" id="profile-toggle">
                <label for="profile-toggle" >Profile</label>
                <div class="menu" id="profile-menu">
                    <button onclick="window.location.href='/home/freelancer_profile'">My Profile</button>
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

        async function fetchActiveProjects() {
            const response = await fetch(`/PlaCo/backend/controllers/MyProjects.php?type=projects_in_progress`);
            const activeProjects = await response.json();
            displayActiveProjects(activeProjects);
        }

        function displayActiveProjects(activeProjects) {
            const projectContainer = document.getElementById('projectContainer');
            projectContainer.innerHTML = '';

            activeProjects.forEach(item => {
                const projectBox = document.createElement('div');
                projectBox.classList.add('project');
                console.log(item.id);

                const projectLink = document.createElement('a');
                projectLink.href = `/PlaCo/frontend/FreelancerLoggedIn/freelancer_profile/proiect_de_facut.php?project_id=${item.id}`;
                projectLink.classList.add('project-link');

                projectBox.innerHTML = `
                    <img src="/PlaCo/frontend/ClientLoggedIn/client_profile/img/project.jpg" alt="${item.title}" class="project-image">
                    <div class="project-title">${item.title}</div>
                `;
                projectLink.appendChild(projectBox);
                projectContainer.appendChild(projectLink);
            });

            
        }

        document.addEventListener('DOMContentLoaded', fetchActiveProjects);

    </script>

    <div class="project-container" id="projectContainer">
    
    </div>


</body>
</html>
