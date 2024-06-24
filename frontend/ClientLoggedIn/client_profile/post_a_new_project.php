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
            <label for="title">Title:</label>
            <input type="text" id="titleInput" name="title" placeholder="Title" required>
            
            <label for="description">Project Description:</label>
            <textarea id="descriptionInput" name="description" placeholder="Description" rows="6" required></textarea>

            <label for="file" class="upload-label">+ Upload Files
                <span class="tooltip-text">Allowed file types: txt, pdf, jpg, png, docs, docx. Max size: 5MB</span>
            </label>
            <input type="file" id="file" name="file[]" multiple="multiple">
            
            <div class="uploaded-files" id="uploadedFiles"></div>
            <div id="errorsUploadingFiles"> </div>
            <label for="tags">Skills required (Tags):</label>
            <div class="tags-container">
                <input type="text" id="tagsInput" list="tagList" placeholder="Enter or select tag">
                <datalist id="tagList">
                </datalist>
                <button type="button" id="addTag">Add</button>
            </div>
            <div class="selected-tags" id="selectedTags"></div>

            <label for="budget">What is your estimated budget?</label>
            <div class="budget-container">
                <input type="text" id="currencyInput" list="CurrencyList" placeholder="Currency">
                <datalist id="CurrencyList">
                    <option value="EUR"></option>
                    <option value="LEU"></option>
                    <option value="USD"></option>
                </datalist>

                <input type="text" id="budgetInput" name="budget" list="budgetList" placeholder="Choose Project Type">
                <datalist id="budgetList">
                    <option value="Simple Project (10-300 EUR)"></option>
                    <option value="Very Small Project (300-1000 EUR)"></option>
                    <option value="Small Project (1000-3000 EUR)"></option>
                    <option value="Medium Project (3000-8000 EUR)"></option>
                    <option value="Large Project (8000-15.000 EUR)"></option>
                    <option value="Very Large Project (15.000-35.000 EUR)"></option>
                    <option value="Huge Project (35.000+ EUR)"></option>
                </datalist>
            </div>
            <label for="city">City:</label>
            <div class="tags-container">
            <input type="text" id="cityInput" list="cityList" placeholder="Select City" required>
            <datalist id="cityList">
                <option value="New York">
                <option value="Los Angeles">
                <option value="London">
            </datalist>
            </div>

            <button type="submit">Post Project</button>
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

        const titleInput = document.getElementById('titleInput');
        const descriptionInput = document.getElementById('descriptionInput');
        const currencyInput = document.getElementById('currencyInput');
        const budgetInput = document.getElementById('budgetInput');
        const tagsInput = document.getElementById('tagsInput');
        const tagList = document.getElementById('tagList');
        const addTagBtn = document.getElementById('addTag');
        const projectForm = document.getElementById('projectForm');
        const selectedTagsContainer = document.getElementById('selectedTags');
        const messageDiv = document.getElementById('message');
        const cityInput = document.getElementById('cityInput'); 
        let tagsFetched = false;
        document.addEventListener('DOMContentLoaded', function() {

        
        async function fetchTags(type) {
            try {
                const response = await fetch(`/PlaCo/backend/controllers/Tags.php?type=${type}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                });

                const tags = await response.json();

                tagList.innerHTML = '';
                tags.forEach(tag => {
                    const option = document.createElement('option');
                    option.value = tag.tag_name;
                    tagList.appendChild(option);
                });

                tagsFetched = true;
            } catch (error) {
                console.error('Error fetching tags:', error);
            }
        }

        tagsInput.addEventListener('click', function() {
            if (!tagsFetched) { 
                fetchTags('fetch_tags');
            }
        });

        addTagBtn.addEventListener('click', async function(event) {
            event.preventDefault(); 

            const selectedTagName = tagsInput.value.trim();
            if (selectedTagName === '') return; 

            const tagExists = document.querySelector(`#tagList option[value="${selectedTagName}"]`);

            if (!tagExists) {
                const newTagOption = document.createElement('option');
                newTagOption.value = selectedTagName;
                tagList.appendChild(newTagOption);
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
            selectedTagsContainer.appendChild(selectedTagDiv);

            tagsInput.value = '';

            try {
                const requestBody = {
                    type: 'add_tag',
                    tag_name: selectedTagName
                };

                const response = await fetch('/PlaCo/backend/controllers/Tags.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(requestBody),
                });

                const data = await response.json();
                console.log('Tag added successfully:', data);
                // Handle success if needed
            } catch (error) {
                console.error('Error adding tag:', error);
            }
        });
        });        
        projectForm.addEventListener('submit', async function(event) {
                event.preventDefault();

                const selectedTags = Array.from(document.querySelectorAll('.selected-tags div'))
                                  .map(tagDiv => tagDiv.textContent.replace('X', '').trim());
                const requestBody = {
                    type: 'post_project',
                    title: titleInput.value,  
                    description: descriptionInput.value ,
                    tags: selectedTags,
                    budget:budgetInput.value,
                    currency:currencyInput.value,
                    city:cityInput.value 
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
                    console.log(result);
                    if (response.ok) {
                        messageDiv.textContent = 'Project posted successfully!';
                        messageDiv.style.color = 'green';
                        projectForm.reset();
                        selectedTagsContainer.innerHTML = '';
                        
                        //uploading the files only if the project was successfully uploaded
                        const formData = new FormData();
                        validFiles.forEach(file => {
                            formData.append('file[]', file);
                        });
                        formData.append('project_id', result.project_id);
                        console.log(validFiles);
                        formData.append('type', 'post_project');
                        formData.append('type', 'post_project');
                        formData.append('type', 'post_project');


                        fetch('/PlaCo/backend/controllers/Uploads.php', {
                            method: 'POST',
                            body: formData,
                        })
                        .then(response => response.json())
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
                        messageDiv.textContent = 'Error posting project: ' + result.message;
                        messageDiv.style.color = 'red';
                    }
                    
                } catch (error) {
                    console.error('Error posting project:', error);
                    messageDiv.textContent = 'Error posting project';
                    messageDiv.style.color = 'red';
                }
            });
        let selectedCurrency = '';
        let selectedBudget = '';
        let selectedCity = '';
        // Function to set the selected option as the input value
        function setInputValue(inputId, selectedOption) {
            document.getElementById(inputId).value = selectedOption;
        }

        document.getElementById('currencyInput').addEventListener('focus', function() {
            setInputValue('currencyInput', selectedCurrency);
        });

        document.getElementById('budgetInput').addEventListener('focus', function() {
            setInputValue('budgetInput', selectedBudget);
        });

        document.getElementById('cityInput').addEventListener('focus', function() {
            setInputValue('cityInput', selectedCity);
        });

        document.getElementById('currencyInput').addEventListener('input', function() {
            selectedCurrency = this.value; 
        });

        document.getElementById('budgetInput').addEventListener('input', function() {
            selectedBudget = this.value; 
        });
        document.getElementById('cityInput').addEventListener('input', function() {
            selectedCity = this.value; 
        });
    </script>
</body>
</html>