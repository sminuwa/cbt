@php use App\Models\Subject; @endphp
@extends('layouts.app')

@section('content')

    <div class="row">
        <x-head.tinymce-config/>

        <div class="col-md-12 col-lg-12 col-xl-12">

            <div class="row patient-graph-col">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Question Authoring</h4>
                        </div>
                        <div class="card-body pt-2 pb-2 mt-1 mb-1">
                            <div class="row">
                                <form id="authoringForm" method="post" action="">
                                    @csrf
                                    <div class="row pb-3 pt-2">
                                        <div class="col-12 col-md-6 col-lg-3 col-xl-3">
                                            <div class="form-group">
                                                <label for="subject_id">Paper:</label>
                                                <select class="form-control form-select" name="subject_id"
                                                        id="subject_id" required>
                                                    <option value="">Select Paper</option>
                                                    @foreach(Subject::all() as $subject)
                                                        <option value="{{$subject->id}}">{{ $subject->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-2 col-xl-2">
                                            <div class="form-group">
                                                <label></label><br>
                                                <a class="btn btn-sm btn-outline-info mt-2" style="width: 100%"
                                                   data-bs-toggle="modal" id="add" href="#add_new_subject">
                                                    <i class="fa fa-plus"></i> Add Subject</a>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-3 col-xl-3">
                                            <div class="form-group">
                                                <label for="topic_id">Subject:</label>
                                                <select class="form-control form-select" name="topic_id" id="topic_id"
                                                        required>
                                                    <option value="">Select Subject</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <textarea id="question-editor" name="content"></textarea>
                                    <input class="btn btn-sm btn-info mt-3 text-light" type="submit" value="Submit">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

    <div class="modal fade custom-modal" id="add_new_subject">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Subject</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form id="add-subject" action="" method="post">
                    @csrf
                    <input type="hidden" id="subject" name="subject_id"/>
                    <div class="modal-body">
                        <div class="hours-info">
                            <div class="row hours-cont">
                                <div class="col-12 col-md-12">
                                    <div class="row">
                                        <div class="col-12 col-md-12">
                                            <div class="mb-6">
                                                <label for="topic" class="mb-6">Subject</label>
                                                <input type="text" id="topic" name="name" class="form-control"
                                                       placeholder="Subject" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer submit-section text-end">
                        <button type="submit" class="btn btn-sm btn-info text-light">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(function () {
            function fetchSubjects(id) {
                $.get('{{ route('admin.questions.authoring.topics',[':id']) }}'.replace(':id', id), function (data) {
                    $('#topic_id').html(data)
                })
            }

            $('#subject_id').on('change', function () {
                let id = $(this).val();
                fetchSubjects(id)
            })

            $('#add').on('click', function () {
                const subject = $('#subject_id').val()
                if (subject === '') {
                    alert('Select paper to add the subject first')
                } else {
                    $('#topic').val('')
                    $('#subject').val(subject)
                }
            })

            $('#add-subject').on('submit', function (e) {
                e.preventDefault()
                $.post('{{route('admin.questions.authoring.topics.add')}}', $(this).serialize(), function (response) {
                    console.log(response)
                    if (!response.success) alert(response.message)
                })
            })

            $('#authoringForm').on('submit', function (e) {
                e.preventDefault()
                $.post('{{ route('admin.questions.authoring.post') }}', $(this).serialize(), function (response) {
                    window.open(response.url, '_blank')
                })
            })
        })
    </script>
@endsection
