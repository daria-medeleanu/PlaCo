<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project</title>
    <link rel="stylesheet" href="/PlaCo/frontend/FreelancerLoggedIn/header/header.css"> 
    <link rel="stylesheet" href="/PlaCo/frontend/FreelancerLoggedIn/search_for_jobs/style/project.css"> 
    <link rel="shortcut icon" type="image/x-icon" href="/PlaCo/frontend/FreelancerLoggedIn/search_for_jobs/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="header">
        <div class="nav-left">
            <a class="logo-pic" href="/home/home">
                <img src="/PlaCo/frontend/FreelancerLoggedIn/search_for_jobs/logo.png" class="logo" alt="Logo">
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

    <section class="project-details">
        <div class="project-content">
            <h1 id="project-title"></h1>
            <div class="project-info">
                <p><strong>City:</strong> <span id="project-city"></span></p>
                <p><strong>Budget:</strong> <span id="project-budget"></span></p>
                <p><strong>Description:</strong></p>
                <p id="project-description"></p>
            </div>
            <button id="apply-button">Apply for this project</button>
            <div id="application-form" style="display: none;">
                <h2>Application Form</h2>
                <form id="apply-form">
                    <textarea id="motivation" placeholder="Write your motivation"></textarea>
                    <input type="number" id="budget_offered" placeholder="Your budget">
                    <button type="submit">Submit Application</button>
                </form>
            </div>
            <p id="applied-message" style="display: none;">You applied to this project</p>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', async function() {
            const urlParams = new URLSearchParams(window.location.search);
            const projectId = urlParams.get('project_id');

            if (!projectId) {
                alert('Project ID is required');
                return;
            }

            const response = await fetch(`/PlaCo/backend/controllers/ProjectDetails.php?project_id=${projectId}`);
            const project = await response.json();

            document.getElementById('project-title').textContent = project.title;
            document.getElementById('project-city').textContent = project.city;
            document.getElementById('project-budget').textContent = project.budget;
            document.getElementById('project-description').textContent = project.description;

            document.getElementById('apply-button').addEventListener('click', function() {
                document.getElementById('application-form').style.display = 'block';
            });

            document.getElementById('apply-form').addEventListener('submit', async function(event) {
                event.preventDefault();

                const motivation = document.getElementById('motivation').value;
                const budget_offered = document.getElementById('budget_offered').value;

                const offer = {
                    project_id: projectId,
                    motivation: motivation,
                    budget_offered: budget_offered
                };

                const offerResponse = await fetch(`/PlaCo/backend/controllers/ProjectDetails.php`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(offer)
                });

                const offerResult = await offerResponse.json();

                if (offerResult.status === 'success') {
                    alert('Offer submitted successfully');
                    document.getElementById('application-form').style.display = 'none';
                    document.getElementById('apply-button').style.display = 'none';
                    document.getElementById('applied-message').style.display = 'block';
                } else {
                    alert('Failed to submit offer');
                }
            });
        });
    </script>
</body>
</html>
