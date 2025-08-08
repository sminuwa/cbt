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
                            <span>Manage Test Types</span>
                        </h4>
                    </div>
                </div>
            </div>
            <div class="card-body pt-4">
                <a style="width: 18%" class="btn btn-outline-info btn-sm" data-bs-toggle="modal"
                   href="#add_new_test_type">
                    <i class="fa fa-plus"></i> New Test Type</a>
            </div>

            <table id="table" class="table table-bordered center">
                <thead>
                <tr>
                    <th style="width: 5%">#</th>
                    <th>Test Type Name</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($testTypes as $index => $testType)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $testType->name }}</td>
                        <td>
                            <a class="btn btn-sm btn-warning edit text-white"
                               data-bs-toggle="modal"
                               href="#add_new_test_type"
                               data-id="{{$testType->id}}"
                               data-name="{{$testType->name}}">Modify </a>
                            <a class="btn btn-sm btn-danger delete" data-bs-toggle="modal"
                               href="#delete_test_type" data-id="{{$testType->id}}">
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

    <div class="modal fade custom-modal" id="add_new_test_type">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add/Edit Test Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form action="{{route('admin.toolbox.test-types.store')}}" method="post">
                    @csrf
                    <input type="hidden" id="test_type_id" name="id"/>
                    <div class="modal-body">
                        <div class="hours-info">
                            <div class="row hours-cont">
                                <div class="col-12 col-md-12">
                                    <div class="row">
                                        <div class="col-12 col-md-12">
                                            <div class="mb-3">
                                                <label for="tname" class="mb-2">Test Type Name</label>
                                                <input type="text" id="tname" name="name" class="form-control" 
                                                       placeholder="e.g., Written, Practical, Oral" required>
                                                <small class="form-text text-muted">Enter the test type name (e.g., Written, Practical, Oral)</small>
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

    <div class="modal fade custom-modal" id="delete_test_type">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Test Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to <strong>Delete</strong> this test type?</p>
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
                $('#test_type_id').val(_id)
                $('#tname').val($(this).data('name'))
            })

            $(document).on('click', '.delete', function () {
                $(".modal-body #id").val($(this).data('id'));
            })

            $('#btnDelete').on('click', function () {
                let id = $(".modal-body #id").val()
                $.get('{{route('admin.toolbox.test-types.delete',['testType' => ':id'])}}'.replace(':id', id),
                    function (response) {
                        $('#delete_test_type').modal('hide')
                        location.reload()
                    }
                ).fail(function(xhr) {
                    alert('Error: ' + xhr.responseText)
                })
            })
        });
    </script>
@endsection

