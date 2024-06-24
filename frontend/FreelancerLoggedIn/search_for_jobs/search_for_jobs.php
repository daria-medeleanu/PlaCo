<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search for jobs</title>
    <link rel="stylesheet" href="/PlaCo/frontend/FreelancerLoggedIn/header/header.css"> 
    <link rel="stylesheet" href="/PlaCo/frontend/FreelancerLoggedIn/search_for_jobs/style/search_for_jobs.css"> 
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
    
    <section>
        <div class="sidebar">
            <form class="search-container">
                <input type="text" placeholder="Search...">
                <button type="submit">
                    <img src="/PlaCo/frontend/FreelancerLoggedIn/search_for_jobs/search2.png" alt="Search">
                </button>
            </form>
            <div class="filters-box">
                <h2>Filters</h2>
           
                <div class="filter">
                    <label for="city">City:</label>
                    <select id="city">
                        <option value="all">All</option>
                        <option value="iasi">Iasi</option>
                        <option value="timisoara">Timisoara</option>
                        <option value="vaslui">Vaslui</option>
                    </select>
                </div>
                <div class="filter">
                    <label for="skills">Skills:</label>
                    <input type="text" id="skills" placeholder="Enter skills">
                </div>
                <button class="apply-btn">Apply</button>
            </div>
        </div>
        <div class="main-content">
            <div class="projects-list">
            </div>
        </div>
    </section>
<script>
      async function fetchProjects() {
        const city = encodeURIComponent(document.getElementById('city').value);
        const skills = encodeURIComponent(document.getElementById('skills').value);
        const search = encodeURIComponent(document.querySelector('.search-container input').value);


        const response = await fetch(`/PlaCo/backend/controllers/Projects.php?type=fetch_projects&city=${city}&skills=${skills}&search=${search}`);
    
            const projects = await response.json();
            displayProjects(projects);
        }


        function displayProjects(projects) {
            const projectsList = document.querySelector('.projects-list');
            projectsList.innerHTML = '';
           // console.log(projects);
            projects.forEach(project => {
                const projectBox = document.createElement('a');
                projectBox.href = `/home/project?project_id=${project.id}`;
                projectBox.classList.add('project-box');
                const tags = project.tags.map(tag => `<p>${tag.tag_name}</p>`).join('');

                const truncatedDescription = project.description.length > 200 ? project.description.substring(0, 200) + '...' : project.description;

                projectBox.innerHTML = `
                    <div class="project-text-input">
                        <h2>${project.title}</h2>
                        <div class="text-container">
                            <div class="title"><h3>Professional areas: </h3></div>
                            <div class="content-tags">${tags}</div>
                        </div>
                        <div class="text-container">
                            <div class="title"><h3>Address: </h3></div>
                            <div class="content"><p>${project.city}</p></div>
                        </div>
                        <div class="text-container">
                            <div class="title"><h3>Description: </h3></div>

                            <div class="content"><p>${truncatedDescription}</p></div>
                        </div>
                    </div>
                `;

                projectsList.appendChild(projectBox);
            });
        }

        document.querySelector('.search-container').addEventListener('submit', function(event) {
            event.preventDefault();
            fetchProjects();
        });

        document.querySelector('.apply-btn').addEventListener('click', function(event) {
            event.preventDefault();
            fetchProjects();
        });

        document.addEventListener('DOMContentLoaded', fetchProjects);
    
</script>
    
</body>
</html>