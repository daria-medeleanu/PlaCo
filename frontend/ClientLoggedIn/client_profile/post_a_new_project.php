<?php 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/PlaCo/backend/helpers/session_helper.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/PlaCo/backend/controllers/pages-controller.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post a new Project</title>
    <link rel="stylesheet" href="/PlaCo/frontend/ClientLoggedIn/header/header.css">
    <link rel="stylesheet" href="/PlaCo/frontend/ClientLoggedIn/client_profile/style/post_a_new_project.css"> 
    <link rel="shortcut icon" type="image/x-icon" href="/PlaCo/frontend/ClientLoggedIn/client_profile/img/logo.png">
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
    <div class="container">
        <h1>Project Upload</h1>
        <form id="projectForm" enctype="multipart/form-data">
        <!-- style="display: none;" -->
            <label for="file" class="upload-label">+ Upload Files</label>
            <input type="file" id="file" name="file[]" multiple="multiple">
            
            <div class="uploaded-files" id="uploadedFiles"></div>

            <button type="submit">Post Project</button>
            <div id="message"></div>
        </form>
    </div>

    <!-- <script>
        document.getElementById('file').addEventListener('change', function(event) {
        const maxSize = 5 * 1024 * 1024; // 5MB in bytes
        const files = event.target.files;
        const uploadedFilesDiv = document.getElementById('uploadedFiles');
        const messageDiv = document.getElementById('message');
        uploadedFilesDiv.innerHTML = ''; // Clear previous uploads
        messageDiv.textContent = ''; // Clear previous messages

        let allFilesValid = true;

        for (let i = 0; i < files.length; i++) {
            const file = files[i];

            // Check file size
            if (file.size > maxSize) {
                messageDiv.textContent = `File ${file.name} exceeds the maximum size of 5MB`;
                messageDiv.style.color = 'red';
                allFilesValid = false;
                break; // Stop processing if any file is too large
            }

            const fileReader = new FileReader();
            fileReader.onload = function(e) {
                const fileUrl = e.target.result;
                const uploadedFileDiv = document.createElement('div');
                uploadedFileDiv.classList.add('uploaded-file');

                const image = document.createElement('img');
                image.src = fileUrl;
                image.alt = file.name;

                const deleteButton = document.createElement('button');
                deleteButton.classList.add('delete-button');
                deleteButton.innerHTML = 'X';
                deleteButton.onclick = function() {
                    uploadedFileDiv.remove(); 
                };

                uploadedFileDiv.appendChild(image);
                uploadedFileDiv.appendChild(deleteButton);
                uploadedFilesDiv.appendChild(uploadedFileDiv);
            };
            fileReader.readAsDataURL(file);
        }

        if (!allFilesValid) {
            event.target.value = ''; // Clear the input if any file is invalid
        }
    });
        document.getElementById('projectForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
                   
            fetch('/PlaCo/backend/controllers/Uploads.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.text())
            .then(data => {
                const message = document.getElementById('message');
                message.textContent = data.message;
                // console.log(message.textContent);
                console.log(data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script> -->
    <script>
        let validFiles = [];

        document.getElementById('file').addEventListener('change', function(event) {
            const maxSize = 5 * 1024 * 1024; // 5MB in bytes
            const files = event.target.files;
            const uploadedFilesDiv = document.getElementById('uploadedFiles');
            const messageDiv = document.getElementById('message');
            messageDiv.textContent = ''; // Clear previous messages

            for (let i = 0; i < files.length; i++) {
                const file = files[i];

                // Check file size
                if (file.size > maxSize) {
                    messageDiv.textContent = `File ${file.name} exceeds the maximum size of 5MB`;
                    messageDiv.style.color = 'red';
                } else {
                    validFiles.push(file);

                    const fileReader = new FileReader();
                    fileReader.onload = function(e) {
                        const fileUrl = e.target.result;
                        const uploadedFileDiv = document.createElement('div');
                        uploadedFileDiv.classList.add('uploaded-file');

                        const image = document.createElement('img');
                        image.src = fileUrl;
                        image.alt = file.name;

                        const deleteButton = document.createElement('button');
                        deleteButton.classList.add('delete-button');
                        deleteButton.innerHTML = 'X';
                        deleteButton.onclick = function() {
                            const index = validFiles.indexOf(file);
                            if (index > -1) {
                                validFiles.splice(index, 1); // Remove file from validFiles array
                            }
                            uploadedFileDiv.remove(); 
                        };

                        uploadedFileDiv.appendChild(image);
                        uploadedFileDiv.appendChild(deleteButton);
                        uploadedFilesDiv.appendChild(uploadedFileDiv);
                    };
                    fileReader.readAsDataURL(file);
                }
            }

            event.target.value = ''; // Clear the input
        });

        document.getElementById('projectForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData();
            validFiles.forEach(file => {
                formData.append('file[]', file);
            });

            fetch('/PlaCo/backend/controllers/Uploads.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.text())
            .then(data => {
                const message = document.getElementById('message');
                message.textContent = data.message;
                console.log(data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script>
</body>
</html>