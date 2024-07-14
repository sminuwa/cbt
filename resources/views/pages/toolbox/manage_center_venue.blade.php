@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if(Session::has('app_message'))
                <div class="alert alert-success">
                    {{ Session::get('app_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if(Session::has('app_error'))
                <div class="alert alert-danger">
                    {{ Session::get('app_error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-10">
                <h4></h4>
        </div>
        <div class="col-md-2 text-right" >
            <button class="btn btn-sm btn-success ml-md-auto add" data-bs-toggle="modal" href="#add_new_center"><i
                    class="fa fa-plus"></i> New Center
            </button>
            <div class="mr-4">
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <table id="table" class="table table-bordered table-striped center">
                <thead>
                <tr>
                    <th style="width: 5%">#</th>
                    <th>Centre Name</th>
                    <th>Venue Name</th>
                    <th>Location</th>
                    <th>Capacity</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @php $index=1 @endphp
                @foreach($venues as $index => $venue)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $venue->centre->name }}</td>
                        <td>{{ $venue->name }}</td>
                        <td>{{ $venue->location }}</td>
                        <td>{{ $venue->capacity }}</td>
                        <td>
                            <a class="btn btn-sm btn-primary edit"
                               data-bs-toggle="modal"
                               href="#add_new_center"
                               data-id="{{$venue->id}}"
                               data-name="{{$venue->name}}"
                               data-centre_id="{{$venue->centre_id}}"
                               data-location="{{$venue->location}}"
                               data-capacity="{{$venue->capacity}}">
                                <i class="fa fa-edit"> Edit</i>
                            </a>
                            <a  class="btn btn-sm btn-danger delete" data-bs-toggle="modal"
                               href="#delete_center" data-id="{{$venue->id}}"><i class="fa fa-trash"></i>
                                Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div><!-- End row -->

@endsection

    @section('script')
        <div class="modal fade custom-modal" id="add_new_center">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Center</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <form action="{{ route('toolbox.center_venue.center.store') }}" method="post">
                        @csrf
                        <input type="hidden" id="type_id" value="0" name="type_id"/>
                        <div class="modal-body">
                            <div class="hours-info">
                                <div class="row hours-cont">
                                    <div class="col-12 col-md-12">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="mb-6">
                                                    <label for="name" class="mb-6">Name</label>
                                                    <input type="text" id="name" name="name" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="mb-6">
                                                    <label for="centreLocation" class="mb-6">Center Location</label>
                                                    <input type="text" id="centreLocation" name="centreLocation" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer submit-section text-end">
                            <button type="submit" class="btn btn-sm btn-primary submit-btn text-light">Create Center</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade custom-modal" id="delete_center">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Center</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p style="color: #0a0a0a">Are you sure you want to <strong>Delete</strong> this record?</p>
                        <input type="hidden" name="id" id="id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" id="btnDelete" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i>
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
                $('#center_name').val('')
                $('#form').attr('action', '{{route('toolbox.center_venue.center.store')}}')
            })

            $(document).on('click', '.edit', function () {
                let _id = $(this).data('id')

                $('#id').val(_id)
                $('#center_name').val($(this).data('center_name'))
                $('#form').attr('action', '/toolbox/center_venue/center/edit/' + _id)
            })

            $(document).on('click', '.delete', function () {
                $(".modal-body #id").val($(this).data('id'));
            })

            $('#btnDelete').on('click', function () {
                let id = $(".modal-body #id").val()
                $.ajax({
                    type: 'GET',
                    url: '/toolbox/center_venue/center/delete/' + id,
                    success: function (data) {
                        $('#delete').modal('hide');
                        location.reload();
                    }
                });
            })
        });
    </script>
@endsection
