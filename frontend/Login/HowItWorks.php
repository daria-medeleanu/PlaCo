<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . '/PlaCo/backend/helpers/session_helper.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/PlaCo/backend/controllers/pages-controller.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>How it works</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/PlaCo/frontend/Login/style/DashboardLogin.css"> 
    <link rel="shortcut icon" type="image/x-icon" href="/PlaCo/frontend/Login/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/PlaCo/frontend/Login/style/HowItWorks.css">
</head>
<body>
    <div class="header">
        <div class="nav-left">
            <a class="logo-pic" href="DashboardLogin.php">
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
    <div class="content-wrapper">
        <div class="sections-wrapper">
            <div class="section">
                <!-- <section> -->
                    <div class="number-wrapper">
                        <img src="/PlaCo/frontend/Login/img/1.png" class="img-steps" alt="img">
                    </div>
                    <div class="steps-info">The World Wide Fund for Nature (WWF) is an international organization working on issues regarding the conservation, research and restoration of the environment, formerly named the World Wildlife Fund. WWF was founded in 1961.</div>
                    <div style="display:none">1. The World Wide Fund for Nature (WWF) is an international organization working on issues regarding the conservation, research and restoration of the environment, formerly named the World Wildlife Fund. WWF was founded in 1961.</div>
                <!-- </section> -->
            </div>
            <div class="section">
                <!-- <section> -->
                    <div class="number-wrapper">
                        <img src="/PlaCo/frontend/Login/img/2.png" class="img-steps" alt="img">
                    </div>
                    <div class="steps-info">The World Wide Fund for Nature (WWF) is an international organization working on issues regarding the conservation, research and restoration of the environment, formerly named the World Wildlife Fund. WWF was founded in 1961.</div>
                    <div style="display:none">1. The World Wide Fund for Nature (WWF) is an international organization working on issues regarding the conservation, research and restoration of the environment, formerly named the World Wildlife Fund. WWF was founded in 1961.</div>
                <!-- </section> -->
            </div>
            <div class="section">
                <div class="number-wrapper">
                    <img src="/PlaCo/frontend/Login/img/3.png" class="img-steps" alt="img">
                </div>
                <div class="steps-info">The World Wide Fund for Nature (WWF) is an international organization working on issues regarding the conservation, research and restoration of the environment, formerly named the World Wildlife Fund. WWF was founded in 1961.</div>
                <div style="display:none">1. The World Wide Fund for Nature (WWF) is an international organization working on issues regarding the conservation, research and restoration of the environment, formerly named the World Wildlife Fund. WWF was founded in 1961.</div>
            </div>
            <div class="section">
                <div class="number-wrapper">
                    <img src="/PlaCo/frontend/Login/img/4.png" class="img-steps" alt="img">
                </div>
                <div class="steps-info">The World Wide Fund for Nature (WWF) is an international organization working on issues regarding the conservation, research and restoration of the environment, formerly named the World Wildlife Fund. WWF was founded in 1961.</div>
                <div style="display:none">1. The World Wide Fund for Nature (WWF) is an international organization working on issues regarding the conservation, research and restoration of the environment, formerly named the World Wildlife Fund. WWF was founded in 1961.</div>
            </div>
            <div class="section">
                <div class="number-wrapper">
                    <img src="/PlaCo/frontend/Login/img/5.png" class="img-steps" alt="img">
                </div>
                <div class="steps-info">The World Wide Fund for Nature (WWF) is an international organization working on issues regarding the conservation, research and restoration of the environment, formerly named the World Wildlife Fund. WWF was founded in 1961.</div>
                <div style="display:none">1. The World Wide Fund for Nature (WWF) is an international organization working on issues regarding the conservation, research and restoration of the environment, formerly named the World Wildlife Fund. WWF was founded in 1961.</div>
            </div>
            <div class="section">
                <div class="number-wrapper">
                    <img src="/PlaCo/frontend/Login/img/6.png" class="img-steps" alt="img">
                </div>
                <div class="steps-info">The World Wide Fund for Nature (WWF) is an international organization working on issues regarding the conservation, research and restoration of the environment, formerly named the World Wildlife Fund. WWF was founded in 1961.</div>
                <div style="display:none">1. The World Wide Fund for Nature (WWF) is an international organization working on issues regarding the conservation, research and restoration of the environment, formerly named the World Wildlife Fund. WWF was founded in 1961.</div>
            </div>
            <div class="section">
                <div class="number-wrapper">
                    <img src="/PlaCo/frontend/Login/img/7.png" class="img-steps" alt="img">
                </div>
                <div class="steps-info">The World Wide Fund for Nature (WWF) is an international organization working on issues regarding the conservation, research and restoration of the environment, formerly named the World Wildlife Fund. WWF was founded in 1961.</div>
                <div style="display:none">1. The World Wide Fund for Nature (WWF) is an international organization working on issues regarding the conservation, research and restoration of the environment, formerly named the World Wildlife Fund. WWF was founded in 1961.</div>
            </div>
            <div class="section">
                <div class="number-wrapper">
                    <img src="/PlaCo/frontend/Login/img/8.png" class="img-steps" alt="img">
                </div>
                <div class="steps-info">The World Wide Fund for Nature (WWF) is an international organization working on issues regarding the conservation, research and restoration of the environment, formerly named the World Wildlife Fund. WWF was founded in 1961.</div>
                <div style="display:none">1. The World Wide Fund for Nature (WWF) is an international organization working on issues regarding the conservation, research and restoration of the environment, formerly named the World Wildlife Fund. WWF was founded in 1961.</div>
            </div>
        </div>
        <div class="how-to-buttons">
            <div class="how-to-btn-1" style="background-color: #ddbf8d;" onclick="showInfo(1)">How to Hire a Freelancer for your Project</div>
            <div class="how-to-btn-2" onclick="showInfo(2)">How to start your Freelancing </div>
        </div>
        <div class="how-to-info">
            <div class="how-to-info-1">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Vel assumenda delectus ad minus consequatur totam, possimus expedita voluptatem. Alias natus modi quam autem, mollitia nam necessitatibus ipsum quae dolorum qui.
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Vel assumenda delectus ad minus consequatur totam, possimus expedita voluptatem. Alias natus modi quam autem, mollitia nam necessitatibus ipsum quae dolorum qui.
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Vel assumenda delectus ad minus consequatur totam, possimus expedita voluptatem. Alias natus modi quam autem, mollitia nam necessitatibus ipsum quae dolorum qui.

            </div>
            <div class="how-to-info-2" style="display:none">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat assumenda suscipit laudantium iusto dignissimos vitae ab. Suscipit nostrum reprehenderit sequi quos corrupti enim est, omnis nesciunt quasi impedit totam animi?
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat assumenda suscipit laudantium iusto dignissimos vitae ab. Suscipit nostrum reprehenderit sequi quos corrupti enim est, omnis nesciunt quasi impedit totam animi?
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat assumenda suscipit laudantium iusto dignissimos vitae ab. Suscipit nostrum reprehenderit sequi quos corrupti enim est, omnis nesciunt quasi impedit totam animi?
            
            </div>
        </div>
        
    </div>

    <script>
        
        function toggleMenu() {
            var navRight = document.querySelector('.nav-right');
            navRight.classList.toggle('collapsed');
        }    

        const buttons = document.querySelectorAll('.how-to-btn');
        function showInfo(infoNumber) {
            document.querySelectorAll('.how-to-info > div').forEach(function(element) {
            element.style.display = 'none';
        });

        document.querySelector('.how-to-info-' + infoNumber).style.display = 'block';

        document.querySelectorAll('.how-to-buttons > div').forEach(function(element) {
            element.style.backgroundColor = '';
        });

        document.querySelector('.how-to-btn-' + infoNumber).style.backgroundColor = '#ddbf8d';

}

    </script>
</body>
</html>