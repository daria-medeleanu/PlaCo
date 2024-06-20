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
        function setUserType(userType) {
            document.getElementById('user_type').value = userType;
        }
    </script>
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
    <form action="/PlaCo/backend/controllers/User.php" method="post">
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
                
                <a class="wrapper-link" href="/home/register">Log In</a>
                <?php flash('register') ?>
            </div>
        </div>
    </form>
    
</body>
</html>