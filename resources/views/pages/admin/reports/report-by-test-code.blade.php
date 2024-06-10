@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">
@endsection
@section('content')
    <div class="row">
        <x-head.tinymce-config/>
        <div class="row patient-graph-col">
            <div class="col-12">
                <h4 class="mb-5 mt-5">Report By Test Code</h4>
                <form id="preview-form" method="post">
                    @csrf
                    <div class="row pb-3 pt-2">
                        <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="year">Year:</label>
                                <input id="year" class="form-control" type="date" name="year" placeholder="Year of Exam"
                                       required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="subject_id">Test Code:</label>
                                <select class="form-control form-select" name="subject_id" id="subject_id" required>
                                    <option value="">Select Test Code</option>
                                    @foreach(\App\Models\TestCode::all() as $code)
                                        <option value="{{$code->id}}">{{ $code->name }}</option>
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
                    $('#questions-div').html(response)
                    jQuery('#report').DataTable({
                        layout: {
                            topStart: {
                                buttons: ['csv', 'excel', 'pdf']
                            }
                        }
                    })
                })
            })
        })
    </script>
@endsection
