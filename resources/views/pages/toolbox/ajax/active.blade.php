<link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/vendors/range-slider.css') }}">
@if (!isset($candidates) || count($candidates) == 0)
    <h4 style="text-align: center">No active candidate taking this test</h4>
@else
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="display" id="export-button-sample">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Indexing</th>
                            <th>Action</th>
                            <th>Status</th>
                            <th>Full name</th>
                            <th>Papers</th>
                            <th>IP Address</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($candidates as $candidate)
                            <tr>
                                <td><img class="img-fluid table-avtar" src="{{ $candidate->passport() }}" alt="">
                                </td>
                                <td class="text-end">
                                    <div class="btn-group dropend" role="group">
                                        <button class="btn btn-primary dropdown-toggle" id="btnGroupVerticalDrop3"
                                            type="button" data-popper-placement="right-start" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">Action</button>
                                        <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop3">
                                            @if($candidate->time_control_id)
                                            <button class="dropdown-item end-test"
                                            data-bs-toggle="modal"
                                            href="#end_candidate_exams"
                                            data-id="{{$candidate->time_control_id}}"
                                            data-indexing="{{  $candidate->indexing }}"
                                            data-toggle="tooltip"
                                            data-bs-placement="top"
                                            data-bs-title="End Exam"
                                            ><i class="las la-times"></i> End Exam</button>
                                            <button class="dropdown-item restore"
                                                type="button" 
                                                data-id="{{$candidate->time_control_id}}"
                                                data-indexing="{{  $candidate->indexing }}"
                                                data-toggle="tooltip"
                                                data-bs-placement="top"
                                                data-bs-title="Restore"
                                            ><i class="las la-undo-alt"></i> Restore</button>
                                                @if ($candidate->completed == 0)
                                                <button class="dropdown-item adjust-time"
                                                data-id="{{ $candidate->time_control_id }}"
                                                data-elapsed="{{ $candidate->elapsed }}"
                                                data-duration="{{ $candidate->duration }}"
                                                data-indexing="{{  $candidate->indexing }}"
                                                data-toggle="tooltip"
                                                data-bs-placement="top"
                                                data-bs-title="Adjust Time"
                                                ><i class="las la-clock"></i> Adjust Time</button>
                                                @endif
                                            @endif
                                            <button class="dropdown-item reset-password"
                                            data-id="{{ $candidate->id }}"
                                            data-indexing="{{  $candidate->indexing }}"
                                            data-toggle="tooltip"
                                            data-bs-placement="top"
                                            data-bs-title="Reset Password"
                                            ><i class="las la-lock"></i> Reset Password</button>
                                        </div>
                                    </div>

                                </td>
                                <td>
                                    @if ($candidate->completed == '1')
                                        <span style="padding: 2px 8px;" class="badge badge-success">submitted</span>
                                    @elseif($candidate->completed == '0')
                                        <span style="padding: 2px 8px;" class="badge badge-warning">in progress</span>
                                    @else
                                        <span style="padding: 2px 8px;" class="badge badge-dark">pending</span>
                                    @endif
                                </td>
                                <td>{{ $candidate->indexing }}</td>
                                <td>
                                    {{ $candidate->fullname() }}
                                </td>
                                <td>{{ $candidate->papers }}</td>
                                <td class="ip-address">{{ $candidate->address }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endif

<div class="modal fade" id="restore_candidate" tabindex="-1" role="dialog" aria-labelledby="exampleModal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form class="restore_form" action="{{ route('exam.candidate.restore') }}" method="post">
                <div class="modal-body">
                    <div class="modal-toggle-wrapper">
                        <h4>Restore Candidate</h4>
                        <p>Are you sure you want to <strong>Restore</strong> this Candidate <span
                                class="candidate-indexing"></span> ?</p>
                        <input class="time-control-id" type="hidden" name="id" id="id">
                        @csrf
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-bs-dismiss="modal" class="btn btn-sm btn-danger submit-btn text-light">
                        Cancel
                    </button>
                    <button type="submit" data-bs-dismiss="modal" class="btn btn-sm btn-primary submit-btn text-light">
                        Restore
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{--    End Candidate Exams Modal --}}
<div class="modal fade custom-modal" id="end_candidate_exams">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form class="end_exam" action="{{ route('exam.candidate.endexam') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">End Candidate Exams</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to <strong>End</strong> this Candidate Exam 
                        <span class="candidate-indexing"></span> ?</p>
                    <input class="time-control-id" type="hidden" name="id" id="id">
                </div>
                <div class="modal-footer">
                    <button type="button" data-bs-dismiss="modal" class="btn btn-sm btn-danger submit-btn text-light">
                        Cancel
                    </button>
                    <button type="submit" data-bs-dismiss="modal" class="btn btn-sm btn-primary submit-btn text-light">
                        End
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Adjust Candidate Time Modal --}}
<div class="modal fade custom-modal" id="adjust_candidate_time">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adjust time for <span class="candidate-indexing"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form class="adjust-time-form" action="{{ route('exam.candidate.adjusttime') }} " method="post">
                @csrf
                <div class="modal-body">
                    <input class="time-control-id" type="hidden" name="id" id="id">
                    <div class="hours-info">
                        <div class="row hours-cont">
                            <div class="col-12 col-md-12">
                                <div class="row">
                                    <div class="col-12 col-md-12">
                                        <div class="mb-6">
                                            <input id="custom-time-range" name="new_time" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer submit-section text-end">
                    <button type="button" data-bs-dismiss="modal" class="btn btn-sm btn-danger submit-btn text-light"> 
                        Cancel
                    </button>
                    <button type="submit" data-bs-dismiss="modal" class="btn btn-sm btn-primary submit-btn text-light">Adjust</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="reset_password" tabindex="-1" role="dialog" aria-labelledby="exampleModal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form class="reset-password-form" action="{{ route('exam.candidate.reset-password') }}" method="post">
                <div class="modal-body">
                    <div class="modal-toggle-wrapper">
                        <h4>Reset Password for <span class="candidate-indexing"></span></h4>
                        <div class="form-group my-2">
                            {{-- <label for="reset-password">Reset Password</label> --}}
                            <input type="text" name="password" id="reset-password" class="form-control" placeholder="Enter password" required>
                        </div>
                        <input class="time-control-id" type="hidden" name="id" id="id">

                        @csrf
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-bs-dismiss="modal" class="btn btn-sm btn-danger submit-btn text-light">
                        Cancel
                    </button>
                    <button type="submit" data-bs-dismiss="modal" class="btn btn-sm btn-primary submit-btn text-light">
                        Restore
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('candidate/assets/js/range-slider/ion.rangeSlider.min.js') }}"></script>
{{-- <script src="{{ asset('candidate/assets/js/tooltip-init.js') }}"></script> --}}
<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
    $(document).ready(function() {
        $('#restore').modal('hide');
        $('.restore_form').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: 'post',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.status) {

                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'Okay'
                        })
                    }
                    console.log(response)
                }
            })
        })

        $('.end_exam').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: 'post',
                data: $(this).serialize(),
                success: function(response) {
                    $('#endexam').modal('hide')
                    if (response.status) {

                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'Okay'
                        })
                    }
                    console.log(response)

                }
            })
        })

        $('.adjust-time-form').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: 'post',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.status) {

                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'Okay'
                        })
                    }
                    console.log(response)
                }
            })
        })

        $('.reset-password-form').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: 'post',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.status) {
                        $('#reset-password').val('')
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'Okay'
                        })
                    }
                    console.log(response)
                }
            })
        })



        $('body').on('click', '.restore', function() {
            let candidate = $(this);
            console.log(candidate)
            $(".modal-body .time-control-id").val(candidate.data('id'));
            $(".modal-body .candidate-indexing").html(candidate.data('indexing'));
            $('#restore_candidate').modal('toggle')
        })

        $('body').on('click', ' .end-test', function() {
            let candidate = $(this);
            console.log(candidate)
            $(".modal-body .time-control-id").val(candidate.data('id'));
            $(".modal-body .candidate-indexing").html(candidate.data('indexing'));
            $('#endexam').modal('toggle')
        })

        $('body').on('click', ' .reset-password', function() {
            let candidate = $(this);
            console.log(candidate)
            $(".modal-body .time-control-id").val(candidate.data('id'));
            $(".modal-body .candidate-indexing").html(candidate.data('indexing'));
            $('#reset_password').modal('toggle')
        })


        $('#btnRestore').on('click', function() {
            let id = $(".modal-body #id").val()
            console.log(id)
            $.get('{{ route('exam.candidate.restore', [':id']) }}'.replace(':id', id),
                function(response) {
                    console.log(response)
                    $('#restore').modal('hide')
                    location.reload()
                }
            )
        })

        // $('#btnEndExam').on('click', function () {
        //     let id = $(".modal-body #id").val()
        //     console.log(id)
        //     $.get('{{ route('exam.candidate.endexam', [':id']) }}'.replace(':id', id),
        //         function (response) {
        //             console.log(response)
        //             $('#endexam').modal('hide')
        //             location.reload()
        //         }
        //     )
        // })

        $('body').on('click', '.adjust-time', function() {
            
            let candidate = $(this)
            let minute = candidate.data('elapsed') / 60
            $(".modal-body .time-control-id").val(candidate.data('id'));
            $(".candidate-indexing").html(candidate.data('indexing'));
            
            $("#custom-time-range").ionRangeSlider({
                min: 0,
                max: candidate.data('duration'),
                // from: ''+minute+'',
            })

            let my_range = $("#custom-time-range").data("ionRangeSlider");
            my_range.update({
                from: minute,
            });

            $('#adjust_candidate_time').modal('toggle')
            // $.post('{{ route('exam.candidate.adjusttime', [':id']) }}'.replace(':id', id),
            //     function (response) {
            //         console.log(response)
            //         $('#adjust_time').modal('hide')
            //         location.reload()
            //     }
            // )
        })

    });
</script>
