<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . '/PlaCo/backend/helpers/session_helper.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/PlaCo/backend/controllers/pages-controller.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/PlaCo/frontend/Login/style/LoginPage.css"> 
    <link rel="shortcut icon" type="image/x-icon" href="/PlaCo/frontend/Login/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">

</head>
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
        <h2>Login</h2>
    </div>
    <form id="loginForm">
        <div class="wrapper"> 
            <div class="login-container">
                <input type="hidden" name="type" value="login">
                <input type="text" id="email" name="email" placeholder="Enter email" required>    
                <input type="password" id="password" name="password" placeholder="Enter password" required>
                <a class="wrapper-link" href="/home/ForgotPassword">Forgot your password?</a>
                <button class="login-btn" type="submit" >Login</button>            
                <!-- <div class="remember-me">
                    <input type="checkbox" id="remember-checkbox" name="remember">
                    <label for="remember-checkbox" class="checkbox-label">Remember me</label>
                </div> -->
                
                <a class="wrapper-link" href="/home/register">Sign Up</a>
                
                <div id="message"></div>
            </div>
        </div>
    </form>
    <script>
        document.getElementById('loginForm').addEventListener('submit', async function(event){
            event.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
 
            const requestBody = {
                type: 'login',
                email: email, 
                password: password 
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

                const textResponse = await response.text();
                console.log('Raw Response:', textResponse);

                try {
                    const result = JSON.parse(textResponse);
                    console.log('Parsed JSON Response:', result);

                    const messageDiv = document.getElementById('message');
                    if (response.ok) {
                        messageDiv.textContent = result.message;
                        messageDiv.style.color = '#14213d';
                        if(messageDiv.textContent === "client"){
                            window.location.href = '/home/client_profile';
                        } else if (messageDiv.textContent === "freelancer"){
                            window.location.href = '/home/freelancer_profile';
                        }
                    } else {
                        messageDiv.textContent = result.message;
                        messageDiv.style.color = 'red';
                    }
                } catch (jsonError) {
                    console.error('JSON Parse Error:', jsonError);
                    const messageDiv = document.getElementById('message');
                    messageDiv.textContent = 'An unexpected error occurred. Please try again.';
                    messageDiv.style.color = 'red';
                }

            } catch (error) {
                console.error('Fetch error:', error);
                const messageDiv = document.getElementById('message');
                messageDiv.textContent = 'An error occurred while logging in. Please try again.';
                messageDiv.style.color = 'red';
            }
        });
    </script>

</body>
</html>