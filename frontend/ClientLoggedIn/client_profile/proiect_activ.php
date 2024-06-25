<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Activ</title>
    <link rel="stylesheet" href="/PlaCo/frontend/ClientLoggedIn/header/header.css"> 
    <link rel="stylesheet" href="/PlaCo/frontend/ClientLoggedIn/client_profile/style/proiect_activ.css"> 
    <link rel="shortcut icon" type="image/x-icon" href="/PlaCo/frontend/ClientLoggedIn/search_for_jobs/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
   
<div class="header">
        <div class="nav-left">
            <a class="logo-pic" href="/home/home">
                <img src="/PlaCo/frontend/ClientLoggedIn/client_profile/img/logo.png" class="logo" alt="Logo">
                <div class="nav-btn-left">PlaCo</div>
            </a>
        </div>
        <div class="nav-right">
            <div class="options-nav-bar">
                <a href="/home/discover_freelancers" class="nav-btn-left">Discover Freelancers</a>
                <a href="/home/post_a_project" class="nav-btn-left">Post a new Project</a>
            </div>
            <div class="menu-btn-right btn-dissapear">
                <input type="checkbox" id="profile-toggle">
                <label for="profile-toggle" >Profile</label>
                <div class="menu" id="profile-menu">
                    <button onclick="window.location.href='#'">My Profile</button>
                    <button onclick="window.location.href='/home/active_projects'">Active Projects</button>
                    <button onclick="window.location.href='/home/finished_projects'">Finished Projects</button>
                    <button onclick="window.location.href='/home/home'">Log Out</button>
                    <button onclick="window.location.href='/home/settings_client'">Settings</button>
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

        async function chooseFreelancer(freelancerId, buttonElement) {
            const urlParams = new URLSearchParams(window.location.search);
            const projectId = urlParams.get('project_id');
            if (!projectId) {
                alert('Project ID is required');
                return;
            }
            try {
                const response = await fetch('/PlaCo/backend/controllers/ProjectDetails.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        type: 'choose_freelancer',
                        project_id: projectId,
                        freelancer_chosen_id: freelancerId
                    })
                });

                if (!response.ok) {
                    throw new Error('Failed to choose freelancer');
                }

                const responseData = await response.json();
                if (responseData.status === 'success') {
                    // Hide all buttons and show the chosen message
                    const allButtons = document.querySelectorAll('.offer-item button');
                    allButtons.forEach(button => button.style.display = 'none');
                    
                    buttonElement.parentElement.innerHTML = '<p>Freelancer chosen for this project</p>';
                } else {
                    throw new Error('Failed to choose freelancer');
                }
            } catch (error) {
                console.error('Error choosing freelancer:', error);
                alert('Failed to choose freelancer');
            }
        }
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
        </div>
        <div class="offers-container">
            <h2>Offers for This Project</h2>
            <div id="offers-list"></div>
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
            try {
                const response = await fetch(`/PlaCo/backend/controllers/ProjectDetails.php?type=project_details_client&project_id=${projectId}`);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const projectData = await response.json();
                if (!projectData || !projectData.projectDetails) {
                    throw new Error('Empty or invalid project data received');
                }

                const projectDetails = projectData.projectDetails;
                const projectOffers = projectData.projectOffers;
                const progressStatus = projectData.progress;
                const freelancerChosenId = projectData.freelancer.freelancer_chosen_id;

                document.getElementById('project-title').textContent = projectDetails.title;
                document.getElementById('project-city').textContent = projectDetails.city;
                document.getElementById('project-budget').textContent = projectDetails.budget;
                document.getElementById('project-description').textContent = projectDetails.description;

                const offersList = document.getElementById('offers-list');
                let chosenFreelancer = null;
                if (projectOffers && projectOffers.length > 0) {
                    projectOffers.forEach(offer => {
                        const offerItem = document.createElement('div');
                        offerItem.classList.add('offer-item');
                        offerItem.innerHTML = `
                            <p><strong>Freelancer:</strong> ${offer.name}</p>
                            <p><strong>Budget:</strong> ${offer.budget_offered}</p>
                            <p><strong>Motivation:</strong> ${offer.motivation}</p>
                        `;

                        if (progressStatus==0) {
                            offerItem.innerHTML += `<button class="choose-freelancer" onclick="chooseFreelancer(${offer.freelancer_id}, this)">Choose this freelancer</button>`;
                        } else if (freelancerChosenId && offer.freelancer_id == freelancerChosenId) {
                            offerItem.innerHTML += '<p>You chose the freelancer: ' + offer.name + '</p>';
                        chosenFreelancer = offer;
                        }
                        offersList.appendChild(offerItem);
                        
                    });
                } else {
                    offersList.innerHTML = '<p>No offers found for this project.</p>';
                }
               
            } catch (error) {
                console.error('Error fetching project data:', error);
            }
        });
    </script>
</body>
</html>
