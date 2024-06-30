@php use App\Models\Subject; @endphp
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
                <h4 class="mb-5 mt-5">Modify Existing Questions</h4>
                <form id="preview-form" method="post">
                    @csrf
                    <div class="row pb-3 pt-2">
                        <div class="col-12 col-md-6 col-lg-3 col-xl-3">
                            <div class="form-group">
                                <label for="subject_id">Subject:</label>
                                <select class="form-control form-select" name="subject_id"
                                        id="subject_id" required>
                                    <option value="">Select Subject</option>
                                    @foreach(Subject::all() as $subject)
                                        <option value="{{$subject->id}}">{{ $subject->name }}</option>
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
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3 col-xl-3">
                            <div class="form-group">
                                <label for="difficulty_level">Topic:</label>
                                <select class="form-control form-select" name="difficulty_level" id="difficulty_level"
                                        required>
                                    <option value="">Select Difficulty Level</option>
                                    <option value="%">All Difficulty Levels</option>
                                    <option value="simple">Simple</option>
                                    <option value="moderate">Moderate</option>
                                    <option value="difficult">Difficult</option>
                                    <option value="moredifficult">More Difficult</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3 col-xl-3">
                            <input type="submit" class="btn btn-info text-light mt-4" value="Load Questions"/>
                        </div>
                    </div>
                </form>
                <div id="questions-div"></div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(function () {
            $('#subject_id').on('change', function () {
                let id = $(this).val();
                $.get('{{ route('admin.questions.authoring.topics',[':id']) }}'.replace(':id', id), function (data) {
                    $('#topic_id').html(data)
                })
            })

            $('#preview-form').on('submit', function (e) {
                e.preventDefault()
                $.post('{{ route('admin.questions.authoring.load.preview') }}', $(this).serialize(), function (response) {
                    $('#questions-div').html(response)
                })
            })
        })
    </script>
@endsection
