@php use App\Models\Centre;use App\Models\ExamsDate;use App\Models\Scheduling;use Carbon\Carbon; @endphp
@extends('layouts.app')

@section('content')
    @if(session()->has('success'))
        @if(!session('success'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @else
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    @endif
    <div class="card border-info">
        <div class="card-header">
            <div class="row">
                <div>
                    <h4 class="card-title d-flex justify-content-between">
                        <span>Test Composition</span>
                    </h4>
                </div>
            </div>
        </div>
        <div class="card-body pt-0" style="padding: 1px !important;"></div>
    </div>
    <div class="card border-info">
        @php
            $subject = $testSection->test_subject->subject;
        @endphp
        <div class="card-header border-info">
            Compose Questions for <strong>{{$testSection->title}}</strong> of
            <strong>{{$subject->subject_code}}</strong>
        </div>
        <div class="card-body p-3">
            <form id="load-form" method="post">
                @csrf
                <input type="hidden" name="subject_id" value="{{$subject->id}}">
                <div class="row">
                    <div class="col-3 col-md-12 col-lg-3 col-xl-3">
                        <div class="form-group">
                            <label for="difficulty">Difficulty Level:</label>
                            <select class="form-control form-select" name="difficulty_level" id="difficulty">
                                <option value="%">All</option>
                                <option value="simple">Easy</option>
                                <option value="moderate">Medium</option>
                                <option value="difficult">Difficult</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-3 col-md-12 col-lg-3 col-xl-3">
                        <div class="form-group">
                            <label for="topic">Topic:</label>
                            <select class="form-control form-select" name="topic_id" id="topic">
                                <option value="%">All</option>
                                @foreach($topics as $topic)
                                    <option value="{{$topic->id}}">{{$topic->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-3 col-md-12 col-lg-3 col-xl-3">
                        <div class="form-group">
                            <label for="author">Author:</label>
                            <select class="form-control form-select" name="author" id="author">
                                <option value="%">All</option>
                                <option value="me">Me</option>
                                <option value="others">Others</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-3 col-md-12 col-lg-3 col-xl-3">
                        <div class="form-group">
                            <label for="phrase">Questions Containing:</label>
                            <input class="form-control" type="text" name="phrase" id="phrase"
                                   placeholder="Search phrase">
                        </div>
                    </div>
                </div>
                <div class="p-2" style="width:100%;display: flex;justify-content: end;align-items: center">
                    <input class="btn btn-info text-light" type="submit" value="Load Questions">
                </div>
            </form>
        </div>
    </div>
    <div id="questions-div"></div>
@endsection

@section('script')
    <script>
        $(function () {
            $('#load-form').on('submit', function (e) {
                e.preventDefault()
                $.post('{{route('admin.test.config.compose.questions.load')}}', $(this).serialize(), function (response) {
                    console.log(response)
                    $('#questions-div').html(response)
                })
            })

            $(document).on('click', '#select-all', function () {
                $('.selection').prop('checked', $(this).is(':checked'));
            })

            $(document).on('click', '.selection', function () {

            })
        })
    </script>
@endsection
