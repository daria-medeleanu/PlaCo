<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add to Portfolio</title>
    <link rel="stylesheet" href="/PlaCo/frontend/FreelancerLoggedIn/header/header.css"> 
    <link rel="stylesheet" href="/PlaCo/frontend/FreelancerLoggedIn/freelancer_profile/style/add_to_portfolio.css"> 
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
    <div class="container">
        <h1>Portfolio Item Upload</h1>
        <form id="portfolioForm" enctype="multipart/form-data">
            <input type="hidden" name="type" value="post_portfolio">
            <label for="title">Title:</label>
            <input type="text" id="titleInput" name="title" required>
            
            <label for="description">Portfolio Item Description:</label>
            <textarea id="descriptionInput" name="description" rows="6" required></textarea>

            <label for="file" class="upload-label">+ Upload Files
                <span class="tooltip-text">Allowed file types: txt, pdf, jpg, png, docs, docx. Max size: 5MB</span>
            </label>
            <input type="file" id="file" name="file[]" multiple="multiple">
            
            <div class="uploaded-files" id="uploadedFiles"></div>
            <div id="errorsUploadingFiles"> </div>

            <label for="tags">Skills (Tags):</label>
            <div class="tags-container">
                <input type="text" id="tagsInput" list="tagList" placeholder="Enter or select tag">
                <datalist id="tagList">
                </datalist>
                <button type="button" id="addTag">Add</button>
            </div>
            <div class="selected-tags" id="selectedTags"></div>
            
            <button type="submit">Save</button>
            <div id="message"></div>
        </form>
    </div>

    <script>
        let validFiles = [];

        document.getElementById('file').addEventListener('change', function(event) {
            const maxSize = 5 * 1024 * 1024; 
            const files = event.target.files;
            const uploadedFilesDiv = document.getElementById('uploadedFiles');
            const errorsUploadingFiles = document.getElementById('errorsUploadingFiles');
            const messageDiv = document.getElementById('message');
            messageDiv.textContent = ''; 
            errorsUploadingFiles.textContent = '';
            const allowedExtensions = ['txt', 'pdf', 'jpg', 'png', 'docs', 'docx'];

            let errorMessages = [];

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const fileExtension = file.name.split('.').pop().toLowerCase();

                if (file.size > maxSize) {
                    errorMessages.push(`File ${file.name} exceeds the maximum size of 5MB`);
                }else if(!allowedExtensions.includes(fileExtension)){
                    errorMessages.push(`File ${file.name} has an invalid extension. Only txt, pdf, jpg, png, docs, docx are allowed.`);

                } else {
                    
                    validFiles.push(file);
                    const uploadedFileDiv = document.createElement('div');
                    uploadedFileDiv.classList.add('uploaded-file');

                    const fileNameSpan = document.createElement('span');
                    fileNameSpan.textContent = file.name;

                    const deleteButton = document.createElement('button');
                    deleteButton.classList.add('delete-button');
                    deleteButton.innerHTML = 'X';
                    deleteButton.onclick = function() {
                        const index = validFiles.indexOf(file);
                        if (index > -1) {
                            validFiles.splice(index, 1); 
                        }
                        uploadedFileDiv.remove(); 
                    };

                    uploadedFileDiv.appendChild(fileNameSpan);
                    uploadedFileDiv.appendChild(deleteButton);
                    uploadedFilesDiv.appendChild(uploadedFileDiv);
                    
                }
            }
            if (errorMessages.length > 0) {
                errorsUploadingFiles.innerHTML = errorMessages.join('<br>');
                errorsUploadingFiles.style.color = 'red';
            }
            event.target.value = ''; 
        });
   
    document.addEventListener('DOMContentLoaded', function() {
        const titleInput = document.getElementById('titleInput');
        const descriptionInput = document.getElementById('descriptionInput');
        const skillsInput = document.getElementById('tagsInput');
        const skillList = document.getElementById('tagList');
        const addSkillBtn = document.getElementById('addTag');
        const portfolioForm = document.getElementById('portfolioForm');
        const selectedSkillsContainer = document.getElementById('selectedTags');
        const messageDiv = document.getElementById('message');
        let skillsFetched = false;

        
        async function fetchSkills(type) {
            try {
                const response = await fetch(`/PlaCo/backend/controllers/Tags.php?type=${type}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                });

                const skills = await response.json();

                skillList.innerHTML = '';
                skills.forEach(skill => {
                    const option = document.createElement('option');
                    option.value = skill.skill_name;
                    skillList.appendChild(option);
                });

                skillsFetched = true;
            } catch (error) {
                console.error('Error fetching skills:', error);
            }
        }

        skillsInput.addEventListener('click', function() {
            if (!skillsFetched) { 
                fetchSkills('fetch_skills');
            }
        });

        addSkillBtn.addEventListener('click', async function(event) {
            event.preventDefault(); 

            const selectedSkillName = skillsInput.value.trim();
            if (selectedSkillName === '') return;

            const skillExists = document.querySelector(`#skillList option[value="${selectedSkillName}"]`);

            if (!skillExists) {
                const newSkillOption = document.createElement('option');
                newSkillOption.value = selectedSkillName;
                skillList.appendChild(newSkillOption);
            }

            const selectedSkillDiv = document.createElement('div');
            selectedSkillDiv.textContent = selectedSkillName;

            const removeButton = document.createElement('button');
            removeButton.textContent = 'X';
            removeButton.classList.add('remove-tag');
            removeButton.addEventListener('click', function() {
                selectedSkillDiv.remove();
                removeButton.remove();
            });

            selectedSkillDiv.appendChild(removeButton);
            selectedSkillsContainer.appendChild(selectedSkillDiv);

            skillsInput.value = '';

            try {
                const requestBody = {
                    type: 'add_skill',
                    skill_name: selectedSkillName
                };

                const response = await fetch('/PlaCo/backend/controllers/Tags.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(requestBody),
                });

                const data = await response.json();
                console.log('Skill added successfully:', data);
                
            } catch (error) {
                console.error('Error adding Skill:', error);
            }
        });
        portfolioForm.addEventListener('submit', async function(event) {
                event.preventDefault();
                const selectedSkills = Array.from(document.querySelectorAll('.selected-tags div'))
                                  .map(skillDiv => skillDiv.textContent.replace('X', '').trim());
                const requestBody = {
                    type: 'post_portfolio',
                    title: titleInput.value,  
                    description: descriptionInput.value ,
                    skills: selectedSkills,
                };
                console.log('Request Body:', requestBody);
                try {
                    const response = await fetch('/PlaCo/backend/controllers/User.php', {
                        method: 'POST',
                        headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(requestBody)
                    });

                    const result = await response.json();
                    // console.log(result);
                    if (response.ok) {
                        messageDiv.textContent = 'Portfolio item posted successfully!';
                     
                        messageDiv.style.color = 'green';
                        portfolioForm.reset();
                        selectedSkillsContainer.innerHTML = '';

                         //uploading the files only if the portfolio was successfully uploaded
                        const formData = new FormData();
                        validFiles.forEach(file => {
                            formData.append('file[]', file);
                        });
                        // console.log('result.portfolio_id',result.portfolio_id);

                        formData.append('portfolio_id', result.portfolio_id);
                        console.log('validFiles', validFiles);
                        formData.append('type', 'portfolio_id');
                        formData.append('type', 'portfolio_id');
                        formData.append('type', 'portfolio_id');


                        fetch('/PlaCo/backend/controllers/Uploads.php', {
                            method: 'POST',
                            body: formData,
                        })
                        .then(response => response.text())
                        .then(data => {
                            console.log(data);
                            if (data.message === 'Files successfully uploaded') {
                                
                                window.location.href = '/home/client_profile?success=Project posted successfully';
                            } else {
                                const message = document.getElementById('uploadedFiles');
                                message.textContent = data.message;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                    } else {
                        messageDiv.textContent = 'Error posting portfolio item: ' + result.message;
                        messageDiv.style.color = 'red';
                    }
                    
                } catch (error) {
                    console.error('Error posting portfolio item:', error);
                    messageDiv.textContent = 'Error posting portfolio item';
                    messageDiv.style.color = 'red';
                }
            });
        });
       

    </script>

   
</body>
</html>