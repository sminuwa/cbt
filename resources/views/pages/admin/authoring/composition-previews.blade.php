@extends('layouts.app')

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
                        <span>Preview Test Questions</span>
                    </h4>
                </div>
            </div>
        </div>
        <div class="card-body pt-0" style="padding: 1px !important;"></div>
    </div>
    <div class="card border-info">
        <div class="card-header border-info">
            Available Test Papers
        </div>
        <div class="card-body p-3">
            <div class="row">
                <div class="col-12">
                    @if(count($subjects))
                        <table style="width: 90%" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th style="width: 10%">#</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th style="width: 20%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($subjects as $registered)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $registered->subject->subject_code }}</td>
                                    <td>{{ $registered->subject->name }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-outline-info"
                                           href="{{route('admin.test.config.composition.preview.questions',[$registered->id])}}">
                                            Preview Questions
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div style="width:100%;height: 100px;display: flex;justify-content: center;align-items: center">
                            No paper registered
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
