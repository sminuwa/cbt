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

    <div class="row">
        <x-head.tinymce-config/>
        <div class="row patient-graph-col">
            <div class="col-12">
                <h4 class="mb-5 mt-5">Review Question(s)</h4>
                <form method="post" action="{{ route('admin.questions.authoring.store') }}">
                    <input type="hidden" name="subject_id" value="{{$subjectId}}">
                    <input type="hidden" name="topic_id" value="{{$topicId}}">
                    @csrf
                    @foreach($questions as $question)
                        <div class="card border-info">
                            <div class="card-header">
                                <h4 class="card-title">({{$loop->iteration}}) {{ $question->title }}</h4>
                            </div>
                            <div class="card-body pt-2 pb-2  mt-1 mb-1">
                                <div class="row">
                                    <div class="row pb-3 pt-2">
                                        <ol class="list-group list-group-flush ordered-list">
                                            @foreach($question->options as $option)
                                                <li class="list-group-item {{$option->correctness=='1'?'list-group-item-success':''}}">{{ $option->question_option }}</li>
                                            @endforeach
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <input class="btn btn-sm btn-info mt-3 text-light" type="submit" value="Submit">
                </form>
            </div>
        </div>
    </div>

@endsection
