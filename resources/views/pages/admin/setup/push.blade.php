@extends('layouts.app')

@section('css')
    <style>
        .loading-icon {
            display: none;
        }

        .lds-facebook,
        .lds-facebook span {
            box-sizing: border-box;
        }

        .lds-facebook {
            display: inline-block;
            position: relative;
            width: 24px;
            height: 24px;
        }

        .lds-facebook span {
            display: inline-block;
            position: absolute;
            left: 0px;
            width: 6px;
            background: currentColor;
            background: #1891d2;
            animation: lds-facebook 1.2s cubic-bezier(0, 0.5, 0.5, 1) infinite;
        }

        .lds-facebook span:nth-child(1) {
            left: 8px;
            animation-delay: -0.24s;
        }

        .lds-facebook span:nth-child(2) {
            left: 18px;
            animation-delay: -0.12s;
        }

        .lds-facebook span:nth-child(3) {
            left: 28px;
            animation-delay: 0s;
        }

        @keyframes lds-facebook {
            0% {
                top: 0px;
                height: 12px;
            }
            50%, 100% {
                top: 8px;
                height: 24px;
            }
        }


    </style>
@endsection
@section('content')
    @if(session()->has('success'))
        @if(!session('success'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @else
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    @endif
    <div class="card border-info">
        <div class="card-header">
            <div class="row">
                <div>
                    <h4 class="card-title d-flex justify-content-between">
                        <span>Push Finished Exam</span>

                    </h4>
                    <table class="table table-hover table-center mb-0" id="actionTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Setup</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if($counts )
                        <tr>
                            <th>1</th>
                            <td>Push Completed Sessions</td>
                            <td>

                                <a href="#"
                                   class="btn btn-info text-light btn-sm pull-btn">
                                    <i class="fa fa-download"></i> Push ({{$counts }} Candidates)
                                </a>
                                <span class="loading-icon">
                                    <span class="lds-facebook">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </span>
                                </span>

                            </td>
                        </tr>
                        @else
                            <tr>
                                <th colspan="3">
                                    <center>
                                        No Pending Examinations to push.
                                    </center>

                                </th>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-body pt-0" style="padding: 1px !important;"></div>
    </div>
    <div class="row mt-3">

    </div>
@endsection

@section('script')

    <script src="/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/assets/plugins/datatables/datatables.min.js"></script>
    <script src="/assets/swal.js"></script>
    <script>
        $(function () {
            $('#actionTable').DataTable({
                "bFilter": false,
                paging: false,
                ordering: false,
                searching: false,
                info: false  // Disable info display
            });

            let totalRecords = {{ $counts }} // Example total records (replace with actual dynamic value)
            // function sendBatch(batchSize, totalRecords, processedRecords = 0) {
            function sendBatch() {
                $.ajax({
                url: '{{ route("admin.exams.setup.push.finished") }}',
                type: 'GET',
                data: {
                    _token: '{{ csrf_token() }}',
                    batch_size: 10,
                    total_records: totalRecords,
                },
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        // Initialize totalRecords only on the first response
                        if (totalRecords === 0) {
                            totalRecords = response.totalRecords;
                        }

                        // Calculate progress
                        let processedRecords = totalRecords - response.remainingRecords;
                        let progressPercentage = Math.round((processedRecords / totalRecords) * 100);

                        // Update progress bar
                        updateProgressBar(progressPercentage)
                        // $('.swal2-progress-bar').css('width', progressPercentage + '%');
                        // $('.swal2-progress-bar').text(progressPercentage + '%');

                        // If there are more records to process, send another batch
                        if (response.remainingRecords > 0) {
                            sendBatch();
                        } else {
                           // Delay for 2 seconds before showing the success message
                            showSuccess()
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to process the batch'
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred during the batch push.'
                    });
                }
                });
            }


            $('.pull-btn').click(function () {
                
                Swal.fire({
                    title: 'Pushing Records...',
                    html: `
                        <p>Please wait while records are being pushed.</p>
                        <div class="progress" style="height: 25px;">
                            <div id="progress-bar" 
                                class="progress-bar progress-bar-striped progress-bar-animated" 
                                role="progressbar" 
                                style="width: 0%; height: 25px; background-color: #4caf50;">
                                0%
                            </div>
                        </div>
                    `,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        sendBatch(); // Start the batch process
                    }
                });
            });

            function updateProgressBar(percentage) {
                var progressBar = $('#progress-bar');
                progressBar.css('width', percentage + '%');
                progressBar.text(percentage + '%');
            }

            function showSuccess() {
                setTimeout(() => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Records Pushed Successfully!',
                        text: 'Click OK to reload the page.',
                        showConfirmButton: true
                    }).then(() => {
                        location.reload(); // Reload the page after clicking OK
                    });
                }, 2000); // Add a 2-second delay after progress bar completion
            }
        });
    </script>
@endsection
