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

            <input type="file" id="file" name="file[]" multiple style="display: none;">
            <label for="file" class="upload-label">+ Upload Files</label>
            <div class="uploaded-files" id="uploadedFiles"></div>

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
       document.getElementById('file').addEventListener('change', function(event) {
        const files = event.target.files;
        const uploadedFilesDiv = document.getElementById('uploadedFiles');
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
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
                    uploadedFileDiv.remove(); // Remove the uploaded file container
                };

                uploadedFileDiv.appendChild(image);
                uploadedFileDiv.appendChild(deleteButton);
                uploadedFilesDiv.appendChild(uploadedFileDiv);
            };
            fileReader.readAsDataURL(file);
        }
        // Clear the file input value after processing files to allow selecting the same file again
        event.target.value = '';
    });

    document.querySelector('.upload-label').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default behavior of the label click event
        document.getElementById('file').click();
    });
    document.addEventListener('DOMContentLoaded', function() {
        const titleInput = document.getElementById('titleInput');
        const descriptionInput = document.getElementById('descriptionInput');
        const tagsInput = document.getElementById('tagsInput');
        const tagList = document.getElementById('tagList');
        const addTagBtn = document.getElementById('addTag');
        const portfolioForm = document.getElementById('portfolioForm');
        const selectedTagsContainer = document.getElementById('selectedTags');
        const messageDiv = document.getElementById('message');
        let tagsFetched = false;

        // Function to fetch tags from server and populate datalist
        async function fetchTags() {
            try {
                const response = await fetch('/PlaCo/backend/controllers/Tags.php?type=fetch_tags', {
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
            if (!tagsFetched) { // Fetch tags only if not fetched before
                fetchTags();
            }
        });

        addTagBtn.addEventListener('click', async function(event) {
            event.preventDefault(); // Prevent form submission or default action

            const selectedTagName = tagsInput.value.trim();
            if (selectedTagName === '') return; // Don't add empty tags

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
        projectForm.addEventListener('submit', async function(event) {
                event.preventDefault();
                const selectedTags = Array.from(document.querySelectorAll('.selected-tags div'))
                                  .map(tagDiv => tagDiv.textContent.replace('X', '').trim());
                const requestBody = {
                type: 'post_portfolio',
                title: titleInput.value,  //.value?
                description: descriptionInput.value ,
                tags: selectedTags,
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

                    const result = await response.text();
                    console.log(result);
                    if (response.ok) {
                        messageDiv.textContent = 'Portfolio item posted successfully!';
                        window.location.href = '/home/freelancer_profile';
                        messageDiv.style.color = 'green';
                        portfolioForm.reset();
                        selectedTagsContainer.innerHTML = '';
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