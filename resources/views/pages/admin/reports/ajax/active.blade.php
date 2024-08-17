@if(count($actives)==0)
    <h4 style="text-align: center">No active candidate taking this test</h4>
@else
    {{--    <div class="card border-info">--}}
    {{--        <div class="card-body" style="padding: 1px !important;">--}}
    {{--            <table class="table table-bordered">--}}
    {{--                <tbody>--}}
    {{--                <tr>--}}
    {{--                    <th>#</th>--}}
    {{--                    <th>Indexing</th>--}}
    {{--                    <th>Candidate</th>--}}
    {{--                    <th>IP Address</th>--}}
    {{--                    <th>Action</th>--}}
    {{--                </tr>--}}
    {{--                </tbody>--}}
    {{--                <tbody>--}}
    {{--                --}}
    {{--                    <tr>--}}
    {{--                        <td>{{$loop->iteration}}</td>--}}
    {{--                        <td>{{$active->indexing}}</td>--}}
    {{--                        <td>{{$active->name}}</td>--}}
    {{--                        <td>{{$active->address}}</td>--}}
    {{--                        <td></td>--}}
    {{--                    </tr>--}}
    {{--                @endforeach--}}
    {{--                </tbody>--}}
    {{--            </table>--}}
    {{--        </div>--}}
    {{--    </div>--}}

    <div class="card card-table">
        <div class="card-body">
        <div class="table-responsive">
            <table class="datatable table table-hover table-center mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th></th>
                        <th>Indexing</th>
                        <th>Full name</th>
                        <th>IP Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($actives as $active)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>
                                <a href="patient-profile.html" class="avatar avatar-sm me-2">
                                    <img class="avatar-img rounded-circle" src="{{asset('assets/img/patients/patient2.jpg')}}" alt="{{$active->indexing}} - {{$active->name}}">
                                </a>
                            </td>
                            <td>{{$active->indexing}}</td>
                            <td>{{$active->name}}</td>
                            <td>{{$active->address}}</td>
                            <td>
                                <a class="btn btn-sm btn-outline-danger"
                                   data-bs-toggle="modal"
                                   href="#end_candidate_exams"
                                   data-id="{{$active->eid}}"
                                >End Exam</a>
                                <a class="btn btn-sm btn-outline-info"
                                   data-bs-toggle="modal"
                                   href="#restore_candidate"
                                   data-id="{{$active->eid}}"
                                >Restore</a>
                                <a class="btn btn-sm btn-outline-primary"
                                   data-bs-toggle="modal"
                                   href="#adjust_candidate_time"
                                   data-id="{{$active->eid}}"
                                >Adjust Time</a>
                            </td>
                    </tr>
                 @endforeach
                </tbody>
            </table>
        </div>
        {{-- @foreach($actives as $active)
            <div class="col-md-6 col-lg-4 col-xl-4">
                <div class="card border-info widget-profile pat-widget-profile">
                    <div class="card-body">
                        <div class="pro-widget-content">
                            <div class="profile-info-widget">
                                <a href="#" class="booking-doc-img">
                                    <img src="{{asset('assets/img/patients/patient2.jpg')}}" alt="User Image">
                                </a>
                                <div class="profile-det-info">
                                    <h4>{{$active->name}}</h4>
                                    <div class="patient-details">
                                        <h5><b>{{$active->indexing}}</b></h5>
                                        <h5 class="mb-0"><i class="fas fa-map-pin"></i>{{$active->address}}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach --}}
    </div>
    </div>
@endif
@section('script')
{{--    Restore Candidates Modal--}}
    <div class="modal fade custom-modal" id="restore_candidate">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Restore Candidate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to <strong>Restore</strong> this Candidate ({{$active->indexing}})?</p>
                    <input type="hidden" name="id" id="id">
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnRestore" class="btn btn-sm btn-danger submit-btn text-light"><i class="fa fa-trash-o"></i>
                        Restore
                    </button>
                </div>

            </div>
        </div>
    </div>

{{--    End Candidate Exams Modal--}}
    <div class="modal fade custom-modal" id="end_candidate_exams">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">End Candidate Exams</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to <strong>End</strong> this Candidate Exam ({{$active->indexing}})?</p>
                    <input type="hidden" name="id" id="id">
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnRestore" class="btn btn-sm btn-danger submit-btn text-light"><i class="fa fa-trash-o"></i>
                        End
                    </button>
                </div>

            </div>
        </div>
    </div>
{{--Adjust Candidate Time Modal--}}
    <div class="modal fade custom-modal" id="adjust_candidate_time">
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

<script>
    $(document).ready(function () {
        $('#delete').modal('hide');


        $(document).on('click', '.delete', function () {
            $(".modal-body #id").val($(this).data('id'));
        })

        $('#btnRestore').on('click', function () {
            let id = $(".modal-body #id").val()
            console.log(id)
            $.get('{{route('candidate.restore',[':id'])}}'.replace(':id', id),
                function (response) {
                    console.log(response)
                    $('#restore').modal('hide')
                    location.reload()
                }
            )
        })
        $('#btnEndExam').on('click', function () {
            let id = $(".modal-body #id").val()
            console.log(id)
            $.get('{{route('candidate.endexam',[':id'])}}'.replace(':id', id),
                function (response) {
                    console.log(response)
                    $('#endexam').modal('hide')
                    location.reload()
                }
            )
        })
        $('#btnAdjustTime').on('click', function () {
            let id = $(".modal-body #id").val()
            console.log(id)
            $.get('{{route('candidate.adjusttime',[':id'])}}'.replace(':id', id),
                function (response) {
                    console.log(response)
                    $('#adjust_time').modal('hide')
                    location.reload()
                }
            )
        })
    });
</script>
@endsection
