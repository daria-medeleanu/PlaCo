<?php
require_once '../../../backend/models/User.php';
require_once '../../../backend/helpers/session_helper.php';
require_once '../../../backend/controllers/User.php';

// session_start();
$usersController = new Users(); 
$userProfile = $usersController->displayProfile();

if (!$userProfile) {
    die("Profile not found.");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Settings</title>
        <link rel="stylesheet" href="../header/header.css"> 
        <link rel="stylesheet" href="settings.css"> 
        <link rel="shortcut icon" type="image/x-icon" href="./logo.png">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
<body>
    <div class="header">
        <div class="nav-left">
            <a class="logo-pic" href="../../Login/DashboardLogin.html">
                <img src="./logo.png" class="logo" alt="Logo">
                <div class="nav-btn-left">PlaCo</div>
            </a>
        </div>
        <div class="nav-right">
            <div class="options-nav-bar">
                <a href="../search_for_jobs/search_for_jobs.html" class="nav-btn-left">Search for jobs</a>
            </div>
            <div class="menu-btn-right btn-dissapear">
                <input type="checkbox" id="profile-toggle">
                <label for="profile-toggle" >Profile</label>
                <div class="menu" id="profile-menu">
                    <button onclick="window.location.href='../freelancer_profile/freelancer_profile.php'">My Profile</button>
                    <button onclick="window.location.href='../freelancer_profile/my_portfolio.html'">My Portfolio</button>
                    <button onclick="window.location.href='../../Login/DashboardLogin.php'">Log Out</button>
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
                        <img src="profile-icon.png" alt="Profile Picture" id="profilePicture">
                        <input type="file" id="profilePictureInput" accept="image/*" value="<?php echo htmlspecialchars($userProfile->profile_picture); ?>">
                        <label for="profilePictureInput" class="upload-profile-picture-button">Upload New Picture</label>
                    </div>
                    <input type="text" class="form-input" id="nameInput" placeholder="Name" value="<?php echo htmlspecialchars($userProfile->name); ?>">
                    <input type="text" class="form-input" id="phoneInput" placeholder="Phone number" value="<?php echo htmlspecialchars($userProfile->phone_number); ?>">
                    <input type="text" class="form-input" id="emailInput" placeholder="Email address" value="<?php echo htmlspecialchars($userProfile->email); ?>" readonly>
                    <input type="text" class="form-input" id="addressInput" placeholder="Address" value="<?php echo htmlspecialchars($userProfile->address); ?>">
                    
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
    document.getElementById('saveChangesButton').addEventListener('click', function() {
        var data = {
            type: 'update_profile',
            name: document.getElementById('nameInput').value, 
            phone_number: document.getElementById('phoneInput').value,
            email: document.getElementById('emailInput').value,
            address: document.getElementById('addressInput').value
        };
        fetch("../../../backend/controllers/User.php",{
            method: "PUT",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            return response.text();
        })
        .then(data => {
            console.log(data);
            window.location.href = "../freelancer_profile/freelancer_profile.php";
        })
        .catch(error => {
            console.error('Error:', error);
        });
        
    });
    document.getElementById('deleteProfile').addEventListener('click', function() {
    if (confirm('Are you sure you want to delete your profile? This action cannot be undone.')) {
        fetch("../../../backend/controllers/User.php", {
            method: "DELETE",
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => {return response.text();})
        .then(data => {
            console.log('Server response', data);
            // if (data.message === 'Profile deleted successfully') {
                // alert(data.message);
                window.location.href = "../../Login/DashboardLogin.php";
            // } 
                //  else {
                    // console.error('Failed to delete profile:', data.message);
                // Handle failure here (e.g., show an error message to the user)
            // }
            // } 
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
});
</script>
    <script> 
        //deschide intai edit profile ca default page pt settings
        window.onload = function() {
        showEditProfile();
        };
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

        //tags
        document.getElementById('addTag').addEventListener('click', function() {
        event.preventDefault(); //ca sa nu mai apara required-ul de la title input
        const tagsInput = document.getElementById('tagsInput');
        const selectedTagsDiv = document.getElementById('selectedTags');
        
        let selectedTagName = tagsInput.value.trim();
        if (selectedTagName === '') return; // fara empty tags

        // Check if the entered tag already exists among the predefined tags
        const tagExists = document.querySelector(`#tagList option[value="${selectedTagName}"]`);
        
        if (!tagExists) {
            // Create a new option to select the entered tag in the future
            const newTagOption = document.createElement('option');
            newTagOption.value = selectedTagName;
            document.getElementById('tagList').appendChild(newTagOption);
        }

        // Create the selected tag element
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
        // Clear the input field
        tagsInput.value = '';
    });

    // Profile picture upload
    document.getElementById('profilePictureInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const reader = new FileReader();
        
        reader.onload = function(e) {
            document.getElementById('profilePicture').src = e.target.result;
        }
        
        reader.readAsDataURL(file);
    });

    </script>
</body>
</html>
