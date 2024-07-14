@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if(Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            @endif
            @if(Session::has('error'))
                <div class="alert alert-danger">
                    {{ Session::get('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                            <span>Candidate Upload - Excel Format</span>
                        </h4>
                    </div>
                </div>
            </div>

        </div>

        <div class="alert alert-warning">
            <b style="color:red;">NOTE:</b> You can upload from Excel workbook .xls or .xlsx format. Click
            <a style="color:orange; font-style: italic;" target="_blank" href="{{ asset('assets/file/student_list_upload_template.xlsx') }}">here</a> to download the template.
        </div>
        <br>
    <div>
        <form action="{{ route('toolbox.candidate_upload.upload.candidate.data') }}" enctype="multipart/form-data" method="POST" class="form-style">
            @csrf
            <div class="form-group row justify-content-center">
                <label for="file" class="col-form-label col-sm-2">Select Excel File</label>
                <div class="col-sm-4">
                    <input type="file" name="file" id="file" class="form-control">
                </div>
            </div>
            <div class="form-group row justify-content-center mt-3">
                <div class="col-sm-6 text-center">
                    <button type="submit" class="btn btn-primary" id="continue_btn">Upload</button>
                </div>
            </div>
        </form>
    </div>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
{{--    @if (session('success'))--}}
{{--        <div class="alert alert-success">--}}
{{--            {{ session('success') }}--}}
{{--        </div>--}}
{{--    @endif--}}

@endsection
