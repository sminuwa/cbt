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
                        <span>Setup Request</span>

                    </h4>
                    <table class="table table-hover table-center mb-0" id="actionTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Setup</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th>1</th>
                            <td>Basic Data</td>
                            <td>{{ isset($results['basic-data'])?"Pulled Today":"Pending" }}</td>
                            <td>

                                <a href="#"
                                   class="btn btn-info text-light btn-sm pull-btn">
                                    <i class="fa fa-download"></i> Pull
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
                        <tr>
                            <th>2</th>
                            <td>Test Config Data</td>
                            <td>{{ isset($results['test-data'])?"Pulled Today":"Pending" }}</td>
                            <td>

                                <a href="#"
                                   class="btn btn-info text-light btn-sm pull-btn2">
                                    <i class="fa fa-download"></i> Pull
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
                        <tr>
                            <th>3</th>
                            <td>Candidate Data</td>
                            <td>{{ isset($results['candidate-data'])?"Pulled Today":"Pending" }}</td>
                            <td>

                                <a href="#"
                                   class="btn btn-info text-light btn-sm pull-btn3">
                                    <i class="fa fa-download"></i> Pull
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
                        <tr>
                            <th>4</th>
                            <td>Candidate Pictures</td>
                            <td>{{ isset($results['candidate-pictures'])?"Pulled Today":"Pending" }}</td>
                            <td>

                                <a href="#"
                                   class="btn btn-info text-light btn-sm pull-btn4">
                                    <i class="fa fa-download"></i> Pull
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

            $('.pull-btn2').click(function () {
                var btn = $(this);
                var loadingIcon = btn.siblings('.loading-icon');
                var resourceId = btn.data('id');

                btn.hide();
                loadingIcon.show();

                $.ajax({
                    url: '{{route('admin.exams.setup.pull.test')}}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        console.log(response);
                        if (response.success) {
                            btn.closest('tr').find('td:eq(1)').text('Updated'); // Update status
                            loadingIcon.hide();
                            btn.show();
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Data pulled and inserted successfully!'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed',
                                text: 'Failed to pull resource'
                            });
                            loadingIcon.hide();
                            btn.show();
                        }
                    },
                    error: function (response) {
                        console.log(response);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred'
                        });
                        loadingIcon.hide();
                        btn.show();
                    }
                });
            });//pull.candidate.pictures

            $('.pull-btn3').click(function () {
                var btn = $(this);
                var loadingIcon = btn.siblings('.loading-icon');
                var resourceId = btn.data('id');

                btn.hide();
                loadingIcon.show();

                $.ajax({
                    url: '{{route('admin.exams.setup.pull.candidate')}}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        console.log(response);
                        if (response.success) {
                            btn.closest('tr').find('td:eq(1)').text('Updated'); // Update status
                            loadingIcon.hide();
                            btn.show();
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Data pulled and inserted successfully!'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed',
                                text: 'Failed to pull resource'
                            });
                            loadingIcon.hide();
                            btn.show();
                        }
                    },
                    error: function (response) {
                        console.log(response);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred'
                        });
                        loadingIcon.hide();
                        btn.show();
                    }
                });
            });//pull.candidate.pictures

            $('.pull-btn4').click(function () {
                var btn = $(this);
                var loadingIcon = btn.siblings('.loading-icon');
                var resourceId = btn.data('id');

                btn.hide();
                loadingIcon.show();

                $.ajax({
                    //url: '{{route('admin.exams.setup.pull.candidate.pictures')}}',
                    url: '{{route('client.pull.picture')}}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        console.log(response);
                        if (response.success) {
                            btn.closest('tr').find('td:eq(1)').text('Updated. ('+response.data+')'); // Update status
                            loadingIcon.hide();
                            btn.show();
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Data pulled and inserted successfully!'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed',
                                text: response.message//'Failed to pull resource'
                            });
                            loadingIcon.hide();
                            btn.show();
                        }
                    },
                    error: function (response) {
                        console.log(response);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred'
                        });
                        loadingIcon.hide();
                        btn.show();
                    }
                });
            });//pull.candidate.pictures


            $('.pull-btn').click(function () {
                var btn = $(this);
                var loadingIcon = btn.siblings('.loading-icon');
                var resourceId = btn.data('id');

                btn.hide();
                loadingIcon.show();

                $.ajax({
                    url: '{{route('admin.exams.setup.pull.basic')}}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        console.log(response);
                        if (response.success) {
                            btn.closest('tr').find('td:eq(1)').text('Updated'); // Update status
                            loadingIcon.hide();
                            btn.show();
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Data pulled and inserted successfully!'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed',
                                text: 'Failed to pull resource'
                            });
                            loadingIcon.hide();
                            btn.show();
                        }
                    },
                    error: function (response) {
                        console.log(response);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred'
                        });
                        loadingIcon.hide();
                        btn.show();
                    }
                });
            });
        });
    </script>
@endsection
