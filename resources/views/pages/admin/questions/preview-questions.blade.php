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
                <h4 class="mb-5 mt-5">Question(s) Preview</h4>
                <form id="preview-form" method="post">
                    @csrf
                    <input type="hidden" name="preview" value="true">
                    <div class="row pb-3 pt-2">
                        <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="subject_id">Paper:</label>
                                <select class="form-control form-select" name="subject_id" id="subject_id" required>
                                    <option value="">Select Paper</option>
                                    @foreach(Subject::all() as $subject)
                                        <option value="{{$subject->id}}">{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="topic_id">Subject:</label>
                                <select class="form-control form-select" name="topic_id" id="topic_id" required>
                                    <option value="">Select Subject</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="difficulty_level">Difficulty:</label>
                                <select class="form-control form-select" name="difficulty_level" id="difficulty_level"
                                        required>
                                    <option value="">Select Difficulty Level</option>
                                    <option value="%">All Difficulty Levels</option>
                                    <option value="simple">Simple</option>
                                    <option value="moderate">Moderate</option>
                                    <option value="difficult">Difficult</option>
                                    {{--                                    <option value="moredifficult">More Difficult</option>--}}
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="date_from">Date From:</label>
                                <input class="form-control" type="date" name="date_from" id="date_from">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="date_to">Date To:</label>
                                <input class="form-control" type="date" name="date_to" id="date_to">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                            <input type="submit" class="btn btn-info text-light mt-4" value="Load Preview"/>
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

            $(document).on('click', '#check-all', function () {
                let checked = $(this).is(':checked')
                $('.selection').prop('checked', checked)
            })
        })
    </script>
@endsection
