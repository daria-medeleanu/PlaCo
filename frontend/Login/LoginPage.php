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
        
    <form action="/PlaCo/backend/controllers/User.php" method="post">
        <div class="wrapper"> 
            <div class="login-container">
                <input type="hidden" name="type" value="login">
                <input type="text" name="email" placeholder="Enter email" required>    
                <input type="password" name="password" placeholder="Enter password" required>
                <a class="wrapper-link" href="/home/ForgotPassword">Forgot your password?</a>
                <button class="login-btn" type="submit" >Login</button>            
                <div class="remember-me">
                    <input type="checkbox" id="remember-checkbox" name="remember">
                    <label for="remember-checkbox" class="checkbox-label">Remember me</label>
                </div>
                
                <a class="wrapper-link" href="register">Sign Up</a>
                <?php flash('login') ?>
            </div>
        </div>
    </form>

</body>
</html>