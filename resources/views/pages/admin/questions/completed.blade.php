@php
    $stats = session('question_stats', []);
@endphp
@extends('layouts.app')

@section('content')
    <div class="row">
        <x-head.tinymce-config/>
        <div class="row patient-graph-col">
            <div class="col-12">
                <h4 class="mb-5 mt-5">
                    <i class="fa fa-check-circle text-success"></i> Questions Authoring Completed
                </h4>
                
                <!-- Summary Card -->
                <div class="card border-success mb-4">
                    <div class="card-header bg-success">
                        <h4 class="card-title text-white mb-0">
                            <i class="fa fa-chart-bar"></i> Upload Statistics
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Overview Stats -->
                            <div class="col-xl-3 col-sm-6 mb-3">
                                <div class="card o-hidden small-widget">
                                    <div class="card-body total-project border-l-success border-3">
                                        <span class="f-light f-w-500 f-14">Total Questions</span>
                                        <div class="project-details"> 
                                            <div class="project-counter"> 
                                                <h2 class="f-w-600 d-inline text-success">{{ $stats['total_questions'] ?? 0 }}</h2>
                                                Processed
                                            </div>
                                            <div class="product-sub bg-success-light">
                                                <i class="fa fa-list-ol fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-sm-6 mb-3">
                                <div class="card o-hidden small-widget">
                                    <div class="card-body total-project border-l-primary border-3">
                                        <span class="f-light f-w-500 f-14">Successfully Added</span>
                                        <div class="project-details"> 
                                            <div class="project-counter"> 
                                                <h2 class="f-w-600 d-inline text-primary">{{ $stats['successfully_submitted'] ?? $stats['valid_questions'] ?? 0 }}</h2>
                                                Questions
                                            </div>
                                            <div class="product-sub bg-primary-light">
                                                <i class="fa fa-check fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-sm-6 mb-3">
                                <div class="card o-hidden small-widget">
                                    <div class="card-body total-project border-l-warning border-3">
                                        <span class="f-light f-w-500 f-14">Total Duplicates</span>
                                        <div class="project-details"> 
                                            <div class="project-counter"> 
                                                <h2 class="f-w-600 d-inline text-warning">{{ $stats['total_duplicates'] ?? $duplicates }}</h2>
                                                Questions
                                            </div>
                                            <div class="product-sub bg-warning-light">
                                                <i class="fa fa-copy fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-sm-6 mb-3">
                                <div class="card o-hidden small-widget">
                                    <div class="card-body total-project border-l-danger border-3">
                                        <span class="f-light f-w-500 f-14">Processing Errors</span>
                                        <div class="project-details"> 
                                            <div class="project-counter"> 
                                                <h2 class="f-w-600 d-inline text-danger">{{ count($stats['processing_errors'] ?? []) }}</h2>
                                                Errors
                                            </div>
                                            <div class="product-sub bg-danger-light">
                                                <i class="fa fa-exclamation-triangle fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Difficulty Distribution -->
                @if(($stats['total_questions'] ?? 0) > 0)
                <div class="row mb-4">
                    <div class="col-xl-6 col-12 mb-3">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <i class="fa fa-layer-group"></i> Difficulty Distribution
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4 text-center">
                                        <h3 class="text-success">{{ $stats['simple'] ?? 0 }}</h3>
                                        <span class="f-light">Simple</span>
                                    </div>
                                    <div class="col-4 text-center">
                                        <h3 class="text-warning">{{ $stats['moderate'] ?? 0 }}</h3>
                                        <span class="f-light">Moderate</span>
                                    </div>
                                    <div class="col-4 text-center">
                                        <h3 class="text-danger">{{ $stats['difficult'] ?? 0 }}</h3>
                                        <span class="f-light">Difficult</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-12 mb-3">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <i class="fa fa-info-circle"></i> Additional Details
                                </h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm">
                                    <tr>
                                        <td>Total Options:</td>
                                        <td><strong>{{ $stats['total_options'] ?? 0 }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Questions with Correct Answers:</td>
                                        <td><strong class="text-success">{{ $stats['questions_with_correct_answers'] ?? 0 }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Questions without Correct Answers:</td>
                                        <td><strong class="text-danger">{{ $stats['questions_without_correct_answers'] ?? 0 }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Empty Questions:</td>
                                        <td><strong class="text-warning">{{ $stats['empty_questions'] ?? 0 }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Insufficient Options:</td>
                                        <td><strong class="text-warning">{{ $stats['questions_with_insufficient_options'] ?? 0 }}</strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Duplicate Breakdown -->
                    @if(($stats['total_duplicates'] ?? 0) > 0)
                    <div class="col-xl-6 col-12 mb-3">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <i class="fa fa-copy"></i> Duplicate Breakdown
                                </h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm">
                                    <tr>
                                        <td>Duplicates within Upload:</td>
                                        <td><strong class="text-warning">{{ $stats['duplicates_in_batch'] ?? 0 }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Duplicates with Existing:</td>
                                        <td><strong class="text-info">{{ $stats['duplicates_with_existing'] ?? 0 }}</strong></td>
                                    </tr>
                                    <tr class="table-warning">
                                        <td><strong>Total Duplicates:</strong></td>
                                        <td><strong class="text-warning">{{ $stats['total_duplicates'] ?? 0 }}</strong></td>
                                    </tr>
                                </table>
                                <small class="text-muted">
                                    <i class="fa fa-info-circle"></i>
                                    Duplicate detection uses case-insensitive text comparison
                                </small>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Errors Section -->
                @if(!empty($stats['processing_errors']))
                <div class="card border-danger mb-4">
                    <div class="card-header bg-danger">
                        <h5 class="card-title text-white mb-0">
                            <i class="fa fa-exclamation-triangle"></i> Processing Errors
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-danger">
                            <strong>The following errors were encountered during processing:</strong>
                        </div>
                        <ul class="list-group">
                            @foreach($stats['processing_errors'] as $error)
                            <li class="list-group-item list-group-item-danger">
                                <i class="fa fa-times-circle"></i> {{ $error }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <!-- Success Message -->
                <div class="card border-success">
                    <div class="card-header bg-light">
                        <h4 class="card-title text-success">
                            <i class="fa fa-check-circle"></i> Process Completed Successfully!
                        </h4>
                    </div>
                    <div class="card-body pt-2 pb-2 mt-1 mb-1">
                        <div class="row">
                            <div class="col-12">
                                @if(($stats['successfully_submitted'] ?? $stats['valid_questions'] ?? 0) > 0)
                                    <p class="mb-3">
                                        <strong class="text-success">Great job!</strong> 
                                        <strong>{{ $stats['successfully_submitted'] ?? $stats['valid_questions'] ?? 0 }}</strong> 
                                        question(s) have been successfully added to your question bank.
                                    </p>
                                @endif

                                @if(($stats['total_duplicates'] ?? $duplicates) > 0)
                                    <p class="mb-3">
                                        <i class="fa fa-info-circle text-info"></i>
                                        <strong>{{ $stats['total_duplicates'] ?? $duplicates }}</strong> duplicate question(s) were detected and 
                                        <span class="text-danger"><strong>automatically removed</strong></span> to maintain question bank integrity.
                                        
                                        @if(isset($stats['duplicates_in_batch']) && $stats['duplicates_in_batch'] > 0)
                                            <br><small class="text-muted">
                                                <i class="fa fa-arrow-right"></i>
                                                {{ $stats['duplicates_in_batch'] }} found within your upload
                                            </small>
                                        @endif
                                        
                                        @if(isset($stats['duplicates_with_existing']) && $stats['duplicates_with_existing'] > 0)
                                            <br><small class="text-muted">
                                                <i class="fa fa-arrow-right"></i>
                                                {{ $stats['duplicates_with_existing'] }} already exist in the question bank
                                            </small>
                                        @endif
                                    </p>
                                @endif

                                @if(!empty($stats['processing_errors']))
                                    <p class="mb-3">
                                        <i class="fa fa-exclamation-triangle text-warning"></i>
                                        <strong>{{ count($stats['processing_errors']) }}</strong> processing error(s) were encountered. 
                                        Please review the errors above and correct your question format if needed.
                                    </p>
                                @endif

                                @if(isset($stats['submission_time']))
                                    <p class="text-muted small mb-3">
                                        <i class="fa fa-clock"></i> Completed at: {{ $stats['submission_time'] }}
                                    </p>
                                @endif

                                <div class="mt-4">
                                    <a href="{{ route('admin.authoring.index') }}" class="btn btn-success me-2">
                                        <i class="fa fa-plus"></i> Add More Questions
                                    </a>
                                    <a href="{{ route('admin.authoring.preview') }}" class="btn btn-info me-2">
                                        <i class="fa fa-eye"></i> Preview Questions
                                    </a>
                                    <a href="{{ route('admin.authoring.edit.questions') }}" class="btn btn-secondary">
                                        <i class="fa fa-edit"></i> Edit Questions
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
