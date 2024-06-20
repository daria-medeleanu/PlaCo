<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . '/PlaCo/backend/helpers/session_helper.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/PlaCo/backend/controllers/pages-controller.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot your password</title>
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
        <h2>Recover your password</h2>
    </div>
    
    <form action="/action_page.php" method="post">
        <div class="wrapper"> 
            <div class="login-container">
                <div class="message-forg-pass">
                    Enter your email and we’ll send you a link to reset your password:
                </div>
                <input type="email" name="uname" placeholder="Enter email example: mary@gmail.com" required>     
                
                <button class="login-btn" type="submit" >Reset your password</button>            
                
                <a class="wrapper-link" href="/home/login">Back</a>
            </div>
        </div>
    </form>

</body>
</html>