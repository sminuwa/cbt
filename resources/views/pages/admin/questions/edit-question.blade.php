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
                <h4 class="mb-5 mt-5">Edit Question</h4>
                <form id="preview-form" method="post" action="{{ route('admin.questions.authoring.store.question') }}">
                    <input type="hidden" name="question_id" value="{{ $question->id }}">
                    @csrf
                    <div class="row pt-2">
                        <div class="col-12 col-md-6 col-lg-3 col-xl-3">
                            <div class="form-group">
                                <label for="subject_id">Subject:</label>
                                <select class="form-control form-select" name="subject_id"
                                        id="subject_id" required>
                                    <option value="">Select Subject</option>
                                    @foreach(\App\Models\Subject::all() as $subject)
                                        <option
                                            value="{{$subject->id}}" {{ $question->subject_id==$subject->id?'selected':'' }}>{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3 col-xl-3">
                            <div class="form-group">
                                <label for="topic_id">Topic:</label>
                                <select class="form-control form-select" name="topic_id" id="topic_id"
                                        required>
                                    <option value="">Select Topic</option>
                                    @foreach(\App\Models\Topic::all() as $topic)
                                        <option
                                            value="{{ $topic->id }}" {{ $topic->id==$question->topic_id?'selected':'' }}>{{ $topic->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3 col-xl-3">
                            <div class="form-group">
                                <label for="difficulty_level">Difficulty Level:</label>
                                <select class="form-control form-select" name="difficulty_level"
                                        id="difficulty_level" required>
                                    <option value="">Select Difficulty</option>
                                    <option value="simple"
                                        {{ $question->difficulty_level=='simple'?'selected':'' }}>Simple
                                    </option>
                                    <option value="difficult"
                                        {{ $question->difficulty_level=='difficult'?'selected':'' }}>Difficult
                                    </option>
                                    <option value="moredifficult"
                                        {{ $question->difficulty_level=='moredifficult'?'selected':'' }}>Mode
                                        Difficult
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3 col-xl-3">
                            <div class="form-group">
                                <label for="active">Status:</label>
                                <select class="form-control form-select" name="active" id="active" required>
                                    <option value="">Select Status</option>
                                    <option value="true"{{ $question->active=='true'?'selected':'' }}>Active
                                    </option>
                                    <option value="false"{{ $question->active=='false'?'selected':'' }}>Inactive
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-2">
                        <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                            <div class="form-group">
                                <label for="title">Question:</label>
                                <textarea class="form-control editor" name="title" id="title" placeholder="Question"
                                          required>
                                    {{ $question->title }}
                                </textarea>
                            </div>
                        </div>
                    </div>
                    {{--                        <div class="row">--}}
                    @foreach($question->answer_options as $option)
                        <div class="row mb-4">
                            <label
                                class="col-form-label col-lg-1">Opt-{{ \App\Helper::indexToChar($loop->index) }}</label>
                            <div class="col-lg-11">
                                <div class="input-group">
                                        <span class="input-group-text">
                                            <input type="radio" name="correctness"
                                                   {{ $option->correctness==1?'checked':'' }} value="{{ $option->id }}">
                                        </span>
                                    <textarea class="form-control editor" name="question_option[]" id="" cols="30" rows="10">
                                        {{ $option->question_option }}
                                    </textarea>
                                </div>
                            </div>
                        </div>

                        {{--                                <input type="hidden" value="" name="answer-id[]">--}}
                    @endforeach
                    {{--                        </div>--}}
                    <input type="submit" class="btn btn-info text-light mt-4" value="Save Changes"/>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            height: 250,
            license_key: 'gpl',
            selector: 'textarea.editor', // Replace this CSS selector to match the placeholder element for TinyMCE
            plugins: 'code table lists',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
        });
    </script>
    <script>
        $(function () {
            $('#subject_id').on('change', function () {
                let id = $(this).val();
                $.get('{{ route('admin.questions.authoring.topics',[':id']) }}'.replace(':id', id), function (data) {
                    $('#topic_id').html(data)
                })
            })

            {{--$('#preview-form').on('submit', function (e) {--}}
            {{--    e.preventDefault()--}}
            {{--    $.post('{{ route('questions.authoring.load.preview') }}', $(this).serialize(), function (response) {--}}
            {{--        $('#questions-div').html(response)--}}
            {{--    })--}}
            {{--})--}}
        })
    </script>
@endsection
