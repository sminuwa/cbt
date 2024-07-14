@extends('layouts.candidate')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-xl-4 ">
                <div class="card social-profile">
                    <div class="card-body">
                        <div class="border-l-primary border-r-primary border-3" style="border-radius: 8px;">
                        <div class="social-img-wrap">
                            <div class="social-img"><img class="img-fluid" src="{{ asset('candidate/assets/images/avtar/16.jpg') }}" alt="profile"></div>
                        </div>
                        <div class="social-details">
                            <h5 class="mb-1">
                                <a href="#" class="text-uppercase">Sunusi Mohammed Inuwa</a>
                            </h5>
                            <span class="f-light">Exam No: B/123/001/21</span>
                        </div>
                        </div>
                        <div class="mt-2" style="text-align:left;">
                            <h5>Exam: JCHEW 2024</h5>
                            <h5>Duration: 2 hours</h5>
                            <span>Questions navigation</span>
                            <div class="btn-group btn-group-square">
                                @for($i = 1; $i<=70; $i++)
                                    <a class="btn border-none btn-{{ $i > 30 ? 'outline-':'' }}primary btn-sm btn-question {{ $i <30 ? 'disabled':'' }}"  href="javascript:;">
                                        {!!  $i < 30 ? '<i class="las la-check"></i>':$i  !!}
                                    </a>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8 col-xl-8">
                <div class="card">
                    <div class="card-header border-l-warning border-3">
                        <h4 class="card-title">
                            Subject :: JCHEW (Paper I)
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="text-center m-4">
                            <h5>SECTION: A</h5>
                            <h5>Instruction: Answer all</h5>
                        </div>
                        <div class="card-wrapper border rounded-3 fill-radios h-100 radio-toolbar checkbox-checked">
                            <h6 class="sub-title">The following is a form of periodontal surgical procceedures:</h6>
                            <div class="form-check radio radio-primary" style="width:100%">
                                <input class="form-check-input" id="radio111" type="radio" name="radio3" value="option1">
                                <label class="form-check-label" for="radio111">A. Product</label>
                            </div>
                            <div class="form-check radio radio-primary">
                                <input class="form-check-input" id="radio333" type="radio" name="radio3" value="option3">
                                <label class="form-check-label" for="radio333">B. Order history </label>
                            </div>
                            <div class="form-check radio radio-primary">
                                <input class="form-check-input" id="radio444" type="radio" name="radio3" value="option3">
                                <label class="form-check-label" for="radio444">C. Invoice </label>
                            </div>
                            <div class="form-check radio radio-primary">
                                <input class="form-check-input" id="radio666" type="radio" name="radio3" value="option3">
                                <label class="form-check-label" for="radio666">D. Wishlist</label>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-6">
                                <button class="btn btn-square btn-outline-primary" type="button" title="btn btn-square btn-outline-primary">
                                    <i class="las la-arrow-left"></i> Previous
                                </button>
                            </div>
                            <div class="col-6">
                                <div class="float-end">
                                    <button class="btn btn-square btn-outline-primary" type="button" title="btn btn-square btn-outline-primary">
                                        Next <i class="las la-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('style')
    <style>
        /*.radio-toolbar input[type="radio"] {
            display: none;
        }*/
        .radio-toolbar input[type="radio"]:checked+label {
            background-color: #006666;
            color:#ffffff;
            padding-right: 20px;
            border-radius: 8px;
        }
        .radio-toolbar input[type="radio"]:checked+label::after {
            content:'';
            width: 30px;
            background-color: #006666;
        }

        .clock {
            font-size: 2rem;
            font-family: Arial, sans-serif;
            font-weight: bolder;
            color: #006666; /* Initial color set to green */
        }

        .btn-question{
            padding: 3px 10px;
            width:45px;
        }

        .btn-group {
            flex-wrap: wrap;
        }
        .btn-group > :not(.btn-check:first-child) + .btn, .btn-group > .btn-group:not(:first-child) {
             margin-left: 0;
        }
    </style>

@endpush

@push('script')
    <script>

    </script>
@endpush
