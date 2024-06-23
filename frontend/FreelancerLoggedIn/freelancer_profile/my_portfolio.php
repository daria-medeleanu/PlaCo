
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My Portfolio</title>
        <link rel="stylesheet" href="/PlaCo/frontend/FreelancerLoggedIn/header/header.css"> 
        <link rel="stylesheet" href="/PlaCo/frontend/FreelancerLoggedIn/freelancer_profile/style/my_portfolio.css"> 
        <link rel="shortcut icon" type="image/x-icon" href="/PlaCo/frontend/Login/logo.png">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
<body>

    <div class="header">
        <div class="nav-left">
            <a class="logo-pic" href="/home/home">
                <img src="/PlaCo/frontend/FreelancerLoggedIn/freelancer_profile/img/logo.png" class="logo" alt="Logo">
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
                    <button onclick="window.location.href='#'">My Portfolio</button>
                    <button onclick="window.location.href='/home/home'">Log Out</button>
                    <button onclick="window.location.href='/home/settings'">Settings</button>
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
        async function fetchPortfolioItems() {
            const response = await fetch('/PlaCo/backend/controllers/Portfolios.php');
            const portfolioItems = await response.json();
            displayPortfolioItems(portfolioItems);
        }

        function displayPortfolioItems(portfolioItems) {
            const projectContainer = document.getElementById('projectContainer');
            projectContainer.innerHTML = '';

            portfolioItems.forEach(item => {
                const projectBox = document.createElement('div');
                projectBox.classList.add('project');

                projectBox.innerHTML = `
                    <img src="/PlaCo/frontend/FreelancerLoggedIn/freelancer_profile/img/project.jpg" alt="${item.title}" class="project-image">
                    <div class="project-title">${item.title}</div>
                `;

                projectContainer.appendChild(projectBox);
            });

            const addProjectLink = document.createElement('a');
            addProjectLink.href = "/home/add_to_portfolio";
            addProjectLink.classList.add('add-project');

            addProjectLink.innerHTML = `
                <div class="add-symbol">+</div>
                <div class="add-text">Add a new project</div>
            `;

            projectContainer.appendChild(addProjectLink);
        }

        document.addEventListener('DOMContentLoaded', fetchPortfolioItems);

    </script>
    <div class="project-container" id="projectContainer">
        <!-- <div class="project" id="project1">
            <img src="/PlaCo/frontend/FreelancerLoggedIn/freelancer_profile/img/project.jpg" alt="Project 1" class="project-image">
            <div class="project-title">Project 1</div>
        </div>
        <div class="project">
            <img src="/PlaCo/frontend/FreelancerLoggedIn/freelancer_profile/img/project.jpg" alt="Project 2" class="project-image">
            <div class="project-title">Project 2</div>
        </div>
        <div class="project" >
            <img src="/PlaCo/frontend/FreelancerLoggedIn/freelancer_profile/img/project.jpg" alt="Project 3" class="project-image">
            <div class="project-title">Project 3</div>
        </div>
        <div class="project" >
            <img src="/PlaCo/frontend/FreelancerLoggedIn/freelancer_profile/img/project.jpg" alt="Project 4" class="project-image">
            <div class="project-title">Project 4</div>
        </div>
        <div class="project" >
            <img src="/PlaCo/frontend/FreelancerLoggedIn/freelancer_profile/img/project.jpg" alt="Project 5" class="project-image">
            <div class="project-title">Project 5</div>
        </div>
        <a href="/home/add_to_portfolio" class="add-project">
            <div class="add-symbol">+</div>
            <div class="add-text">Add a new project</div>
        </a> -->
    </div>

</body>
</html>