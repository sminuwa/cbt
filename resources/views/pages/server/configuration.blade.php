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
                    <div class="accordion dark-accordion" id="simpleaccordion">
                        @foreach ($configs as $config)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed accordion-light-primary txt-primary active"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{ $config->id }}"
                                    aria-expanded="true" aria-controls="collapseOne">
                                    {{ $config->session }} / {{ $config->test_code->name }} / {{ $config->test_type->name }}
                                    <i class="svg-color" data-feather="chevron-down"></i>
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse @if($loop->first) show @endif" id="collapseOne{{ $config->id }}" aria-labelledby="headingOne"
                                data-bs-parent="#simpleaccordion">
                                <div class="accordion-body">
                                                        
                                    <div class="row">
                                        <div class="col-8 col-lg-8 col-xl-8 col-md-6">
                                            <div class="row">
                                                <div class="col-xl-4 col-sm-6">
                                                    <div class="card o-hidden small-widget">
                                                        <div class="card-body total-project border-l-primary border-3">
                                                        <span class="f-light f-w-500 f-14">Test Papers</span>
                                                        <div class="project-details"> 
                                                            <div class="project-counter"> 
                                                                <h2 class="f-w-600 d-inline">{{ count($config->test_subjects) ?? 0}}</h2>
                                                                Papers
                                                            </div>
                                                            <div class="product-sub bg-primary-light">
                                                                <i class="las la-clipboard-list la-2x"></i>
                                                            </div>
                                                        </div>
                                                        @include('components.bubbles')
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-sm-6">
                                                    <div class="card o-hidden small-widget">
                                                        <div class="card-body total-project border-l-primary border-3">
                                                        <span class="f-light f-w-500 f-14">Test Duration</span>
                                                        <div class="project-details"> 
                                                            <div class="project-counter"> 
                                                                <h2 class="f-w-600 d-inline">{{ $config->duration ?? 0}}</h2>
                                                                mins
                                                            </div>
                                                            <div class="product-sub bg-primary-light">
                                                                <i class="las la-clock la-2x"></i>
                                                            </div>
                                                        </div>
                                                        @include('components.bubbles')
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-sm-6 ">
                                                    <div class="card o-hidden small-widget">
                                                        <div class="card-body border-l-primary border-3">
                                                        <span class="f-light f-w-500 f-14">Test Extra Time</span>
                                                        <div class="project-details"> 
                                                            <div class="project-counter"> 
                                                                <h2 class="f-w-600 d-inline">{{ $config->time_padding ?? 0}}</h2>
                                                                mins
                                                            </div>
                                                            <div class="product-sub bg-primary-light">
                                                                <i class="las la-clock la-2x"></i>
                                                            </div>
                                                        </div>
                                                        @include('components.bubbles')
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="card ">
                                                <div class="card-body border-l-primary border-3">
                                                    
                                                    <div> 
                                                        <h6 class="mb-1  f-light">Other Settings</h6>
                                                        <table class="w-100">
                                                            <tbody>
                                                                <tr>
                                                                <td> <b>Questions / Options:</b></td>
                                                                <td>{{  $config->question_administration }} / {{ $config->option_administration }}</td>
                                                                </tr>
                                                                <tr>
                                                                <td> <b>Availability:</b></td>
                                                                <td class="txt-{{ $config->status == 1 ? 'success': 'danger' }}">
                                                                    {{ $config->status == 1 ? 'Available': 'Unavailable' }}
                                                                </td>
                                                                </tr>
                                                                <tr>
                                                                <td> <b>Question display mode:</b></td>
                                                                <td>{{  $config->display_mode }}</td>
                                                                </tr>
                                                            </tbody>
                                                            </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4 col-lg-4 col-xl-4 col-md-6">
                                            <div class="card">
                                                <div class="card-body border-l-primary border-3 b-r-5">
                                                    <ol style="list-style-type: circle;" class="mt-3">
                                                        <li><a href="{{ route('admin.test.config.basics', [$config->id]) }}"class="mb-2">Configurations</a></li>
                                                        {{-- <li><a href="" class="mb-2">Toggle Availability</a></li> --}}
                                                        <li><a href="{{ route('admin.test.config.dates', [$config->id]) }}" class="mb-2">Test Date</a></li>
                                                        <li><a href="{{ route('admin.test.config.schedules', [$config->id]) }}" class="mb-2">Test Schedule</a></li>
                                                        <li><a href="{{ route('admin.test.config.subjects', [$config->id]) }}" class="mb-2">Test Papers</a></li>
                                                        <li><a href="{{ route('admin.test.config.composition', [$config->id]) }}" class="mb-2">Test Composition</a></li>
                                                        <li><a href="{{ route('admin.test.config.upload.options', [$config->id]) }}" class="mb-2">Candidates Upload</a></li>
                                                        <li><a href="{{ route('admin.test.config.composition.preview', [$config->id]) }}" class="mb-2">Test Questions Preview</a></li>
                                                        <li><a href="{{ route('admin.test.config.manage.users', [$config->id]) }}" class="mb-2">Test Users</a></li>
                                                        <li><a href="#" class="mb-2">Delete Test</a></li>
                                                    </ol>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                </div>
            </div>
        </div>


    </div>
    @if (count($configs) == 0)
        <div class="card border-info">
            <div class="card-header">
                <h4 class="card-title">&nbsp;</h4>
            </div>
            <div class="card-body pt-2 pb-2  mt-1 mb-1">
                <div class="row">
                    <div class="row pb-5 pt-5">
                        <p class="text-center"> No Configuration created yet. Use the button above to add new.</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('script')
    
@endsection
