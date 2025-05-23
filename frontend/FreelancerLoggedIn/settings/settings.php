<?php

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Settings</title>
        <link rel="stylesheet" href="/PlaCo/frontend/FreelancerLoggedIn/header/header.css"> 
        <link rel="stylesheet" href="/PlaCo/frontend/FreelancerLoggedIn/settings/settings.css"> 
        <link rel="shortcut icon" type="image/x-icon" href="/PlaCo/frontend/FreelancerLoggedIn/settings/logo.png">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
<body>
    <div class="header">
        <div class="nav-left">
            <a class="logo-pic" href="/home/home">
                <img src="/PlaCo/frontend/FreelancerLoggedIn/settings/logo.png" class="logo" alt="Logo">
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
                    <button onclick="window.location.href='#'">Settings</button>
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

    <div class="container">
        <div class="left-panel">
            <h1>Settings</h1>
            <button class="button" onclick="showEditProfile()">Edit Profile</button>
            <button class="button" onclick="showChangePassword()">Change Password</button>
            <button class="button" onclick="showStatistics()">See Your Statistics</button>
        </div>
        <div class="right-panel">
            <div id="editProfile">
                <h2>Edit Profile</h2>
                <form id="editProfileForm" enctype="multipart/form-data">
                    <div class="profile-picture-container">
                        <img src="/PlaCo/frontend/FreelancerLoggedIn/settings/profile-icon.png" alt="Profile Picture" id="profilePicture">
                        <input type="file" id="profilePictureInput" accept="image/*" >
                        <label for="profilePictureInput" class="upload-profile-picture-button">Upload New Picture</label>
                    </div>
                    <input type="text" class="form-input" id="nameInput" placeholder="Name" >
                    <input type="text" class="form-input" id="phoneInput" placeholder="Phone number" >
                    <input type="text" class="form-input" id="emailInput" placeholder="Email address" readonly>
                    <input type="text" class="form-input" id="addressInput" placeholder="Address" >
                    
                    <h2>Professional areas:</h2>
                    <div class="tags-container">
                        <input type="text" id="tagsInput" list="tagList" placeholder="Enter or select tag">
                        <datalist id="tagList">
                            <option value="Tag 1"></option>
                            <option value="Tag 2"></option>
                            <option value="Tag 3"></option>
                            <option value="Tag 4"></option>
                        </datalist>
                        <button id="addTag">Add</button>
                    </div>
                    <div class="selected-tags" id="selectedTags"></div>
                    <button type="button" id="saveChangesButton" class="button-submit">Save Changes</button>
                    <button type="button" id="deleteProfile" class="button-submit">Delete Profile</button>
                </form>
            <div id="changePassword">
                <h2>Change Password</h2>
                <input type="password" class="form-input" placeholder="Current Password">
                <input type="password" class="form-input" placeholder="New Password">
                <input type="password" class="form-input" placeholder="Confirm New Password">
                <button class="button-submit">Change Password</button>
            </div>
            <div id="statistics">
                <h2>Your Statistics</h2>
                <div class="statistics">
                    Total Logins: 100<br>
                    Profile Views: 50
                </div>
            </div>
        </div>
    </div>
    <script>
        async function handleProfileUpdate(event) {
            event.preventDefault();

            const formData = new FormData();
            formData.append('type', 'update_profile');
            formData.append('name', document.getElementById('nameInput').value);
            formData.append('phone_number', document.getElementById('phoneInput').value);
            formData.append('email', document.getElementById('emailInput').value);
            formData.append('address', document.getElementById('addressInput').value);
            formData.append('profile_picture', document.getElementById('profilePictureInput').files[0]);
            
            console.log(formData);
            try {
                const response = await fetch("/PlaCo/backend/controllers/User.php", {
                    method: "POST",
                    body: formData
                });

                const result = await response.text();
                console.log(result);
                if (response.ok) {
                    localStorage.setItem('profileUpdateMessage', 'Profile successfully updated!');
                    window.location.href = "/home/freelancer_profile";
                    console.log('Success!');
                } else {
                    console.error('Failed to update profile:', result.message);
                }
            } catch (error) {
                console.error('Error:', error);
            }
            
        }

        async function handleProfileDeletion(event) {
            if (confirm('Are you sure you want to delete your profile? This action cannot be undone.')) {
                try {
                    const response = await fetch("/PlaCo/backend/controllers/User.php", {
                        method: "DELETE",
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    });

                    const result = await response.json();
                    if (response.ok) {
                        window.location.href = "/home/home";
                    } else {
                        console.error('Failed to delete profile:', result.message);
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            }
        }

        document.getElementById('saveChangesButton').addEventListener('click', handleProfileUpdate);
        document.getElementById('deleteProfile').addEventListener('click', handleProfileDeletion);
    </script>
    <script> 
        window.onload = showEditProfile;
        function showEditProfile() {
            document.getElementById('editProfile').style.display = 'block';
            document.getElementById('changePassword').style.display = 'none';
            document.getElementById('statistics').style.display = 'none';
        }

        function showChangePassword() {
            document.getElementById('editProfile').style.display = 'none';
            document.getElementById('changePassword').style.display = 'block';
            document.getElementById('statistics').style.display = 'none';
        }

        function showStatistics() {
            document.getElementById('editProfile').style.display = 'none';
            document.getElementById('changePassword').style.display = 'none';
            document.getElementById('statistics').style.display = 'block';
        }

        
        document.getElementById('addTag').addEventListener('click', function() {
        event.preventDefault(); 
        const tagsInput = document.getElementById('tagsInput');
        const selectedTagsDiv = document.getElementById('selectedTags');
        
        let selectedTagName = tagsInput.value.trim();
        if (selectedTagName === '') return; 

        const tagExists = document.querySelector(`#tagList option[value="${selectedTagName}"]`);
        
        if (!tagExists) {
            const newTagOption = document.createElement('option');
            newTagOption.value = selectedTagName;
            document.getElementById('tagList').appendChild(newTagOption);
        }

        const selectedTagDiv = document.createElement('div');
        selectedTagDiv.textContent = selectedTagName;

        const removeButton = document.createElement('button');
        removeButton.textContent = 'X';
        removeButton.classList.add('remove-tag');
        removeButton.addEventListener('click', function() {
            selectedTagDiv.remove();
            removeButton.remove();
        });

        selectedTagDiv.appendChild(removeButton);
        selectedTagsDiv.appendChild(selectedTagDiv);
        tagsInput.value = '';
        });

        document.getElementById('profilePictureInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const reader = new FileReader();
            
            reader.onload = function(e) {
                document.getElementById('profilePicture').src = e.target.result;
            }
            
            reader.readAsDataURL(file);
        });

    </script>
    <script>
        const jwtToken = localStorage.getItem('jwt');
    document.addEventListener("DOMContentLoaded", function() {
        function getUserProfile() {
            fetch('/PlaCo/backend/controllers/User.php', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${jwtToken}`
                }
            })
            .then(response => {
                if(!response.ok){
                    if(response.status === 401){
                        window.location.href = '/home/login';
                    } else {
                        throw new Error('Network response was not ok.');
                    }
                }
                return response.json();
            })
            .then(data => {
                // console.log(data);
                if (data.error) {
                    console.error('Error fetching profile data:', data.error);
                    return;
                }
                document.getElementById('nameInput').value = data.name;
                document.getElementById('phoneInput').value = data.phone_number;
                document.getElementById('emailInput').value = data.email;
                document.getElementById('addressInput').value = data.address;
                if (data.profile_picture) {
                    document.getElementById('profilePicture').src = data.profile_picture;
                }
            })
            .catch(error => console.error('Error fetching profile data:', error));
        }

        getUserProfile();
    });
    </script>
</body>
</html>
