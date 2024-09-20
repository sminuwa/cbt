@php
    use App\Models\TestCode;
    use App\Models\TestConfig;
    use App\Models\TestType;
@endphp
@extends('layouts.app')

@section('content')
    @if (session()->has('success'))
        @if (!session('success'))
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
    
    <div class="row">
        <div class="col-sm-12 col-xl-12">
            <div class="card height-equal">
                <div class="card-header">
                    <h4>Test Configurations</h4>
                    <div class="card-header-right">
                        <a data-bs-toggle="modal" href="#add_new_config" class="btn btn-primary btn-xs px-3">
                            <i class="las la-plus text-white"></i>Add
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @json($configuration_files)
                </div>
            </div>
        </div>


    </div>
    
@endsection

@section('script')
    
@endsection
