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
    <div class="modal fade custom-modal" id="add_new_config">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Test Config</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>

                </div>
                <form action="{{ route('admin.test.config.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="hours-info">
                            <div class="row hours-cont">
                                <div class="col-12 col-md-12">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="mb-3">
                                                @php
                                                    $now = date('Y');
                                                    $years = range($now - 2, $now + 2);
                                                @endphp
                                                <label for="session" class="mb-2">Year</label>
                                                <select class="form-select form-control" id="session" name="session"
                                                        required>
                                                    @foreach($years as $year)
                                                        <option
                                                            value="{{ $year }}" {{$year==$now?'selected':''}} >{{ $year }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="mb-3">
                                                <label class="mb-2" for="semester">Semester</label>
                                                <select class="form-select form-control" id="semester" required
                                                        name="semester">
                                                    <option value="1" selected>First</option>
                                                    <option value="2">Second</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row hours-cont">
                                <div class="col-12 col-md-12">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="mb-3">
                                                <label for="test_code_id" class="mb-2">Test Code</label>
                                                <select class="form-select form-control" id="test_code_id" required
                                                        name="test_code_id">
                                                    <option value="">Select Test Code</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="mb-3">
                                                <label for="test_type_id" class="mb-2">Test Type</label>
                                                <select class="form-select form-control" id="test_type_id" required
                                                        name="test_type_id">
                                                    <option value="">Select Test Type</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer submit-section text-end">
                        <button type="submit" class="btn btn-sm btn-info submit-btn text-light">Create Test</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
