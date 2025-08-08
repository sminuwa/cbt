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
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/font-awesome.css') }}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/vendors/icofont.css') }}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/vendors/themify.css') }}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/vendors/flag-icon.css') }}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/vendors/feather-icon.css') }}">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/vendors/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/vendors/slick-theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/vendors/scrollbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/vendors/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/vendors/date-picker.css') }}">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/vendors/bootstrap.css') }}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('candidate/assets/css/color-1.css') }}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/responsive.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/line-awesome/css/line-awesome.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/vendors/sweetalert2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('commons/css/calculator.css') }}">
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
    <style type="text/css">
        @media only screen and (max-width: 767px){
            .score-breakdown {
                flex-direction: column !important;
            }
            .score-card {
                min-width: 100% !important;
            }
        }
    </style>
</head>
<body style="margin: 30px auto;">
<?php
    $candidate = session('candidate');
    $scheduled_candidate = session('scheduled_candidate');
    $candidate_subjects = session('candidate_subjects');
    $test = session('test');
    $time_difference = session('time_difference');
    $remaining_seconds = session('remaining_seconds');
    $time_control = session('time_control');
    $time_elapsed = $time_control->elapsed;
?>
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
                                <td style="text-align: right; color:#999"><span>Submission</span></td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="card social-profile" style="border-radius:25px">
                            <div class="card-body">
                                <div class="border-l-primary border-r-primary border-3" style="border-radius: 8px;">
                                    <div class="social-img-wrap">
                                        <div class="social-img"><img class="img-fluid" src="{{ $candidate->passport() }}" alt="profile"></div>
                                    </div>
                                    
                                    <div class="social-details">
                                        <h5 class="mb-1">
                                            <a href="#" class="text-uppercase">{{ $candidate->fullname() }}</a>
                                        </h5>
                                        <span class="f-light">Exam No: {{ $candidate->indexing ?? null }}</span>
                                        <hr>
                                        
                                        <?php
                                            // Calculate exam scores
                                            use App\Models\Score;
                                            use App\Models\CandidateSubject;
                                            
                                            $total_score = 0;
                                            $total_questions = 0;
                                            $subject_scores = [];
                                            
                                            // Get all scores for this candidate and test
                                            $scores = Score::where([
                                                'scheduled_candidate_id' => $scheduled_candidate->id,
                                                'test_config_id' => $test->id
                                            ])->get();
                                            
                                            // Get candidate subjects for this test
                                            $candidate_subjects = CandidateSubject::where('scheduled_candidate_id', $scheduled_candidate->id)
                                                ->join('subjects', 'subjects.id', '=', 'candidate_subjects.subject_id')
                                                ->select('candidate_subjects.*', 'subjects.name as subject_name')
                                                ->get();
                                            
                                            // Calculate scores by subject
                                            foreach($candidate_subjects as $subject) {
                                                $subject_total = 0;
                                                $subject_questions = 0;
                                                
                                                foreach($scores as $score) {
                                                    // Get question bank to determine subject
                                                    $question = \App\Models\QuestionBank::find($score->question_bank_id);
                                                    if($question && $question->subject_id == $subject->subject_id) {
                                                        $subject_total += $score->point_scored;
                                                        $subject_questions++;
                                                    }
                                                }
                                                
                                                $subject_scores[] = [
                                                    'name' => $subject->subject_name,
                                                    'score' => $subject_total,
                                                    'questions' => $subject_questions,
                                                    'percentage' => $subject_questions > 0 ? round(($subject_total / $subject_questions) * 100, 2) : 0
                                                ];
                                                
                                                $total_score += $subject_total;
                                                $total_questions += $subject_questions;
                                            }
                                            
                                            $overall_percentage = $total_questions > 0 ? round(($total_score / $total_questions) * 100, 2) : 0;
                                        ?>
                                        
                                        <div style="background-color: #f8f9fa; padding: 20px; border-radius: 10px; margin: 20px 0;">
                                            <h3 style="text-align: center; color: #28a745; margin-bottom: 20px;">
                                                <i class="fa fa-check-circle"></i> Exam Completed Successfully!
                                            </h3>
                                            
                                            <!-- Overall Score -->
                                            {{-- <div style="text-align: center; margin-bottom: 25px;">
                                                <div style="background-color: #007bff; color: white; padding: 15px; border-radius: 8px; display: inline-block; min-width: 200px;">
                                                    <h4 style="margin: 0; font-size: 24px;">{{ $overall_percentage }}%</h4>
                                                    <p style="margin: 5px 0 0 0;">Overall Score</p>
                                                    <small>({{ $total_score }} out of {{ $total_questions }} questions)</small>
                                                </div>
                                            </div> --}}
                                            
                                            <!-- Subject-wise Breakdown -->
                                            {{-- @if(count($subject_scores) > 1)
                                            <div style="margin-bottom: 20px;">
                                                <h5 style="text-align: center; margin-bottom: 15px;">Subject-wise Performance</h5>
                                                <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 15px;">
                                                    @foreach($subject_scores as $subject)
                                                    <div style="background-color: white; padding: 15px; border-radius: 8px; border: 1px solid #dee2e6; min-width: 180px; text-align: center;">
                                                        <h6 style="margin: 0 0 10px 0; color: #495057;">{{ $subject['name'] }}</h6>
                                                        <div style="font-size: 20px; font-weight: bold; color: 
                                                            @if($subject['percentage'] >= 70) #28a745
                                                            @elseif($subject['percentage'] >= 50) #ffc107
                                                            @else #dc3545
                                                            @endif
                                                        ;">
                                                            {{ $subject['percentage'] }}%
                                                        </div>
                                                        <small style="color: #6c757d;">{{ $subject['score'] }}/{{ $subject['questions'] }}</small>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endif --}}
                                            
                                            <!-- Performance Message -->
                                            {{-- <div style="text-align: center; margin: 20px 0;">
                                                @if($overall_percentage >= 70)
                                                    <div style="color: #28a745; font-weight: bold;">
                                                        <i class="fa fa-star"></i> Excellent Performance!
                                                    </div>
                                                @elseif($overall_percentage >= 50)
                                                    <div style="color: #ffc107; font-weight: bold;">
                                                        <i class="fa fa-thumbs-up"></i> Good Job!
                                                    </div>
                                                @endif
                                            </div> --}}
                                            
                                            <!-- Submission Details -->
                                            <div style="background-color: #e9ecef; padding: 15px; border-radius: 8px; margin-top: 20px;">
                                                <h6 style="margin: 0 0 10px 0;">Submission Details:</h6>
                                                <div style="display: flex; justify-content: space-between; flex-wrap: wrap; gap: 10px; font-size: 14px;">
                                                    <span><strong>Submitted:</strong> {{ date('M d, Y H:i:s') }}</span>
                                                    <span><strong>Duration:</strong> {{ gmdate('H:i:s', $time_control->elapsed) }}</span>
                                                    <span><strong style="color:red">Total Score:</strong> {{ $total_score }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="text-center">
                                            <a href="{{ route('candidate.auth.page') }}" style="padding: 10px; background-color: #006666; color: #fff; display: inline-block; border-radius:30px; margin-bottom:18px; font-weight:600; padding:0.6rem 1.75rem;">
                                                Continue
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        
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
<?php
    use Illuminate\Support\Facades\Auth;
        Auth::guard('web')->logout();
        request()->session()->invalidate();

?>
