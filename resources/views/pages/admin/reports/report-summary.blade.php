@php use App\Models\TestCode;use App\Models\TestType; @endphp
@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">
@endsection
@section('content')
    <div class="row">
        {{-- <x-head.tinymce-config/> --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div>
                            <h4 class="card-title d-flex justify-content-between">
                                <span>Report Summary</span>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-4">
                    <form id="preview-form" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-4 col-lg-4 col-xl-4 mb-3">
                                <div class="form-group">
                                    <label for="year">Test Type:</label>
                                    <select class="form-control select2" name="type_id" id="type_id" required>
                                        <option value="">Select Test Type</option>
                                        @foreach(TestType::orderBy('name')->get() as $type)
                                            <option value="{{$type->id}}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-8 col-lg-8 col-xl-8 mb-3">
                                <div class="form-group">
                                    <label for="centre_id">Centre:</label>
                                    <select class="form-control select2" name="centre_id" id="centre_id" required>
                                        <option value="">Select centre</option>
                                        @foreach($centres as $centre)
                                            <option value="{{ $centre->id }}">{{ $centre->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-4 mb-3">
                                <div class="form-group">
                                    <label for="test_type_id">Year:</label>
                                    <select class="form-control select2" name="year" id="year" required>
                                        <option value="">Select Year</option>
                                        @foreach($years as $year)
                                            <option value="{{$year}}">{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-12 col-md-6 col-lg-4 col-xl-4 mb-3">
                                <div class="form-group">
                                    <label for="year">Cadre/Programme:</label>
                                    <select class="form-control select2" name="code_id" id="code_id" required>
                                        <option value="">Select Cadre</option>
                                        @foreach(TestCode::orderBy('name')->get() as $code)
                                            <option value="{{$code->id}}">{{ $code->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-12 col-md-6 col-lg-4 col-xl-4 mb-3">
                                <div class="form-group">
                                    <label for="subject_id">Subject:</label>
                                    <select class="form-control select2" name="subject_id" id="subject_id">
                                        <option value="all">All Subjects</option>
                                        @foreach($subjects as $subject)
                                            <option value="{{$subject->id}}">{{ $subject->subject_code }} - {{ $subject->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                                <input type="submit" class="btn btn-info text-light mt-4" value="Generate"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card card-table">
                <div id="report-div" class="card-body"></div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Datatables JS -->
    {{-- <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script> --}}
    <script>
        $(function () {
            $('#type_id, #code_id, #year').on('change', function () {
                const type = $('#type_id').val(), code = $('#code_id').val(), year = $('#year').val()
                if (type !== '' && code !== '' && year !== '') {
                    $.get('{{route('admin.misc.test.config',[':y',':t',':c'])}}'.replace(':y', year).replace(':t', type).replace(':c', code)
                        , function (response) {
                            $('#test_id').html(response)
                        }
                    )
                }
            })
            $('#preview-form').on('submit', function (e) {
                e.preventDefault()
                $.ajax({
                    url: '{{ route('admin.reports.summary.generate.report') }}',
                    type: 'POST',
                    data: $(this).serialize(),
                    beforeSend:function(){
                        $('#report-div').html("Loading report...")
                    },
                    success:function(response){
                        console.log(response)
                        $('#report-div').html(response)
                        $('.display').DataTable({
                            responsive: true,
                            dom: "Bfrtip",
                            buttons: ["copyHtml5", "excelHtml5", "csvHtml5", "pdfHtml5"],
                        });
                    },
                    error:function(err, hrx){
                        // console.log(err)
                        console.log(err)
                    }
                })
                
            })
        })
    </script>
@endsection
