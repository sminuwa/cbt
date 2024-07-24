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
                <input type="hidden" name="test_section_id" value="{{$testSection->id}}">
                <input type="hidden" name="test_subject_id" value="{{$testSection->test_subject_id}}">
                <input type="hidden" id="page" name="page" value="1">
                <div class="row">
                    <div class="col-3 col-md-12 col-lg-3 col-xl-3">
                        <div class="form-group">
                            <label for="difficulty">Difficulty Level:</label>
                            <select class="form-control form-select" name="difficulty_level" id="difficulty">
                                <option value="%">All</option>
                                <option value="simple">Simple</option>
                                <option value="moderate">Moderate</option>
                                <option value="difficult">Difficult</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-3 col-md-12 col-lg-3 col-xl-3">
                        <div class="form-group">
                            <label for="topic">Subject:</label>
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
            let page = $('#page')
            let form = $('#load-form')
            let q_form

            function loadQuestions() {
                $.get('{{route('admin.test.config.compose.questions.load')}}', form.serialize(), function (response) {
                    console.log(response)
                    $('#questions-div').html(response)
                    $(document).find('#section_id').val({{$testSection->id}})
                    q_form = $(document).find('#questions-form')
                })
            }

            function store() {
                $.post('{{route('admin.test.config.compose.questions.store')}}', q_form.serialize(), function (data) {
                }).done(function (data) {
                    console.log(data)
                })
            }

            form.on('submit', function (e) {
                e.preventDefault()
                loadQuestions()
            })

            $(document).on('click', '#select-all', function () {
                let checked = $(this).is(':checked')
                $('.selection').prop('checked', checked);

                if (checked)
                    store()
                else {

                }
            })

            $(document).on('click', '.selection', function () {
                let checked = $(this).is(':checked')
                if (checked)
                    store()
                else {
                    $.get('{{route('admin.test.config.compose.questions.remove',[$testSection->id,':id'])}}'.replace(':id', $(this).val()), function () {
                    })
                }
            })

            $(document).on('click', '.full-question', function () {
                let options = $(document).find('#options-' + $(this).data('id'))
                if (options.is(':visible'))
                    options.hide()
                else
                    options.show()
            })

            $(document).on('click', '#previous', function () {
                let index = parseInt(page.val()) - 1
                page.val(index)
                loadQuestions()
            })

            $(document).on('click', '#next', function () {
                let index = parseInt(page.val()) + 1
                page.val(index)
                loadQuestions()
            })
        })
    </script>
@endsection
