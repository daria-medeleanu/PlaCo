<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . '/PlaCo/backend/helpers/session_helper.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/PlaCo/backend/controllers/pages-controller.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PlaCo Dashboard</title>
    <link rel="stylesheet" href="/PlaCo/frontend/Login/style/DashboardLogin.css"> 
    <link rel="shortcut icon" type="image/x-icon" href="/PlaCo/frontend/Login/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="header">
        <div class="nav-left">
            <a class="logo-pic" href="?page=home">
                <img src="/PlaCo/frontend/Login/logo.png" class="logo" alt="Logo">
                <div class="nav-btn-left">PlaCo</div>
            </a>
        </div>
        <div class="nav-right">
            <a href="?page=HowItWorks" class="nav-btn-left btn-dissapear">How it works</a>
            <div class="login-btn-wrapper">
                <a class="nav-btn-right" href="?page=login">Login</a>
            </div>
        </div>
        <a href="javascript:void(0);" class="icon" onclick="toggleMenu()">
            <i class="fa fa-bars"></i>
        </a>
    </div>
    <section class="box">
        <video src="/PlaCo/frontend/Login/video-start.mp4" autoplay muted loop></video>
        <h3>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit,sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, 
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum 
            dolore eu fugiat nulla pariatur.
        </h3>
        <div class="btn-cr-acc-menu">
            <div class="boxBtn"><a href="?page=register" > Hire a freelancer</a> </div>
            <div class="boxBtn"><a href="?page=register"> Start Freelancing</a></div>
        </div>

    </section>

    <script>
        function toggleMenu() {
            var navRight = document.querySelector('.nav-right');
            navRight.classList.toggle('collapsed');
        }    
    </script>

    <section class="info">
        <h2>Statistics</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel exercitationem quos excepturi asperiores,
            labore accusantium odit qui nesciunt. Est deserunt consequuntur perferendis aliquid earum ipsam aut quis, facere modi obcaecati!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel exercitationem quos excepturi asperiores,
            labore accusantium odit qui nesciunt. Est deserunt consequuntur perferendis aliquid earum ipsam aut quis, facere modi obcaecati!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel exercitationem quos excepturi asperiores,
            labore accusantium odit qui nesciunt. Est deserunt consequuntur perferendis aliquid earum ipsam aut quis, facere modi obcaecati!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel exercitationem quos excepturi asperiores,
            labore accusantium odit qui nesciunt. Est deserunt consequuntur perferendis aliquid earum ipsam aut quis, facere modi obcaecati!
        </p>
        <h2>Statistics</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel exercitationem quos excepturi asperiores,
            labore accusantium odit qui nesciunt. Est deserunt consequuntur perferendis aliquid earum ipsam aut quis, facere modi obcaecati!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel exercitationem quos excepturi asperiores,
            labore accusantium odit qui nesciunt. Est deserunt consequuntur perferendis aliquid earum ipsam aut quis, facere modi obcaecati!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel exercitationem quos excepturi asperiores,
            labore accusantium odit qui nesciunt. Est deserunt consequuntur perferendis aliquid earum ipsam aut quis, facere modi obcaecati!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel exercitationem quos excepturi asperiores,
            labore accusantium odit qui nesciunt. Est deserunt consequuntur perferendis aliquid earum ipsam aut quis, facere modi obcaecati!
        </p>
        <h2>Statistics</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel exercitationem quos excepturi asperiores,
            labore accusantium odit qui nesciunt. Est deserunt consequuntur perferendis aliquid earum ipsam aut quis, facere modi obcaecati!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel exercitationem quos excepturi asperiores,
            labore accusantium odit qui nesciunt. Est deserunt consequuntur perferendis aliquid earum ipsam aut quis, facere modi obcaecati!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel exercitationem quos excepturi asperiores,
            labore accusantium odit qui nesciunt. Est deserunt consequuntur perferendis aliquid earum ipsam aut quis, facere modi obcaecati!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel exercitationem quos excepturi asperiores,
            labore accusantium odit qui nesciunt. Est deserunt consequuntur perferendis aliquid earum ipsam aut quis, facere modi obcaecati!
        </p>
        <h2>Statistics</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel exercitationem quos excepturi asperiores,
            labore accusantium odit qui nesciunt. Est deserunt consequuntur perferendis aliquid earum ipsam aut quis, facere modi obcaecati!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel exercitationem quos excepturi asperiores,
            labore accusantium odit qui nesciunt. Est deserunt consequuntur perferendis aliquid earum ipsam aut quis, facere modi obcaecati!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel exercitationem quos excepturi asperiores,
            labore accusantium odit qui nesciunt. Est deserunt consequuntur perferendis aliquid earum ipsam aut quis, facere modi obcaecati!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel exercitationem quos excepturi asperiores,
            labore accusantium odit qui nesciunt. Est deserunt consequuntur perferendis aliquid earum ipsam aut quis, facere modi obcaecati!
        </p>
        <h2>Reviews</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel exercitationem quos excepturi asperiores,
            labore accusantium odit qui nesciunt. Est deserunt consequuntur perferendis aliquid earum ipsam aut quis, facere modi obcaecati!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel exercitationem quos excepturi asperiores,
            labore accusantium odit qui nesciunt. Est deserunt consequuntur perferendis aliquid earum ipsam aut quis, facere modi obcaecati!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel exercitationem quos excepturi asperiores,
            labore accusantium odit qui nesciunt. Est deserunt consequuntur perferendis aliquid earum ipsam aut quis, facere modi obcaecati!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel exercitationem quos excepturi asperiores,
            labore accusantium odit qui nesciunt. Est deserunt consequuntur perferendis aliquid earum ipsam aut quis, facere modi obcaecati!
        </p>
        <h2>Reviews</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel exercitationem quos excepturi asperiores,
            labore accusantium odit qui nesciunt. Est deserunt consequuntur perferendis aliquid earum ipsam aut quis, facere modi obcaecati!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel exercitationem quos excepturi asperiores,
            labore accusantium odit qui nesciunt. Est deserunt consequuntur perferendis aliquid earum ipsam aut quis, facere modi obcaecati!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel exercitationem quos excepturi asperiores,
            labore accusantium odit qui nesciunt. Est deserunt consequuntur perferendis aliquid earum ipsam aut quis, facere modi obcaecati!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel exercitationem quos excepturi asperiores,
            labore accusantium odit qui nesciunt. Est deserunt consequuntur perferendis aliquid earum ipsam aut quis, facere modi obcaecati!
        </p>
    </section>
</body>
</html>