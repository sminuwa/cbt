<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="CHPRBN">
    <link rel="icon" href="https://admin.pixelstrap.net/riho/assets/images/favicon/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="https://admin.pixelstrap.net/riho/assets/images/favicon/favicon.png" type="image/x-icon">
    <title>CBT Exam Instructions</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <style type="text/css">
        body{
            font-family: 'Montserrat', sans-serif;
            background-color: #f6f7fb;
            display: block;
            width: 750px;
            padding: 0 12px;
        }
        a{
            text-decoration: none;
        }
        span {
            font-size: 14px;
        }
        p {
            font-size: 13px;
            line-height: 1.7;
            letter-spacing: 0.7px;
            margin-top: 0;
        }
        .text-center{
            text-align: center
        }
        @media only screen and (max-width: 767px){
            body{
                width: auto;
                margin: 20px auto;
            }
            .logo-sec{
                width: 500px !important;
            }
        }
        @media only screen and (max-width: 575px){
            .logo-sec{
                width: 400px !important;
            }
        }
        @media only screen and (max-width: 480px){
            .logo-sec{
                width: 300px !important;
            }
        }
        @media only screen and (max-width: 360px){
            .logo-sec{
                width: 250px !important;
            }
        }
    </style>
</head>
<body style="margin: 30px auto;">
<table style="width: 100%">
    <tbody>
    <tr>
        <td>
            <table style="background-color: #f6f7fb; width: 100%">
                <tbody>
                <tr>
                    <td>
                        <table style="margin: 0 auto; margin-bottom: 30px">
                            <tbody>
                            <tr class="logo-sec" style="display: flex; align-items: center; justify-content: space-between; width: 650px;">
                                <td><img class="img-fluid" src="{{ asset('candidate/assets/images/logo/logo.png') }}" alt="" width="50"></td>
                                <td style="text-align: right; color:#999"><span>Instructions</span></td>
                            </tr>
                            </tbody>
                        </table>
                        <table style=" margin: 0 auto; background-color: #fff; border-radius: 8px">
                            <tbody>
                            <tr>
                                <td style="padding: 30px">
                                    <h2 style="text-align: center">Welcome to CHPRBN CBT Exam!</h2>
                                    <p>Please read the following instructions carefully before starting the exam:</p>

                                    <h3>Timing:</h3>
                                    <ul>
                                        <li>The exam duration is <strong>2 hours</strong>. The timer will start as soon as you begin the exam.</li>
                                        <li>Ensure you complete all sections within the allotted time. Unsubmitted answers will not be counted once the time expires.</li>
                                    </ul>

                                    <h3>Navigation:</h3>
                                    <ul>
                                        <li>Use the <strong>Next</strong> and <strong>Previous</strong> buttons to navigate between questions.</li>
                                        <li>You can <strong>flag questions</strong> for review if you need to revisit them later.</li>
                                        <li>At any point, you can see an overview of all questions and flagged items by clicking the <strong>Review</strong> button.</li>
                                    </ul>

                                    <h3>Answering Questions:</h3>
                                    <ul>
                                        <li>Questions may be multiple-choice, true/false, fill-in-the-blank, or essay types.</li>
                                        <li>For multiple-choice and true/false questions, select your answer by clicking on the option.</li>
                                        <li>For fill-in-the-blank questions, type your answer in the provided text box.</li>
                                        <li>For essay questions, write your response in the text editor provided.</li>
                                    </ul>

                                    <h3>Submitting the Exam:</h3>
                                    <ul>
                                        <li>You must submit your exam before the time expires. Click the <strong>Submit Exam</strong> button once you have completed all questions.</li>
                                        <li>After submission, you will not be able to change any answers or re-enter the exam.</li>
                                    </ul>

                                    <h3>Technical Issues:</h3>
                                    <ul>
                                        <li>If you encounter any technical issues during the exam, please contact the technical support team immediately using the chat feature or call the support number provided.</li>
                                    </ul>

                                    <h3>Exam Rules:</h3>
                                    <ul>
                                        <li>No external help or collaboration is allowed during the exam.</li>
                                        <li>Do not open any other browser tabs or applications.</li>
                                        <li>Ensure your internet connection is stable throughout the exam duration.</li>
                                    </ul>

                                    <h3>Integrity:</h3>
                                    <ul>
                                        <li>Academic integrity is crucial. Any form of cheating or dishonesty will result in disqualification.</li>
                                    </ul>

                                    <h3>Review:</h3>
                                    <ul>
                                        <li>If you finish early, use the remaining time to review your answers.</li>
                                        <li>Make sure all questions are answered to the best of your ability.</li>
                                    </ul>

                                    <p>By starting the exam, you acknowledge that you have read and understood these instructions and agree to abide by the exam rules and regulations.</p>

                                    <p><strong>Good luck!</strong></p>
                                    <div class="text-center"><a href="{{ route('candidate.test.question') }}" style="padding: 10px; background-color: #006666; color: #fff; display: inline-block; border-radius:30px; margin-bottom:18px; font-weight:600; padding:0.6rem 1.75rem;">Start </a></div>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
