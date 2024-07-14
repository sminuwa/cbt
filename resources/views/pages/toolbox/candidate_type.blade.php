@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if(Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            @endif
            @if(Session::has('error'))
                <div class="alert alert-danger">
                    {{ Session::get('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                            <span>Manage Exam Type</span>
                        </h4>
                    </div>
                </div>
            </div>
            <div class="card-body pt-4">
                <a style="width: 18%" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" href="#add_new_examtype"><i
                        class="fa fa-plus"></i> New Exam Type</a>
            </div>

            <table id="table" class="table table-bordered table-striped center">
                <thead>
                <tr>
                    <th style="width: 5%">#</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @php $index=1 @endphp
                @foreach($candidateTypes as $index => $candidateType)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $candidateType->name }}</td>
                        <td>
                            <a class="btn btn-sm btn-primary edit"
                               data-bs-toggle="modal"
                               href="#add_new_examtype"
                               data-id="{{$candidateType->id}}"
                               data-name="{{$candidateType->name}}">
                                <i class="fa fa-edit"> Edit</i>
                            </a>
                            <a class="btn btn-sm btn-danger delete" data-bs-toggle="modal"
                               href="#delete_etype" data-id="{{$candidateType->id}}"><i class="fa fa-trash"></i>
                                Delete</a>
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

    <div class="modal fade custom-modal" id="add_new_examtype">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add/Edit Exam Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form action="{{route('toolbox.candidate-types.store')}}" method="post">
                    @csrf
                    <input type="hidden" id="etype_id" name="id"/>
                    <div class="modal-body">
                        <div class="hours-info">
                            <div class="row hours-cont">
                                <div class="col-12 col-md-12">
                                    <div class="row">

                                        <div class="col-12 col-md-6">
                                            <div class="mb-6">
                                                <label for="etype" class="mb-6">Exam Type</label>
                                                <input type="text" id="etype" name="etype" class="form-control">
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

    <div class="modal fade custom-modal" id="delete_etype">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Exam Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to <strong>Delete</strong> this record?</p>
                    <input type="hidden" name="id" id="id">
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnDelete" class="btn btn-sm btn-danger submit-btn text-light"><i class="fa fa-trash-o"></i>
                        Delete
                    </button>
                </div>

            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#delete').modal('hide');
            $('#addEdit').modal('hide');

            $(document).on('click', '.add', function () {
                $('#etype').val($(this).data('name'))
                $('#form').attr('method', 'post')
                $('#form').attr('action', '{{route('toolbox.candidate-types.store')}}')
            })
            $(document).on('click', '.edit', function () {
                let _id = $(this).data('id')

                $('#etype_id').val(_id)
                $('#etype').val($(this).data('name'))
                $('#scode').val($(this).data('subject_code'))
            })

            $(document).on('click', '.delete', function () {
                $(".modal-body #id").val($(this).data('id'));
            })

            $('#btnDelete').on('click', function () {
                let id = $(".modal-body #id").val()
                console.log(id)
                $.get('{{route('toolbox.candidate-types.delete',[':id'])}}'.replace(':id', id),
                    function (response) {
                        console.log(response)
                        $('#delete').modal('hide')
                        location.reload()
                    }
                )
            })
        });
    </script>
@endsection
