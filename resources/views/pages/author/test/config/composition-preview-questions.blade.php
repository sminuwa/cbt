@php use App\Models\QuestionBank; @endphp
@extends('layouts.app')
@section('css')
    <style>
        .list-group.ordered-list {
            counter-reset: list-counter;
        }

        .list-group.ordered-list .list-group-item {
            position: relative;
            padding-left: 25px;
        }

        .list-group.ordered-list .list-group-item::before {
            content: counter(list-counter, upper-alpha) ".  ";
            counter-increment: list-counter;
            position: absolute;
            left: 0em;
            top: 0.5em;
        }
    </style>
@endsection
@section('content')
    @php
        $sections = $testSubject->test_sections;
    @endphp
    @foreach($sections as $section)
        <div class="card border-info">
            <div class="card-header border-info">
                <div class="row">
                    <div>
                        <h4 class="card-title d-flex justify-content-center mb-1">
                            <span><strong>SECTION:</strong> {{$section->title}}</span>
                        </h4>
                        <h4 class="d-flex justify-content-center">
                            <strong style="display: inline-block">INSTRUCTION: </strong>
                            <span style="display: inline-block">@php echo $section->instruction; @endphp</span>
                        </h4>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                @php
                    $ids = $section->test_questions->pluck('question_bank_id');
                    $questions = QuestionBank::with('answer_options')->whereIn('id',$ids)->get();
                @endphp

                @foreach($questions as $question)
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="mt-3 d-flex justify-content-between">
                                <p>
                                    <strong>Question {{$loop->iteration}}: </strong> @php echo $question->title; @endphp
                                </p>
                            </div>
                            <div id="options-{{$question->id}}" class="card-body pt-2 pb-2  mt-1 mb-1">
                                <div class="row">
                                    <div class="row pb-3 pt-2">
                                        <ol class="list-group list-group-flush ordered-list">
                                            @foreach($question->answer_options as $option)
                                                <li class="list-group-item {{$option->correctness=='1'?'list-group-item-success':''}}">{{ $option->question_option }}</li>
                                            @endforeach
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        {{--        <div class="card border-info">--}}
        {{--            <div class="card-header border-info">--}}
        {{--                Available Test Subjects--}}
        {{--            </div>--}}
        {{--            <div class="card-body p-3">--}}
        {{--                <div class="row">--}}
        {{--                    <div class="col-12">--}}

        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}
    @endforeach
@endsection
