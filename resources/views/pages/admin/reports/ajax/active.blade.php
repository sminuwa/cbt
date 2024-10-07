<link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/vendors/range-slider.css') }}">
@if(count($candidates)==0)
    <h4 style="text-align: center">No active candidate taking this test</h4>
@else
    <div class="card">
        <div class="card-body">
        <div class="table-responsive">
            <table class="display" id="export-button-sample">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Indexing</th>
                        <th>Full name</th>
                        <th>IP Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($candidates as $candidate)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$candidate->indexing}}</td>
                            <td>
                                <img class="img-fluid table-avtar" src="{{ $candidate->passport() }}" alt="">
                                {{ $candidate->fullname() }}
                            </td>
                            <td class="ip-address">{{$candidate->address}}</td>
                            <td>
                                @if($candidate->time_control_id)
                                <button class="btn btn-sm btn-danger"
                                   data-bs-toggle="modal"
                                   href="#end_candidate_exams"
                                   data-id="{{$candidate->time_control_id}}"
                                >End Exam</button>
                                <button class="btn btn-sm btn-info restore"
                                    type="button" 
                                    data-id="{{$candidate->time_control_id}}"
                                    data-indexing="{{  $candidate->indexing }}">
                                    Restore
                                </button>
                                <button class="btn btn-sm btn-primary adjust-time"
                                   data-id="{{ $candidate->time_control_id }}"
                                   data-elapsed="{{ $candidate->elapsed }}"
                                   data-duration="{{ $candidate->duration }}"
                                >Adjust Time</button>
                                @endif
                            </td>
                    </tr>
                 @endforeach
                </tbody>
            </table>
        </div>
        
    </div>
    </div>
@endif

<div class="modal fade" id="restore_candidate" tabindex="-1" role="dialog" aria-labelledby="exampleModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form class="restore_form" action="{{ route('exam.candidate.restore') }}" method="post">
            <div class="modal-body">
            <div class="modal-toggle-wrapper"> 
                <h4>Restore Candidate</h4>
                <p>Are you sure you want to <strong>Restore</strong> this Candidate <span id=candidate-indexing></span> ?</p>
                <input type="hidden" name="id" id="id">
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

{{--    End Candidate Exams Modal--}}
    <div class="modal fade custom-modal" id="end_candidate_exams">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">End Candidate Exams</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to <strong>End</strong> this Candidate Exam ({{$candidate->indexing}})?</p>
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

                                        <div class="col-12 col-md-12">
                                            <div class="mb-6">
                                                <input id="custom-time-range" type="text">
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

    <script src="{{ asset('candidate/assets/js/range-slider/ion.rangeSlider.min.js') }}"></script>

    <script>
       
        $(document).ready(function () {
            $('#restore').modal('hide');
            
            $('.restore_form').on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    type:'post',
                    data: $(this).serialize(),
                    success : function(response){
                        if(response.status){

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
    
            $('body').on('click', '.restore', function () {
                let candidate = $(this);
                console.log(candidate)
                $(".modal-body #id").val(candidate.data('id'));
                $(".modal-body #candidate-indexing").html(candidate.data('indexing'));
                $('#restore_candidate').modal('toggle')
            })
    
            $('#btnRestore').on('click', function () {
                let id = $(".modal-body #id").val()
                console.log(id)
                $.get('{{route('exam.candidate.restore',[':id'])}}'.replace(':id', id),
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
                $.get('{{route('exam.candidate.endexam',[':id'])}}'.replace(':id', id),
                    function (response) {
                        console.log(response)
                        $('#endexam').modal('hide')
                        location.reload()
                    }
                )
            })

            
        });
    </script>

