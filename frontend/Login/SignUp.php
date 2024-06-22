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

    <form id="signUpForm">
        <div class="wrapper"> 
            <div class="login-container">
                <input type="hidden" name="type" value="register">
                <input type="hidden" name="user_type" id="user_type" value="">
                <input type="text" name="prenume" id="prenume" placeholder="Enter first name" required> 
                <input type="text" name="nume" id="nume" placeholder="Enter last name" required>    
                <input type="email" name="email" id="email" placeholder="Enter email example: mary@gmail.com" required>     
                <input type="password" name="password_hash" id="password_hash" placeholder="Enter password" required>
                <input type="password" name="psw-conf" id="psw-conf" placeholder="Confirm your password" required>
                <div class="sign-up-menu">
                    <button class="login-btn sign-up-btn" type="submit" onclick="setUserType('freelancer')">Sign Up as Freelancer</button>            
                    <button class="login-btn sign-up-btn" type="submit" onclick="setUserType('client')">Sign Up as Client</button>            
                </div>
                
                <a class="wrapper-link" href="/home/login">Log In</a>
                <div id="message"></div>
            </div>
        </div>
    </form>
    <script>
        
        function setUserType(userType) {
            document.getElementById('user_type').value = userType;
        }

        document.getElementById('signUpForm').addEventListener('submit', async function(event){
            event.preventDefault();

            const prenume = document.getElementById('prenume').value;
            const nume = document.getElementById('nume').value;
            const email = document.getElementById('email').value;
            const password_hash = document.getElementById('password_hash').value;
            const psw_conf = document.getElementById('psw-conf').value;
            const user_type = document.getElementById('user_type').value;
 
            const requestBody = {
                type: 'register',
                prenume : prenume,
                nume: nume, 
                email: email, 
                password_hash: password_hash, 
                psw_conf : psw_conf,
                user_type : user_type
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
                        messageDiv.style.color = 'green';
                        window.location.href = '/home/login';
                        
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