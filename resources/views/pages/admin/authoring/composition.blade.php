@php use App\Models\Centre;use App\Models\ExamsDate;use App\Models\Scheduling;use Carbon\Carbon; @endphp
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
                    <h4 class="card-title d-flex justify-content-between align-items-center">
                        <span>Test Composition</span>
                        <div class="d-flex gap-2 align-items-center">
                            <div class="btn-group btn-group-xs" role="group">
                                <a href="{{ route('admin.test.config.dates', $config->id) }}" class="btn btn-xs btn-outline-secondary" title="Test Dates">
                                    <i class="las la-calendar"></i> Dates
                                </a>
                                <a href="{{ route('admin.test.config.subjects', $config->id) }}" class="btn btn-xs btn-outline-primary" title="Test Papers">
                                    <i class="las la-book"></i> Papers
                                </a>
                                <a href="{{ route('admin.test.config.schedules', $config->id) }}" class="btn btn-xs btn-outline-warning" title="Test Schedules">
                                    <i class="las la-calendar-alt"></i> Schedules
                                </a>
                                <a href="{{ route('admin.test.config.basics', $config->id) }}" class="btn btn-xs btn-outline-info" title="Test Config">
                                    <i class="las la-cog"></i> Config
                                </a>
                            </div>
                            <a href="{{ route('admin.test.config.index') }}" class="btn btn-info btn-xs text-light">
                                <i class="las la-arrow-left"></i> Panel
                            </a>
                        </div>
                    </h4>
                </div>
            </div>
        </div>
        <div class="card-body text-center">
            <h5 class="text-muted mb-2">Manage Test Composition</h5>
            <h4 class="test-title mb-3">{{ $config->title }} - {{ $config->session }} - {{ $config->test_code->name ?? 'No Code' }} - {{ $config->test_type->name ?? 'No Type' }}</h4>
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        @if($config->paper)
                        <div class="test-info-item">
                            <i class="las la-file-alt text-primary me-2"></i>
                            <span><strong>Paper:</strong> {{$config->paper}}</span>
                        </div>
                        @endif
                        @if($config->code)
                        <div class="test-info-item">
                            <i class="las la-code text-primary me-2"></i>
                            <span><strong>Code:</strong> {{$config->code}}</span>
                        </div>
                        @endif
                        @if($config->year)
                        <div class="test-info-item">
                            <i class="las la-calendar text-primary me-2"></i>
                            <span><strong>Year:</strong> {{$config->year}}</span>
                        </div>
                        @endif
                        @if($config->exam_type)
                        <div class="test-info-item">
                            <i class="las la-graduation-cap text-primary me-2"></i>
                            <span><strong>Type:</strong> {{$config->exam_type}}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Test Papers Composition Section -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="las la-layer-group me-2"></i>
                        Test Papers Available for Composition
                        <span class="badge bg-light text-dark ms-2">{{ count($subjects) }}</span>
                    </h5>
                    <small>Configure question sections and composition for each paper</small>
                </div>
                <div class="card-body">
                    @if(count($subjects))
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="las la-search"></i>
                                    </span>
                                    <input type="text" id="searchPapers" class="form-control" placeholder="Search papers by name or code...">
                                </div>
                            </div>
                            <div class="col-md-6 text-end">
                                <div class="text-muted small">
                                    <i class="las la-info-circle me-1"></i>
                                    Click "Compose" to add sections and questions to each paper
                                </div>
                            </div>
                        </div>
                        
                        <!-- Papers Accordion -->
                        <div class="accordion" id="papersAccordion">
                            @foreach($subjects as $registered)
                                @php
                                    $sectionCount = count($registered->test_sections);
                                    $questionCount = $registered->questions();
                                    $isComposed = $sectionCount > 0 && $questionCount > 0;
                                @endphp
                                <div class="accordion-item border mb-2 paper-row">
                                    <!-- Accordion Header -->
                                    <h2 class="accordion-header" id="heading{{ $registered->id }}">
                                        <button class="accordion-button collapsed" type="button" 
                                                data-bs-toggle="collapse" data-bs-target="#collapse{{ $registered->id }}"
                                                aria-expanded="false" aria-controls="collapse{{ $registered->id }}">
                                            <div class="d-flex justify-content-between align-items-center w-100 me-3">
                                                <div class="d-flex align-items-center">
                                                    <span class="badge bg-secondary me-2">{{ $loop->iteration }}</span>
                                                    <div>
                                                        <strong class="text-dark">{{ $registered->subject->subject_code }} - {{ $registered->subject->name }}</strong>
                                                        <br><small class="text-muted">Paper composition and question management</small>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center gap-2">
                                                    <!-- Sections Count -->
                                                    <div class="text-center">
                                                        <small class="text-muted d-block">Sections</small>
                                                        <span class="badge {{ $sectionCount > 0 ? 'bg-primary' : 'bg-light text-dark' }}">
                                                            {{ $sectionCount }}
                                                        </span>
                                                    </div>
                                                    <!-- Questions Count -->
                                                    <div class="text-center">
                                                        <small class="text-muted d-block">Questions</small>
                                                        <span class="badge {{ $questionCount > 0 ? 'bg-info' : 'bg-light text-dark' }}">
                                                            {{ $questionCount }}
                                                        </span>
                                                    </div>
                                                    <!-- Status Icon -->
                                                    @if($isComposed)
                                                        <i class="las la-check-circle text-success fs-5" title="Ready for testing"></i>
                                                    @else
                                                        <i class="las la-clock text-warning fs-5" title="Composition pending"></i>
                                                    @endif
                                                </div>
                                            </div>
                                        </button>
                                    </h2>
                                    
                                    <!-- Accordion Body -->
                                    <div id="collapse{{ $registered->id }}" class="accordion-collapse collapse"
                                         aria-labelledby="heading{{ $registered->id }}" data-bs-parent="#papersAccordion">
                                        <div class="accordion-body">
                                            <div class="row">
                                                <!-- Paper Details -->
                                                <div class="col-md-8">
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 border-l-primary border-3">
                                                            <h6 class="text-primary my-2">
                                                                <i class="las la-book me-1"></i>Paper Information
                                                            </h6>
                                                            <div class="mb-2">
                                                                <strong>Subject Code:</strong> 
                                                                <span class="badge bg-success">{{ $registered->subject->subject_code }}</span>
                                                            </div>
                                                            <div class="mb-2">
                                                                <strong>Subject Name:</strong> 
                                                                <span class="text-muted">{{ $registered->subject->name }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 border-l-primary border-3">
                                                            <h6 class="text-info my-2">
                                                                <i class="las la-chart-bar me-1"></i>Composition Statistics
                                                            </h6>
                                                            <div class="mb-2">
                                                                <strong>Sections Created:</strong>
                                                                <span class="badge {{ $sectionCount > 0 ? 'bg-primary' : 'bg-light text-dark' }}">
                                                                    {{ $sectionCount }}
                                                                </span>
                                                            </div>
                                                            <div class="mb-2">
                                                                <strong>Total Questions:</strong>
                                                                <span class="badge {{ $questionCount > 0 ? 'bg-info' : 'bg-light text-dark' }}">
                                                                    {{ $questionCount }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Sections Overview -->
                                                    @if($sectionCount > 0)
                                                        <div class="mb-3">
                                                            <h6 class="text-success mb-2">
                                                                <i class="las la-layer-group me-1"></i>Sections Overview
                                                            </h6>
                                                            <div class="row">
                                                                @foreach($registered->test_sections as $section)
                                                                    <div class="col-md-12 mb-2">
                                                                        <div class="border rounded p-2">
                                                                            <small class="fw-bold text-dark">{{ $section->title }}</small><br>
                                                                            <small class="text-muted">
                                                                                <i class="las la-question-circle"></i> {{ $section->num_to_answer }} questions
                                                                                <i class="las la-star ms-2"></i> {{ $section->mark_per_question }} pts each
                                                                            </small>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif
                                                    
                                                    <!-- Status Information -->
                                                    <div class="mb-3">
                                                        <h6 class="text-warning mb-2">
                                                            <i class="las la-info-circle me-1"></i>Composition Status
                                                        </h6>
                                                        <div class="d-flex align-items-center">
                                                            @if($isComposed)
                                                                <span class="badge bg-success me-2">
                                                                    <i class="las la-check me-1"></i>Ready for Testing
                                                                </span>
                                                                <small class="text-success">This paper has sections and questions configured and is ready for testing.</small>
                                                            @else
                                                                <span class="badge bg-warning me-2">
                                                                    <i class="las la-clock me-1"></i>Composition Pending
                                                                </span>
                                                                <small class="text-warning">This paper needs sections and questions to be configured before testing.</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Action Buttons -->
                                                <div class="col-md-4">
                                                    <div class="d-grid gap-2">
                                                        <a class="btn btn-success"
                                                           href="{{ route('admin.test.config.composition.compose',[$registered->id]) }}"
                                                           title="Compose sections and questions">
                                                            <i class="las la-edit me-1"></i>Compose Paper
                                                        </a>
                                                        
                                                        @if($sectionCount > 0)
                                                            <button class="btn btn-outline-info" type="button" data-bs-toggle="collapse" 
                                                                    data-bs-target="#sectionsDetail{{ $registered->id }}" aria-expanded="false">
                                                                <i class="las la-eye me-1"></i>View Sections
                                                            </button>
                                                        @endif
                                                    </div>
                                                    
                                                    <!-- Paper Stats Card -->
                                                    <div class="card mt-3">
                                                        <div class="card-body p-3">
                                                            <h6 class="card-title text-muted mb-2">Paper Stats</h6>
                                                            <div class="row text-center">
                                                                <div class="col-6">
                                                                    <div class="text-primary">
                                                                        <i class="las la-layer-group"></i>
                                                                    </div>
                                                                    <small class="text-muted d-block">Sections</small>
                                                                    <strong>{{ $sectionCount }}</strong>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="text-info">
                                                                        <i class="las la-question-circle"></i>
                                                                    </div>
                                                                    <small class="text-muted d-block">Questions</small>
                                                                    <strong>{{ $questionCount }}</strong>
                                                                </div>
                                                            </div>
                                                            <div class="row text-center mt-2">
                                                                <div class="col-12">
                                                                    <div class="{{ $isComposed ? 'text-success' : 'text-warning' }}">
                                                                        <i class="las {{ $isComposed ? 'la-check-circle' : 'la-clock' }}"></i>
                                                                    </div>
                                                                    <small class="text-muted d-block">Status</small>
                                                                    <strong class="{{ $isComposed ? 'text-success' : 'text-warning' }}">
                                                                        {{ $isComposed ? 'Ready' : 'Pending' }}
                                                                    </strong>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Expandable Sections Detail -->
                                            @if($sectionCount > 0)
                                                <div class="collapse" id="sectionsDetail{{ $registered->id }}">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <h6 class="text-secondary mb-3">
                                                                <i class="las la-list-ol me-1"></i>Section Details
                                                            </h6>
                                                            <div class="table-responsive">
                                                                <table class="table table-sm table-bordered">
                                                                    <thead class="table-light">
                                                                        <tr>
                                                                            <th>Section</th>
                                                                            <th class="text-center">Questions</th>
                                                                            <th class="text-center">Points/Question</th>
                                                                            <th class="text-center">Total Points</th>
                                                                            <th class="text-center">Difficulty</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach($registered->test_sections as $section)
                                                                            <tr>
                                                                                <td><strong>{{ $section->title }}</strong></td>
                                                                                <td class="text-center">{{ $section->num_to_answer }}</td>
                                                                                <td class="text-center">{{ $section->mark_per_question }}</td>
                                                                                <td class="text-center">{{ $section->num_to_answer * $section->mark_per_question }}</td>
                                                                                <td class="text-center">
                                                                                    <small>
                                                                                        <span class="badge bg-success badge-sm me-1">E:{{ $section->num_of_easy }}</span>
                                                                                        <span class="badge bg-warning badge-sm me-1">M:{{ $section->num_of_moderate }}</span>
                                                                                        <span class="badge bg-danger badge-sm">H:{{ $section->num_of_difficult }}</span>
                                                                                    </small>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Summary Cards -->
                        <div class="row mt-4">
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-body border-l-primary border-3 text-center py-3">
                                        <h6 class="text-muted mb-1">Total Papers</h6>
                                        <h4 class="mb-0 text-dark">{{ count($subjects) }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-opacity-10">
                                    <div class="card-body border-l-primary border-3 text-center py-3">
                                        <h6 class="text-muted mb-1">Ready Papers</h6>
                                        <h4 class="mb-0 text-success">
                                            {{ $subjects->filter(function($s) { return count($s->test_sections) > 0 && $s->questions() > 0; })->count() }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-opacity-10">
                                    <div class="card-body border-l-primary border-3 text-center py-3">
                                        <h6 class="text-muted mb-1">Pending Papers</h6>
                                        <h4 class="mb-0 text-warning">
                                            {{ $subjects->filter(function($s) { return count($s->test_sections) == 0 || $s->questions() == 0; })->count() }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-opacity-10">
                                    <div class="card-body border-l-primary border-3 text-center py-3">
                                        <h6 class="text-muted mb-1">Total Questions</h6>
                                        <h4 class="mb-0 text-info">{{ $subjects->sum(function($s) { return $s->questions(); }) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="las la-inbox text-muted" style="font-size: 4rem;"></i>
                            </div>
                            <h5 class="text-muted">No Papers Available</h5>
                            <p class="text-muted mb-4">You need to add papers to this test before you can compose them.</p>
                            <a href="{{ route('admin.test.config.subjects', $config->id) }}" class="btn btn-primary">
                                <i class="las la-plus me-2"></i>Add Papers
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Search functionality
            $('#searchPapers').on('input', function() {
                const searchTerm = $(this).val().toLowerCase();
                $('.paper-row').each(function() {
                    const rowText = $(this).text().toLowerCase();
                    if (rowText.includes(searchTerm)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });

                // Show/hide no results message
                const visibleRows = $('.paper-row:visible').length;
                if (visibleRows === 0 && searchTerm !== '') {
                    if ($('#no-results-message').length === 0) {
                        $('#papersAccordion').after(
                            '<div id="no-results-message" class="text-center py-5">' +
                            '<div class="mb-3">' +
                            '<i class="las la-search text-muted" style="font-size: 3rem;"></i>' +
                            '</div>' +
                            '<h5 class="text-muted">No papers found</h5>' +
                            '<p class="text-muted">No papers match "' + searchTerm + '". Try a different search term.</p>' +
                            '</div>'
                        );
                    } else {
                        $('#no-results-message h5').text('No papers found');
                        $('#no-results-message p').text('No papers match "' + searchTerm + '". Try a different search term.');
                    }
                    $('#papersAccordion').hide();
                } else {
                    $('#no-results-message').remove();
                    $('#papersAccordion').show();
                }
            });

            // Clear search on page load
            $('#searchPapers').val('');
        });
    </script>
@endsection
