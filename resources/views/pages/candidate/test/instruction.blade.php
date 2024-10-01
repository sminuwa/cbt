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
                                <td><img class="img-fluid" src="{!! logo() !!}" alt="" width="50"></td>
                                <td style="text-align: right; color:#999"><span>Instructions</span></td>
                            </tr>
                            </tbody>
                        </table>
                        <table style=" margin: 0 auto; background-color: #fff; border-radius: 8px">
                            <tbody>
                            <tr>
                                <td style="padding: 30px">
                                    <h2 style="text-align: center">Welcome to CHPRBN CBT Exam!</h2>

                                    <h3 class="text-lg font-bold mb-2">
                                        General instructions to candidates: <span class="font-normal">Read carefully</span>
                                    </h3>
                                    <ol class="list-decimal list-inside space-y-2 mb-6">
                                        <li>
                                            Your time will start counting as soon as you click on
                                            <span class="font-semibold">Start Exams</span>.
                                        </li>
                                        <li>Click on the subject code to view the questions.</li>
                                        <li>
                                            Use the <span class="font-semibold">NAVIGATION</span> panel to quickly move to desired
                                            questions.
                                        </li>
                                        <li>Answers are automatically saved as they are selected.</li>
                                        <li>
                                            Avoid using <span class="font-semibold">Forward, Backward, Refresh</span> buttons of your
                                            browser as they may log you out.
                                        </li>
                                        <li>
                                            Once you click on the <span class="font-semibold">Submit Button</span>, you cannot come back
                                            to the test again.
                                        </li>
                                        <li>
                                          <span class="font-semibold">
                                              You are advised to adhere strictly to the examination Regulations/Discipline as spelt out
                                            in the current University/Faculty prospectus and Information brochure. Ignorance of these
                                            regulations will not be accepted as an excuse for any misdemeanors.
                                          </span>
                                        </li>
                                        <li>
                                            Borrowing of pencils, biros, calculator etc is not allowed as each candidate is expected to
                                            have his/hers.
                                        </li>
                                        <li>GSM Handset(s) switched or un-switched are not allowed in the examination hall.</li>
                                    </ol>

                                    <p><strong>Good luck!</strong></p>
                                    <div class="text-center"><a href="{{ route('candidate.test.question') }}" style="padding: 10px; background-color: #006666; color: #fff; display: inline-block; border-radius:30px; margin-bottom:18px; font-weight:600; padding:0.6rem 1.75rem;">Start Exams</a></div>
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
