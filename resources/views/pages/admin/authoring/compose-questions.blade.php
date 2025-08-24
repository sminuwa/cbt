@php
    use Illuminate\Support\Str;
@endphp
@extends('layouts.app')

@section('css')
    <style>
        .list-group.ordered-list {
            counter-reset: list-counter;
        }

        .list-group.ordered-list .list-group-item {
            position: relative;
            padding-left: 25px;
        }

        .list-group.ordered-list .list-group-item::before {
            content: counter(list-counter, upper-alpha) ".  ";
            counter-increment: list-counter;
            position: absolute;
            left: 0em;
            top: 0.5em;
        }

        .question-composition-stats {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 8px;
        }

        .filter-section {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
    </style>
@endsection

@section('content')
    @php
        $subject = $testSection->test_subject->subject;
        $config = $testSection->test_subject->test_config;
    @endphp
    
    <!-- Header Card -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="card-title mb-0">
                        <i class="las la-question-circle me-2"></i>Question Composition
                    </h4>
                    <small class="text-muted">
                        Configure questions for: <strong>{{ $testSection->title }}</strong> - <strong>{{ $subject->subject_code }}</strong>
                    </small>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.test.config.composition.compose', [$testSection->test_subject_id]) }}" class="btn btn-outline-light btn-sm">
                        <i class="las la-arrow-left me-1"></i>Back to Sections
                    </a>
                    <a href="{{ route('admin.test.config.composition', [$testSection->test_subject->test_config_id]) }}" class="btn btn-outline-light btn-sm">
                        <i class="las la-layer-group me-1"></i>Composition
                    </a>
                    <a href="{{ route('admin.test.config.index') }}" class="btn btn-light btn-sm">
                        <i class="las la-home me-1"></i>Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Requirements Card -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="las la-info-circle me-2 text-info"></i>Section Requirements
                    </h5>
                </div>
                <div class="card-body question-composition-stats">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <h6 class="text-primary mb-2">
                                    <i class="las la-clipboard-list me-1"></i>Question Distribution Required
                                </h6>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="text-center p-3 rounded border">
                                            <div class="text-success mb-1">
                                                <i class="las la-circle fs-4"></i>
                                            </div>
                                            <h4 class="text-success mb-1">{{ $testSection->num_of_easy }}</h4>
                                            <small class="text-muted">Easy</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center p-3 rounded border">
                                            <div class="text-warning mb-1">
                                                <i class="las la-circle fs-4"></i>
                                            </div>
                                            <h4 class="text-warning mb-1">{{ $testSection->num_of_moderate }}</h4>
                                            <small class="text-muted">Moderate</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center p-3 rounded border">
                                            <div class="text-danger mb-1">
                                                <i class="las la-circle fs-4"></i>
                                            </div>
                                            <h4 class="text-danger mb-1">{{ $testSection->num_of_difficult }}</h4>
                                            <small class="text-muted">Hard</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center p-3 rounded border border-primary">
                                            <div class="text-primary mb-1">
                                                <i class="las la-calculator fs-4"></i>
                                            </div>
                                            <h4 class="text-primary mb-1">{{ $testSection->num_to_answer }}</h4>
                                            <small class="text-muted">Total Questions</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="alert alert-info mb-0">
                                <i class="las la-lightbulb me-1"></i>
                                <strong>Instructions:</strong> Select questions from the question bank below to meet the exact requirement distribution. 
                                Each question selected will be added to this test section based on its difficulty level.
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body p-3">
                                    <h6 class="card-title text-muted mb-3">Section Details</h6>
                                    <div class="mb-2">
                                        <strong>Section Title:</strong> 
                                        <span class="text-primary">{{ $testSection->title }}</span>
                                    </div>
                                    <div class="mb-2">
                                        <strong>Points per Question:</strong> 
                                        <span class="badge bg-warning text-dark">{{ $testSection->mark_per_question }}</span>
                                    </div>
                                    <div class="mb-2">
                                        <strong>Total Marks:</strong> 
                                        <span class="badge bg-success">{{ $testSection->num_to_answer * $testSection->mark_per_question }}</span>
                                    </div>
                                    <div class="mb-2">
                                        <strong>Subject:</strong> 
                                        <span class="badge bg-info">{{ $subject->subject_code }}</span>
                                    </div>
                                    @php
                                        $currentQuestions = $testSection->test_questions->count();
                                        $totalRequired = $testSection->num_to_answer;
                                        $progressPercentage = $totalRequired > 0 ? round(($currentQuestions / $totalRequired) * 100) : 0;
                                        $isComplete = $currentQuestions >= $totalRequired;
                                    @endphp
                                    <div class="mb-3">
                                        <strong>Questions Progress:</strong> 
                                        <div class="d-flex align-items-center mt-1">
                                            <div class="flex-grow-1 me-2">
                                                <div class="progress" style="height: 6px;">
                                                    <div class="progress-bar {{ $isComplete ? 'bg-success' : ($currentQuestions > 0 ? 'bg-info' : 'bg-light') }}" 
                                                         role="progressbar" 
                                                         style="width: {{ min($progressPercentage, 100) }}%"
                                                         aria-valuenow="{{ $progressPercentage }}" 
                                                         aria-valuemin="0" 
                                                         aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </div>
                                            <small class="text-nowrap {{ $isComplete ? 'text-success' : ($currentQuestions > 0 ? 'text-info' : 'text-muted') }}">
                                                <strong>{{ $currentQuestions }}/{{ $totalRequired }}</strong>
                                            </small>
                                        </div>
                                        <small class="text-muted mt-1 d-block">
                                            @if($isComplete)
                                                <i class="las la-check-circle text-success"></i> Section complete
                                            @elseif($currentQuestions > 0)
                                                <i class="las la-clock text-info"></i> {{ $totalRequired - $currentQuestions }} more needed
                                            @else
                                                <i class="las la-plus-circle text-muted"></i> No questions added yet
                                            @endif
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Controls Bar -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">
                                <i class="las la-database me-2 text-primary"></i>Question Bank
                            </h6>
                            <small class="text-muted">Browse and select questions from the available question bank</small>
                        </div>
                        <div class="d-flex gap-2 align-items-center">
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#filtersModal">
                                <i class="las la-filter me-1"></i>Filters & Search
                            </button>
                        </div>


                    </div>

                    <!-- Questions Display Area -->
                    <div id="questions-div" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden Form for Question Loading -->
    <form id="load-form" method="post" style="display: none;">
        @csrf
        <input type="hidden" name="subject_id" value="{{ $subject->id }}">
        <input type="hidden" name="test_section_id" value="{{ $testSection->id }}">
        <input type="hidden" name="test_subject_id" value="{{ $testSection->test_subject_id }}">
        <input type="hidden" id="page" name="page" value="1">
        <input type="hidden" id="form_difficulty_level" name="difficulty_level" value="%">
        <input type="hidden" id="form_topic_id" name="topic_id" value="%">
        <input type="hidden" id="form_author" name="author" value="%">
        <input type="hidden" id="form_phrase" name="phrase" value="">
        <input type="hidden" id="form_page_count" name="page_count" value="20">
        <input type="hidden" id="form_browse_mode" name="browse_mode" value="false">
    </form>

    

    <!-- Filters Modal -->
    <div class="modal fade" id="filtersModal" tabindex="-1" aria-labelledby="filtersModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filtersModalLabel">
                        <i class="las la-filter me-2"></i>Question Bank Filters & Search
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-4">
                        <div class="alert alert-info">
                            <i class="las la-info-circle me-1"></i>
                            <strong>Filter Instructions:</strong> Use the filters below to narrow down questions from the question bank. 
                            Leave fields as "All" to include all options for that filter.
                        </div>
                    </div>
                    
                    <form id="modal-filter-form">
                        <!-- View Mode Filter -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="modal_view_mode" class="form-label">
                                    <i class="las la-eye text-primary me-1"></i>View Mode
                                </label>
                                <select class="form-select" id="modal_view_mode">
                                    <option value="composed">Composed Questions</option>
                                    <option value="browse">Browse Question Bank</option>
                                </select>
                                <div class="form-text">Choose between viewing composed questions or browsing question bank</div>
                            </div>
                        </div>

                        <!-- Primary Filters -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label for="modal_difficulty" class="form-label">
                                    <i class="las la-layer-group text-info me-1"></i>Difficulty Level
                                </label>
                                <select class="form-select" id="modal_difficulty">
                                    <option value="%">All Levels</option>
                                    <option value="simple">Easy Questions</option>
                                    <option value="moderate">Moderate Questions</option>
                                    <option value="difficult">Hard Questions</option>
                                </select>
                                <div class="form-text">Filter by question difficulty</div>
                            </div>
                            <div class="col-md-4">
                                <label for="modal_topic" class="form-label">
                                    <i class="las la-tags text-success me-1"></i>Topic
                                </label>
                                <select class="form-select" id="modal_topic">
                                    <option value="%">All Topics</option>
                                    @foreach($topics as $topic)
                                        <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                                    @endforeach
                                </select>
                                <div class="form-text">Filter by subject topic</div>
                            </div>
                            <div class="col-md-4">
                                <label for="modal_author" class="form-label">
                                    <i class="las la-user text-warning me-1"></i>Author
                                </label>
                                <select class="form-select" id="modal_author">
                                    <option value="%">All Authors</option>
                                    <option value="me">My Questions Only</option>
                                    <option value="others">Other Authors Only</option>
                                </select>
                                <div class="form-text">Filter by question author</div>
                            </div>
                        </div>
                        
                        <!-- Search and Display Options -->
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <label for="modal_phrase" class="form-label">
                                    <i class="las la-search text-primary me-1"></i>Search Text
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="las la-search"></i>
                                    </span>
                                    <input class="form-control" type="text" id="modal_phrase"
                                           placeholder="Search in question text, keywords, or content...">
                                </div>
                                <div class="form-text">Search within question content and text</div>
                            </div>
                            <div class="col-md-4">
                                <label for="modal_page_count" class="form-label">
                                    <i class="las la-list text-secondary me-1"></i>Questions Per Page
                                </label>
                                <select class="form-select" id="modal_page_count">
                                    <option value="5">5 per page</option>
                                    <option value="10">10 per page</option>
                                    <option value="15">15 per page</option>
                                    <option value="20" selected>20 per page</option>
                                    <option value="25">25 per page</option>
                                    <option value="30">30 per page</option>
                                    <option value="35">35 per page</option>
                                    <option value="40">40 per page</option>
                                    <option value="45">45 per page</option>
                                    <option value="50">50 per page</option>
                                    <option value="100">100 per page</option>
                                </select>
                                <div class="form-text">Number of questions to display</div>
                            </div>
                        </div>
                        
                        <!-- Filter Summary -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card bg-light">
                                    <div class="card-body py-3">
                                        <h6 class="text-muted mb-2">
                                            <i class="las la-eye me-1"></i>Current Filter Summary
                                        </h6>
                                        <div id="filter-summary">
                                            <span class="badge bg-secondary">All Questions</span>
                                        </div>
                                        <small class="text-muted mt-2 d-block">
                                            This summary shows your current filter selection
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <div>
                            <button type="button" class="btn btn-outline-secondary" id="clear-filters">
                                <i class="las la-undo me-1"></i>Clear All Filters
                            </button>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="las la-times me-1"></i>Cancel
                            </button>
                            <button type="button" class="btn btn-primary" id="apply-filters">
                                <i class="las la-check me-1"></i>Apply Filters & Load
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function () {
            let page = $('#page')
            let form = $('#load-form')
            let q_form

            // Auto-load questions on page load
            $(document).ready(function() {
                loadQuestions();
                updateFilterSummary();
            });


            // Modal filter functionality
            $('#apply-filters').on('click', function() {
                applyFilters();
                $('#filtersModal').modal('hide');
                loadQuestions();
            });


            $('#clear-filters').on('click', function() {
                clearAllFilters();
            });

            // Update filter summary when modal inputs change
            $('#modal_view_mode, #modal_difficulty, #modal_topic, #modal_author, #modal_phrase, #modal_page_count').on('change input', function() {
                updateFilterSummary();
            });

            function applyFilters() {
                // Handle view mode selection
                const selectedViewMode = $('#modal_view_mode').val();
                const isBrowseMode = selectedViewMode === 'browse';
                $('#form_browse_mode').val(isBrowseMode ? 'true' : 'false');
                
                // Update hidden form fields with modal values
                $('#form_difficulty_level').val($('#modal_difficulty').val());
                $('#form_topic_id').val($('#modal_topic').val());
                $('#form_author').val($('#modal_author').val());
                $('#form_phrase').val($('#modal_phrase').val());
                $('#form_page_count').val($('#modal_page_count').val());
                
                // Reset page to 1 when applying new filters
                $('#page').val('1');
                
                showNotification('info', 'Filters applied successfully. Loading questions...');
            }

            function clearAllFilters() {
                // Reset modal form
                $('#modal_view_mode').val('composed');
                $('#modal_difficulty').val('%');
                $('#modal_topic').val('%');
                $('#modal_author').val('%');
                $('#modal_phrase').val('');
                $('#modal_page_count').val('20');
                
                // Update filter summary
                updateFilterSummary();
                
                showNotification('info', 'All filters have been cleared.');
            }

            function updateFilterSummary() {
                let summary = [];
                
                const viewMode = $('#modal_view_mode').val();
                const difficulty = $('#modal_difficulty').val();
                const topic = $('#modal_topic option:selected').text();
                const author = $('#modal_author option:selected').text();
                const phrase = $('#modal_phrase').val();
                const pageCount = $('#modal_page_count').val();
                
                // Add view mode badge
                const viewModeText = viewMode === 'composed' ? 'Composed Questions' : 'Browse Question Bank';
                const viewModeBadgeClass = viewMode === 'composed' ? 'bg-success' : 'bg-primary';
                summary.push(`<span class="badge ${viewModeBadgeClass}">${viewModeText}</span>`);
                
                if (difficulty !== '%') {
                    const diffText = difficulty === 'simple' ? 'Easy' : 
                                   (difficulty === 'moderate' ? 'Moderate' : 'Hard');
                    summary.push(`<span class="badge bg-info">${diffText} Questions</span>`);
                }
                
                if ($('#modal_topic').val() !== '%') {
                    summary.push(`<span class="badge bg-success">Topic: ${topic}</span>`);
                }
                
                if ($('#modal_author').val() !== '%') {
                    summary.push(`<span class="badge bg-warning text-dark">Author: ${author}</span>`);
                }
                
                if (phrase.trim() !== '') {
                    summary.push(`<span class="badge bg-primary">Search: "${phrase.substring(0, 20)}${phrase.length > 20 ? '...' : ''}"</span>`);
                }
                
                summary.push(`<span class="badge bg-secondary">${pageCount} per page</span>`);
                
                $('#filter-summary').html(summary.join(' '));
            }

            function loadQuestions() {
                // Show loading state
                $('#questions-div').html(`
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-3 text-muted">Loading questions from the question bank...</p>
                        </div>
                    </div>
                `);
                
                $.get('{{route('admin.test.config.compose.questions.load')}}', form.serialize(), function (response) {
                    $('#questions-div').html(response)
                    $(document).find('#section_id').val({{$testSection->id}})
                    q_form = $(document).find('#questions-form')
                }).fail(function() {
                    $('#questions-div').html(`
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <div class="text-danger mb-3">
                                    <i class="las la-exclamation-triangle" style="font-size: 3rem;"></i>
                                </div>
                                <h5 class="text-danger">Error Loading Questions</h5>
                                <p class="text-muted">There was an error loading questions. Please try again.</p>
                                <button class="btn btn-primary" onclick="loadQuestions()">Retry</button>
                            </div>
                        </div>
                    `);
                });
            }

            function store() {
                $.post('{{route('admin.test.config.compose.questions.store')}}', q_form.serialize(), function (data) {
                }).done(function (data) {
                    console.log(data)
                    if (data.message !== '') {
                        // Show a more user-friendly notification
                        if (data.message.includes('success') || data.message.includes('added')) {
                            showNotification('success', data.message);
                        } else {
                            showNotification('warning', data.message);
                        }
                    }
                }).fail(function() {
                    showNotification('error', 'Error saving question selection. Please try again.');
                })
            }
            
            // Simple notification function
            function showNotification(type, message) {
                const alertClass = type === 'success' ? 'alert-success' : (type === 'warning' ? 'alert-warning' : 'alert-danger');
                const notification = `
                    <div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
                         style="top: 20px; right: 20px; z-index: 9999; max-width: 400px;" role="alert">
                        <i class="las la-${type === 'success' ? 'check-circle' : (type === 'warning' ? 'exclamation-triangle' : 'times-circle')} me-1"></i>
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                $('body').append(notification);
                
                // Auto-dismiss after 5 seconds
                setTimeout(function() {
                    $('.alert-dismissible').fadeOut(500, function() { $(this).remove(); });
                }, 5000);
            }

            form.on('submit', function (e) {
                e.preventDefault()
                loadQuestions()
            })

            $(document).on('click', '#select-all', function () {
                let checked = $(this).is(':checked')
                $('.selection').prop('checked', checked);

                if (checked)
                    store()
                else {

                }
            })

            $(document).on('click', '.selection', function () {
                let checked = $(this).is(':checked')
                if (checked)
                    store()
                else {
                    $.get('{{route('admin.test.config.compose.questions.remove',[$testSection->id,':id'])}}'.replace(':id', $(this).val()), function () {
                    })
                }
            })

            $(document).on('click', '.full-question', function () {
                let options = $(document).find('#options-' + $(this).data('id'))
                if (options.is(':visible')) {
                    options.slideUp(300)
                    $(this).html('<i class="las la-eye me-1"></i>Show Options')
                } else {
                    options.slideDown(300)
                    $(this).html('<i class="las la-eye-slash me-1"></i>Hide Options')
                }
            })

            $(document).on('click', '#previous', function () {
                let index = parseInt(page.val()) - 1
                page.val(index)
                loadQuestions()
            })

            $(document).on('click', '#next', function () {
                let index = parseInt(page.val()) + 1
                page.val(index)
                loadQuestions()
            })
            
            // Make loadQuestions globally accessible
            window.loadQuestions = loadQuestions;
        })
    </script>
@endsection
