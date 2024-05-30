<?php 
    include_once '../../backend/helpers/session_helper.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style/LoginPage.css"> 
    <link rel="shortcut icon" type="image/x-icon" href="logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">

</head>
<body>
    <div class="logo">
        <div class="logo-content">
            <a class="logo-pic" href="DashboardLogin.php">
                <div class="logo-pic">
                    <img src="logo.png" class="logo-image" alt="Logo">
                </div>
                <div class="writing">PlaCo</div>
            </a>
        </div>
    </div>
        
    <div class="title">
        <h2>Sign Up</h2>
    </div>
    <?php flash('register') ?>
    <form action="../../backend/controllers/User.php" method="post">
        <div class="wrapper"> 
            <div class="login-container">
                <input type="hidden" name="type" value="register">
                <input type="text" name="fname" placeholder="Enter first name" required> 
                <input type="text" name="lname" placeholder="Enter last name" required>    
                <input type="email" name="email" placeholder="Enter email example: mary@gmail.com" required>     
                <input type="password" name="psw" placeholder="Enter password" required>
                <input type="password" name="psw-conf" placeholder="Confirm your password" required>
                <div class="sign-up-menu">
                    <button class="login-btn sign-up-btn" type="submit" >Sign Up as Freelancer</button>            
                    <button class="login-btn sign-up-btn" type="submit" >Sign Up as Client</button>            
                </div>
                
                <a class="wrapper-link" href="LoginPage.php">Log In</a>
            </div>
        </div>
    </form>

</body>
</html>