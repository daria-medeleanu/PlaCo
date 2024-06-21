<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . '/PlaCo/backend/helpers/session_helper.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/PlaCo/backend/controllers/pages-controller.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="/PlaCo/frontend/Login/style/LoginPage.css"> 
    <link rel="shortcut icon" type="image/x-icon" href="/PlaCo/frontend/Login/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">

</head>
<script>
        async function handleSubmit(event) {
            event.preventDefault();
            const formData = new FormData(document.getElementById('signUpForm'));
            const data = Object.fromEntries(formData.entries());

            const response = await fetch('/PlaCo/backend/controllers/User.php', {
                method: 'POST', 
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const result = await response.text();
            console.log(result);
            // const messageDiv = document.getElementById('message');
            // if(response.ok){
            //     messageDiv.textContent = result.message;
            //     messageDiv.style.color = 'green';
            //     window.location.href = '/home/login'; // Redirect to login page on successful signup
            // } else {
            //     messageDiv.textContent = result.message;
            //     messageDiv.style.color = 'red';
            // }
        }

        function setUserType(userType) {
            document.getElementById('user_type').value = userType;
            handleSubmit(event); // Automatically submit the form after setting user type
        }
    </script>
<!-- <script>
    function setUserType(userType) {
        document.getElementById('user_type').value = userType;
    }
    async function handleSubmit(event){
        event.preventDefault();
        const formData = new FormData(event.target);
        const data = Object.fromEntries(formData.entries());
        data.type = 'register';

        const response = await fetch('/PlaCo/backend/controllers/User.php', {
            method: 'POST', 
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        const messageDiv = document.getElementById('message');
        if(response.ok){
            messageDiv.textContent = result.message;
            messageDiv.style.color = 'green';
            window.location.href = '/home/login';
        } else {
            messageDiv.textContent = result.message;
            messageDiv.style.color = 'red';
        }
    }
</script> -->
<body>
    <div class="logo">
        <div class="logo-content">
            <a class="logo-pic" href="/home/home">
                <div class="logo-pic">
                    <img src="/PlaCo/frontend/Login/logo.png" class="logo-image" alt="Logo">
                </div>
                <div class="writing">PlaCo</div>
            </a>
        </div>
    </div>
        
    <div class="title">
        <h2>Sign Up</h2>
    </div>
    <!-- action="/PlaCo/backend/controllers/User.php" method="post" -->
    <form id="signUpForm" onSubmit="handleSubmit(event)">
        <div class="wrapper"> 
            <div class="login-container">
                <input type="hidden" name="type" value="register">
                <input type="hidden" name="user_type" id="user_type" value="">
                <input type="text" name="prenume" placeholder="Enter first name" required> 
                <input type="text" name="nume" placeholder="Enter last name" required>    
                <input type="email" name="email" placeholder="Enter email example: mary@gmail.com" required>     
                <input type="password" name="password_hash" placeholder="Enter password" required>
                <input type="password" name="psw-conf" placeholder="Confirm your password" required>
                <div class="sign-up-menu">
                    <button class="login-btn sign-up-btn" type="submit" onclick="setUserType('freelancer')">Sign Up as Freelancer</button>            
                    <button class="login-btn sign-up-btn" type="submit" onclick="setUserType('client')">Sign Up as Client</button>            
                </div>
                
                <a class="wrapper-link" href="/home/login">Log In</a>
                <div id="message"></div>
                <!-- <?php flash('register') ?> -->
            </div>
        </div>
    </form>
    
</body>
</html>