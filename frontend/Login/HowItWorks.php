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
            <a class="logo-pic" href="/home/home">
                <img src="/PlaCo/frontend/Login/logo.png" class="logo" alt="Logo">
                <div class="nav-btn-left">PlaCo</div>
            </a>
        </div>
        <div class="nav-right">
            <a href="/home/HowItWorks" class="nav-btn-left btn-dissapear">How it works</a>
            <div class="login-btn-wrapper">
                <a class="nav-btn-right" href="/home/login">Login</a>
            </div>
        </div>
        <a href="javascript:void(0);" class="icon" onclick="toggleMenu()">
            <i class="fa fa-bars"></i>
        </a>
    </div>
    <div class="content-wrapper">
        <div class="sections-wrapper">
            <div class="section">
                    <div class="number-wrapper">
                        <img src="/PlaCo/frontend/Login/img/1.png" class="img-steps" alt="img">
                    </div>
                    <div class="steps-info">Register on PlaCo by creating an account. Provide necessary information such as your name, email, and contact details. Verify your account through the confirmation email you will receive.</div>
                <div style="display:none">1. Register on PlaCo by creating an account. Provide necessary information such as your name, email, and contact details. Verify your account through the confirmation email you will receive.</div>
            </div>
            <div class="section">
                    <div class="number-wrapper">
                        <img src="/PlaCo/frontend/Login/img/2.png" class="img-steps" alt="img">
                    </div>
                    <div class="steps-info">Post a project with a detailed description of the work needed, including any specific requirements or skills necessary. Attach relevant documents or plans to provide freelancers with a clear understanding of the project scope.</div>
                <div style="display:none">2. Post a project with a detailed description of the work needed, including any specific requirements or skills necessary. Attach relevant documents or plans to provide freelancers with a clear understanding of the project scope.</div>
            </div>
            <div class="section">
                <div class="number-wrapper">
                    <img src="/PlaCo/frontend/Login/img/3.png" class="img-steps" alt="img">
                </div>
                <div class="steps-info">Receive bids from qualified freelancers who express interest in your project. Review their profiles, past work, ratings, and feedback from previous clients to make an informed decision.</div>
                <div style="display:none">3. Receive bids from qualified freelancers who express interest in your project. Review their profiles, past work, ratings, and feedback from previous clients to make an informed decision.</div>
            </div>
            <div class="section">
                <div class="number-wrapper">
                    <img src="/PlaCo/frontend/Login/img/4.png" class="img-steps" alt="img">
                </div>
                <div class="steps-info">Select the freelancer whose bid, skills, and experience best match your project needs. You can communicate with potential candidates to clarify any questions before making your final selection.</div>
                <div style="display:none">4. Select the freelancer whose bid, skills, and experience best match your project needs. You can communicate with potential candidates to clarify any questions before making your final selection.</div>
             </div>
            <div class="section">
                <div class="number-wrapper">
                    <img src="/PlaCo/frontend/Login/img/5.png" class="img-steps" alt="img">
                </div>
                <div class="steps-info">Agree on the terms, timeline, and milestones for the project. Utilize PlaCo’s secure payment system to manage payments, ensuring funds are only released when you are satisfied with the completed work.</div>
                <div style="display:none">5. Agree on the terms, timeline, and milestones for the project. Utilize PlaCo’s secure payment system to manage payments, ensuring funds are only released when you are satisfied with the completed work.</div>
          </div>
            <div class="section">
                <div class="number-wrapper">
                    <img src="/PlaCo/frontend/Login/img/6.png" class="img-steps" alt="img">
                </div>
                <div class="steps-info">Monitor the progress of your project through regular updates and communication with your freelancer. Provide feedback and address any issues promptly to keep the project on track.</div>
                <div style="display:none">6. Monitor the progress of your project through regular updates and communication with your freelancer. Provide feedback and address any issues promptly to keep the project on track.</div>
           </div>
            <div class="section">
                <div class="number-wrapper">
                    <img src="/PlaCo/frontend/Login/img/7.png" class="img-steps" alt="img">
                </div>
                <div class="steps-info">Once the project is completed to your satisfaction, release the final payment to the freelancer and provide a rating and review of their work. This feedback helps maintain the quality of service on PlaCo.</div>
                <div style="display:none">7. Once the project is completed to your satisfaction, release the final payment to the freelancer and provide a rating and review of their work. This feedback helps maintain the quality of service on PlaCo.</div>
             </div>
            <div class="section">
                <div class="number-wrapper">
                    <img src="/PlaCo/frontend/Login/img/8.png" class="img-steps" alt="img">
                </div>
                <div class="steps-info">Continue to use PlaCo for future projects, leveraging your experience and previous freelancers’ reviews to find the best professionals for your ongoing needs.</div>
                <div style="display:none">8. Continue to use PlaCo for future projects, leveraging your experience and previous freelancers’ reviews to find the best professionals for your ongoing needs.</div>
           </div>
        </div>
        <div class="how-to-buttons">
            <div class="how-to-btn-1" style="background-color: #ddbf8d;" onclick="showInfo(1)">How to Hire a Freelancer for your Project</div>
            <div class="how-to-btn-2" onclick="showInfo(2)">How to start your Freelancing </div>
        </div>
        <div class="how-to-info">
            <div class="how-to-info-1">
            <p>
                    1. <strong>Register an Account:</strong> Sign up on PlaCo by creating a new account. Complete your profile with accurate information to ensure a smooth hiring process.
                </p>
                <p>
                    2. <strong>Post Your Project:</strong> Detail your project requirements, including specific skills needed, deadlines, and any relevant documents or plans.
                </p>
                <p>
                    3. <strong>Review Bids:</strong> Evaluate the bids from interested freelancers. Look at their profiles, past projects, ratings, and reviews to select the best candidate.
                </p>
                <p>
                    4. <strong>Select a Freelancer:</strong> Communicate with the shortlisted candidates to clarify any details. Choose the freelancer who best meets your project needs and budget.
                </p>
                <p>
                    5. <strong>Set Terms and Milestones:</strong> Agree on the project's timeline, milestones, and payment terms. Use PlaCo’s secure payment system to manage transactions.
                </p>
                <p>
                    6. <strong>Monitor Progress:</strong> Keep track of the project through regular updates from the freelancer. Provide feedback and address any issues to ensure timely completion.
                </p>
                <p>
                    7. <strong>Complete the Project:</strong> Once satisfied with the work, release the final payment to the freelancer. Leave a review to help maintain the platform's quality.
                </p>
                <p>
                    8. <strong>Plan Future Projects:</strong> Use your experience and freelancer reviews to hire professionals for future projects with confidence.
                </p>
            </div>
            <div class="how-to-info-2" style="display:none">
            <p>
                    1. <strong>Create Your Profile:</strong> Sign up on PlaCo and build a detailed profile. Highlight your skills, experience, and any relevant work samples to attract potential clients.
                </p>
                <p>
                    2. <strong>Browse Projects:</strong> Explore available projects that match your skill set. Pay attention to project details, budgets, and deadlines.
                </p>
                <p>
                    3. <strong>Submit Bids:</strong> Write compelling proposals for projects you're interested in. Highlight how your skills and experience make you the best fit for the project.
                </p>
                <p>
                    4. <strong>Communicate with Clients:</strong> Engage with potential clients to understand their needs better. Ask questions to clarify project requirements and establish a good rapport.
                </p>
                <p>
                    5. <strong>Manage Projects:</strong> Once hired, communicate regularly with your client. Set clear milestones and deliverables to keep the project on track.
                </p>
                <p>
                    6. <strong>Deliver Quality Work:</strong> Ensure your work meets or exceeds client expectations. Timely and high-quality delivery will help you earn positive reviews and repeat business.
                </p>
                <p>
                    7. <strong>Get Paid:</strong> Use PlaCo’s secure payment system to receive payments. Make sure to understand the payment terms before starting any project.
                </p>
                <p>
                    8. <strong>Build Your Reputation:</strong> Gather positive reviews from satisfied clients. A strong reputation on PlaCo will help you attract more clients and higher-paying projects.
                </p>
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