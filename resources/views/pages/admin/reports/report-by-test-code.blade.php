@php use App\Models\TestCode;use App\Models\TestType; @endphp
@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">
@endsection
@section('content')
    <div class="row">
        <x-head.tinymce-config/>
        <div class="row patient-graph-col">
            <div class="col-12">
                <div class="card border-info">
                    <div class="card-header">
                        <div class="row">
                            <div>
                                <h4 class="card-title d-flex justify-content-between">
                                    <span>Report By Cadre/Programme</span>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0" style="padding: 1px !important;"></div>
                </div>
                <form id="preview-form" method="post">
                    @csrf
                    <div class="row pb-3 pt-2">
                        <div class="col-12 col-md-6 col-lg-3 col-xl-3">
                            <div class="form-group">
                                <label for="year">Year:</label>
                                <select class="form-control form-select" name="year" id="year" required>
                                    <option value="">Select Year</option>
                                    @foreach($years as $year)
                                        <option value="{{$year}}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3 col-xl-3">
                            <div class="form-group">
                                <label for="semester">Test Period:</label>
                                <select class="form-control form-select" name="semester" id="semester" required>
                                    <option value="">Select Test Period</option>
                                    <option value="1">April</option>
                                    <option value="2">September</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3 col-xl-3">
                            <div class="form-group">
                                <label for="test_code_id">Cadre/Programme:</label>
                                <select class="form-control form-select" name="test_code_id" id="test_code_id" required>
                                    <option value="">Select</option>
                                    @foreach(TestCode::all() as $code)
                                        <option value="{{$code->id}}">{{ $code->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3 col-xl-3">
                            <div class="form-group">
                                <label for="test_type_id">Type:</label>
                                <select class="form-control form-select" name="test_type_id" id="test_type_id" required>
                                    <option value="">Select Type</option>
                                    @foreach(TestType::all() as $type)
                                        <option value="{{$type->id}}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                            <input type="submit" class="btn btn-info text-light mt-4" value="Generate"/>
                        </div>
                    </div>
                </form>
                <div class="card card-table">
                    <div class="card-body">
                        <div id="questions-div">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Datatables JS -->
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
    <script>
        $(function () {
            $('#preview-form').on('submit', function (e) {
                e.preventDefault()
                $.post('{{ route('admin.reports.testcode.generate') }}', $(this).serialize(), function (response) {
                    console.log(response)
                    // $('#questions-div').html(response)
                    // jQuery('#report').DataTable({
                    //     layout: {
                    //         topStart: {
                    //             buttons: ['csv', 'excel', 'pdf']
                    //         }
                    //     }
                    // })
                })
            })
        })
    </script>
@endsection
