@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="card border-info">
            <div class="card-header border-info">
                <div class="row">
                    <div>
                        <h4 class="card-title d-flex justify-content-between">
                            <span>Manage Topics</span>
                        </h4>
                    </div>
                </div>
            </div>
            <div class="card-body pt-4">
                <a style="width: 18%" class="btn btn-outline-info btn-sm" data-bs-toggle="modal"
                   href="#add_new_topic">
                    <i class="fa fa-plus"></i> New Topic</a>
            </div>

            <table id="table" class="table table-bordered center">
                <thead>
                <tr>
                    <th style="width: 5%">#</th>
                    <th>Subject</th>
                    <th>Topic Name</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($topics as $index => $topic)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $topic->subject->name ?? 'N/A' }}</td>
                        <td>{{ $topic->name }}</td>
                        <td>
                            <a class="btn btn-sm btn-warning edit text-white"
                               data-bs-toggle="modal"
                               href="#add_new_topic"
                               data-id="{{$topic->id}}"
                               data-name="{{$topic->name}}"
                               data-subject_id="{{$topic->subject_id}}">Modify </a>
                            <a class="btn btn-sm btn-danger delete" data-bs-toggle="modal"
                               href="#delete_topic" data-id="{{$topic->id}}">
                                <i class="fa fa-trash"></i> Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <br>

@endsection

@section('script')

    <div class="modal fade custom-modal" id="add_new_topic">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add/Edit Topic</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form action="{{route('admin.toolbox.topics.store')}}" method="post">
                    @csrf
                    <input type="hidden" id="topic_id" name="id"/>
                    <div class="modal-body">
                        <div class="hours-info">
                            <div class="row hours-cont">
                                <div class="col-12 col-md-12">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="mb-3">
                                                <label for="subject_id" class="mb-2">Subject</label>
                                                <select name="subject_id" id="subject_id" class="form-control" required>
                                                    <option value="">--Select Subject--</option>
                                                    @foreach($subjects as $subject)
                                                        <option value="{{$subject->id}}">{{$subject->name}} ({{$subject->subject_code}})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="mb-3">
                                                <label for="tname" class="mb-2">Topic Name</label>
                                                <input type="text" id="tname" name="name" class="form-control" 
                                                       placeholder="Enter topic name" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer submit-section text-end">
                        <button type="submit" class="btn btn-sm btn-primary submit-btn text-light">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade custom-modal" id="delete_topic">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Topic</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to <strong>Delete</strong> this topic?</p>
                    <input type="hidden" name="id" id="id">
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnDelete" class="btn btn-sm btn-danger submit-btn text-light">
                        <i class="fa fa-trash-o"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $(document).on('click', '.edit', function () {
                let _id = $(this).data('id')
                $('#topic_id').val(_id)
                $('#tname').val($(this).data('name'))
                $('#subject_id').val($(this).data('subject_id'))
            })

            $(document).on('click', '.delete', function () {
                $(".modal-body #id").val($(this).data('id'));
            })

            $('#btnDelete').on('click', function () {
                let id = $(".modal-body #id").val()
                $.get('{{route('admin.toolbox.topics.delete',['topic' => ':id'])}}'.replace(':id', id),
                    function (response) {
                        $('#delete_topic').modal('hide')
                        location.reload()
                    }
                ).fail(function(xhr) {
                    alert('Error: ' + xhr.responseText)
                })
            })
        });
    </script>
@endsection

