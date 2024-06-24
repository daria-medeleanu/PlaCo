<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discover Freelancers</title>
    <link rel="stylesheet" href="/PlaCo/frontend/ClientLoggedIn/header/header.css">
    <link rel="stylesheet" href="/PlaCo/frontend/ClientLoggedIn/discover_freelancers/discover_freelancers.css">
    <link rel="shortcut icon" type="image/x-icon" href="logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="header">
        <div class="nav-left">
            <a class="logo-pic" href="/home/home">
                <img src="/PlaCo/frontend/ClientLoggedIn/discover_freelancers/logo.png" class="logo" alt="Logo">
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
                <label for="profile-toggle">Profile</label>
                <div class="menu" id="profile-menu">
                    <button onclick="window.location.href='/home/client_profile'">My Profile</button>
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
    </script>

    <section>
        <div class="sidebar">
            <form class="search-container">
                <input type="text" placeholder="Search...">
                <button type="submit">
                    <img src="/PlaCo/frontend/ClientLoggedIn/discover_freelancers/search2.png" alt="Search">
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
            <div class="freelancers-list"></div>
        </div>
    </section>

    <section class="profile-info" id="profileContainer" style="display: none;">
        <div class="profile-picture">
            <img id="profilePicture" src="/PlaCo/frontend/FreelancerLoggedIn/freelancer_profile/img/profile-icon.png" alt="Profile Picture">
        </div>
        <div class="info-text">
            <h2>Professional areas:</h2>
            <p>Name: <span id="profileName"></span></p>
            <p>Phone number: <span id="profilePhoneNumber"></span></p>
            <p>Email address: <span id="profileEmail"></span></p>
            <p>Address: <span id="profileAddress"></span></p>
            <p>Joining date: <span id="profileJoinDate"></span></p>
        </div>
    </section>

    <script>
        async function fetchFreelancers() {
            const city = encodeURIComponent(document.getElementById('city').value);
            const skills = encodeURIComponent(document.getElementById('skills').value);
            const search = encodeURIComponent(document.querySelector('.search-container input').value);

            const response = await fetch(`/PlaCo/backend/controllers/Freelancers.php?city=${city}&skills=${skills}&search=${search}`);
            const freelancers = await response.json();
            displayFreelancers(freelancers);
        }

        function displayFreelancers(freelancers) {
            const freelancersList = document.querySelector('.freelancers-list');
            freelancersList.innerHTML = '';

            freelancers.forEach(freelancer => {
                const freelancerBox = document.createElement('div');
                freelancerBox.classList.add('freelancer-box');
                freelancerBox.setAttribute('onclick', `fetchFreelancerProfile(${freelancer.id})`);

                const skillsHtml = freelancer.skills.map(skill => `<p>${skill}</p>`).join('');
                freelancerBox.innerHTML = `
                    <img src="/PlaCo/frontend/ClientLoggedIn/client_profile/img/profile-icon.png" alt="Profile Picture" />
                    <div class="freelancer-text-input">
                        <h2>${freelancer.name}</h2>
                        <div class="text-container">
                            <div class="title"><h3>Professional areas: </h3></div>
                            <div class="content-tags">${skillsHtml}</div>
                        </div>
                        <div class="text-container">
                            <div class="title"><h3>Address: </h3></div>
                            <div class="content"><p>${freelancer.address}</p></div>
                        </div>
                    </div>
                `;

                freelancersList.appendChild(freelancerBox);
            });
        }

        async function fetchFreelancerProfile(freelancerId) {
            const jwtToken = localStorage.getItem('jwt');

            try {
                const response = await fetch(`/PlaCo/backend/controllers/FreelancerProfile.php?id=${freelancerId}`, {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${jwtToken}`
                    }
                });

                if (!response.ok) {
                    if (response.status === 401) {
                        window.location.href = '/home/login';
                    } else {
                        throw new Error('Network response was not ok.');
                    }
                }

                const profileData = await response.json();

                // Update the profile information
                document.getElementById('profileName').textContent = profileData.name || 'N/A';
                document.getElementById('profilePhoneNumber').textContent = profileData.phone_number || 'N/A';
                document.getElementById('profileEmail').textContent = profileData.email || 'N/A';
                document.getElementById('profileAddress').textContent = profileData.address || 'N/A';
                document.getElementById('profileJoinDate').textContent = profileData.joining_date || 'N/A';

               /* if (profileData.profile_picture) {
                    document.getElementById('profilePicture').src = profileData.profile_picture;
                } else {
                    document.getElementById('profilePicture').src = "/PlaCo/frontend/FreelancerLoggedIn/freelancer_profile/img/profile-icon.png";
                }*/

                // Display the profile container
                document.getElementById('profileContainer').style.display = 'block';
            } catch (error) {
                console.error('Error fetching profile data:', error);
            }
        }

        document.querySelector('.search-container').addEventListener('submit', function(event) {
            event.preventDefault();
            fetchFreelancers();
        });

        document.querySelector('.apply-btn').addEventListener('click', function(event) {
            event.preventDefault();
            fetchFreelancers();
        });
            document.addEventListener('DOMContentLoaded', fetchFreelancers);
    </script>
</body>
</html>
