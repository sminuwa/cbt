@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if(Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if(Session::has('error'))
                <div class="alert alert-danger">
                    {{ Session::get('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
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
                            <span>Manage Centers/Venues</span>
                        </h4>
                    </div>
                </div>
            </div>
            <div class="card-body pt-4">
                <a style="width: 18%" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" href="#add_new_center"><i
                        class="fa fa-plus"></i> New Center</a>
                <a style="width: 18%" class="btn btn-outline-info btn-sm" data-bs-toggle="modal"
                   href="#add_new_venue"><i
                        class="fa fa-plus"></i> New Venue</a>
            </div>

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
                               href="#add_new_venue"
                               data-id="{{$venue->id}}"
                               data-name="{{$venue->name}}"
                               data-centre_id="{{$venue->centre_id}}"
                               data-location="{{$venue->location}}"
                               data-capacity="{{$venue->capacity}}">
                                <i class="fa fa-edit"> Edit</i>
                            </a>
                            <a class="btn btn-sm btn-danger delete" data-bs-toggle="modal"
                               href="#delete_center" data-id="{{$venue->id}}"><i class="fa fa-trash"></i>
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
                                                <input type="text" id="centername" name="name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="mb-6">
                                                <label for="centreLocation" class="mb-6">Center Location</label>
                                                <input type="text" id="centreLocation" name="centreLocation"
                                                       class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer submit-section text-end">
                        <button type="submit" class="btn btn-sm btn-primary submit-btn text-light">Create Center
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade custom-modal" id="add_new_venue">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add/Edit Venue</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form action="{{route('toolbox.center_venue.venue.store')}}" method="post">
                    @csrf
                    <input type="hidden" id="venue_id" value="0" name="id"/>
                    <div class="modal-body">
                        <div class="hours-info">
                            <div class="row hours-cont">
                                <div class="col-12 col-md-12">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="mb-6">
                                                <label for="center" class="mb-6">center</label>
                                                <select name="center" id="center" class="form-control">
                                                    <option value="">--Select Center--</option>
                                                    @foreach($centres as $center)
                                                        <option value="{{$center->id}}">{{$center->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="mb-6">
                                                <label for="name" class="mb-6">Venue</label>
                                                <input type="text" id="name" name="name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="mb-6">
                                                <label for="venueLocation" class="mb-6">Venue Location</label>
                                                <input type="text" id="venueLocation" name="venueLocation"
                                                       class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="mb-6">
                                                <label for="capacity" class="mb-6">Venue Capacity</label>
                                                <input type="text" id="capacity" name="capacity" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer submit-section text-end">
                        <button type="submit" class="btn btn-sm btn-primary submit-btn text-light">Save Venue</button>
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
                    <p>Are you sure you want to <strong>Delete</strong> this record?</p>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function () {
            $('#delete').modal('hide');
            $('#addEdit').modal('hide');

            $(document).on('click', '.add', function () {
                $('#center').val('')
                $('#name').val('')
                $('#venueLocation').val('')
                $('#capacity').val('')
                $('#form').attr('method', 'post')
                $('#form').attr('action', '{{route('toolbox.center_venue.center.store')}}')
            })

            $(document).on('click', '.edit', function () {
                let _id = $(this).data('id')
                let name = $(this).data('name')

                $('#venue_id').val(_id)
                $('#center').val($(this).data('centre_id'))
                $('#name').val($(this).data('name'))
                $('#venueLocation').val($(this).data('location'))
                $('#capacity').val($(this).data('capacity'))
            })

            $(document).on('click', '.delete', function () {
                $(".modal-body #id").val($(this).data('id'));
            })

            $('#btnDelete').on('click', function () {
                let id = $(".modal-body #id").val()
                console.log(id)
                $.get('{{route('toolbox.center_venue.venue.delete',[':id'])}}'.replace(':id', id),
                    function (response) {
                        console.log(response)
                        $('#delete').modal('hide')
                        location.reload()
                    }
                )
                // $.ajax({
                //     type: 'GET',
                //     url: '/toolbox/center_venue/center/delete/' + id,
                //     success: function (data) {
                //         $('#delete').modal('hide');
                //         location.reload();
                //     }
                // });
            })
        });
    </script>
@endsection
