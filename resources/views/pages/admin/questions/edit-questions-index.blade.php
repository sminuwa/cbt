@php use App\Models\Subject; @endphp
@extends('layouts.app')

@section('css')
@endsection

@section('content')
<div class="container-fluid">
    <!-- Loading -->
    <div id="loading" style="display: none;">Loading...</div>

    <!-- Header -->
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2">
                        <i class="las la-edit me-2"></i>
                        Question Management Center
                    </h2>
                    <p class="mb-0 text-muted">Efficiently manage, edit, and organize your question bank</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <button type="button" class="btn btn-outline-primary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#filters-modal">
                        <i class="las la-filter me-2"></i>
                        Filters
                    </button>
                    <button type="button" class="btn btn-primary btn-sm" id="bulk-mode-toggle">
                        <i class="las la-tasks me-2"></i>
                        Bulk
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Row -->
    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="card text-center">
                <div class="card-body">
                    <div class="display-6 text-primary fw-bold" id="total-questions">0</div>
                    <div class="text-muted small text-uppercase">Total Questions</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card text-center">
                <div class="card-body">
                    <div class="display-6 text-success fw-bold" id="simple-count">0</div>
                    <div class="text-muted small text-uppercase">Simple</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card text-center">
                <div class="card-body">
                    <div class="display-6 text-warning fw-bold" id="moderate-count">0</div>
                    <div class="text-muted small text-uppercase">Moderate</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card text-center">
                <div class="card-body">
                    <div class="display-6 text-danger fw-bold" id="difficult-count">0</div>
                    <div class="text-muted small text-uppercase">Difficult</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Search and Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-3">
                    <div class="position-relative">
                        <i class="las la-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        <input type="text" class="form-control ps-5" id="search-input" 
                               placeholder="Search by question text, options, or ID..." autocomplete="off">
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="d-flex gap-2 flex-wrap justify-content-end">
                        <button type="button" class="btn btn-primary btn-sm active" data-filter="all">
                            All Questions
                        </button>
                        <button type="button" class="btn btn-outline-success btn-sm" data-filter="simple">
                            Simple
                        </button>
                        <button type="button" class="btn btn-outline-warning btn-sm" data-filter="moderate">
                            Moderate
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-sm" data-filter="difficult">
                            Difficult
                        </button>
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="las la-download me-1"></i>
                                Export
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" id="export-csv">
                                    <i class="las la-file-csv me-2"></i>
                                    Export as CSV
                                </a></li>
                                <li><a class="dropdown-item" href="#" id="export-docx">
                                    <i class="las la-file-word me-2"></i>
                                    Export as DOCX
                                </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden form for advanced filters -->
    <form id="filter-form" style="display: none;">
        @csrf
        <input type="hidden" name="subject_id" id="subject_id" value="">
        <input type="hidden" name="topic_id" id="topic_id" value="">
        <input type="hidden" name="difficulty_level" id="difficulty_level" value="">
        <input type="hidden" name="status" id="status" value="">
        <input type="hidden" name="sort_by" id="sort_by" value="created_at">
        <input type="hidden" name="sort_direction" id="sort_direction" value="desc">
        <input type="hidden" name="per_page" id="per_page" value="25">
    </form>

    <!-- Bulk Actions Bar (Hidden by default) -->
    <div id="bulk-actions" class="alert alert-warning d-none mb-4">
        <div class="row align-items-center">
            <div class="col-md-3">
                <span class="fw-bold">
                    <span id="selected-count">0</span> questions selected
                </span>
            </div>
            <div class="col-md-9">
                <div class="d-flex gap-2 justify-content-end">
                    <button type="button" class="btn btn-primary btn-sm" id="bulk-edit">
                        <i class="las la-edit me-1"></i>
                        Edit Selected
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm" id="bulk-duplicate">
                        <i class="las la-copy me-1"></i>
                        Duplicate
                    </button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="las la-download me-1"></i>
                            Export
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" id="bulk-export-csv">
                                <i class="las la-file-csv me-2"></i>
                                Export as CSV
                            </a></li>
                            <li><a class="dropdown-item" href="#" id="bulk-export-docx">
                                <i class="las la-file-word me-2"></i>
                                Export as DOCX
                            </a></li>
                        </ul>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm" id="bulk-delete">
                        <i class="las la-trash me-1"></i>
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Questions Container -->
    <div id="questions-container">
        <!-- Questions will be loaded here -->
    </div>

    <!-- Pagination -->
    <div id="pagination-container" class="d-flex justify-content-center mt-4">
        <!-- Pagination will be loaded here -->
    </div>
</div>

<!-- Edit Question Modal -->
<div class="modal fade" id="edit-question-modal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="las la-edit me-2"></i>
                    Edit Question
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Edit form will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Bulk Edit Modal -->
<div class="modal fade" id="bulk-edit-modal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="las la-edit me-2"></i>
                    Bulk Edit Questions
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="bulk-edit-form">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Change Subject</label>
                            <select class="form-select" name="bulk_subject_id">
                                <option value="">Don't Change</option>
                                @foreach(Subject::all() as $subject)
                                    <option value="{{$subject->id}}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Change Difficulty</label>
                            <select class="form-select" name="bulk_difficulty">
                                <option value="">Don't Change</option>
                                <option value="simple">Simple</option>
                                <option value="moderate">Moderate</option>
                                <option value="difficult">Difficult</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label class="form-label">Change Status</label>
                            <select class="form-select" name="bulk_status">
                                <option value="">Don't Change</option>
                                <option value="true">Active</option>
                                <option value="false">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Change Topic</label>
                            <select class="form-select" name="bulk_topic_id">
                                <option value="">Don't Change</option>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="selected_questions" id="selected_questions">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="save-bulk-changes">
                    <i class="las la-save me-2"></i>
                    Save Changes
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Advanced Filters Modal -->
<div class="modal fade" id="filters-modal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="las la-filter me-2"></i>
                    Advanced Filters & Search
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="modal-filter-form">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Subject (Paper)</label>
                            <select class="form-select" name="modal_subject_id" id="modal_subject_id">
                                <option value="">All Subjects</option>
                                @foreach(Subject::all() as $subject)
                                    <option value="{{$subject->id}}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Topic</label>
                            <select class="form-select" name="modal_topic_id" id="modal_topic_id">
                                <option value="">All Topics</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Difficulty Level</label>
                            <select class="form-select" name="modal_difficulty_level" id="modal_difficulty_level">
                                <option value="">All Levels</option>
                                <option value="simple">Simple</option>
                                <option value="moderate">Moderate</option>
                                <option value="difficult">Difficult</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Status</label>
                            <select class="form-select" name="modal_status" id="modal_status">
                                <option value="">All Status</option>
                                <option value="true">Active</option>
                                <option value="false">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Sort By</label>
                            <select class="form-select" id="modal_sort_by">
                                <option value="created_at">Date Created</option>
                                <option value="updated_at">Date Modified</option>
                                <option value="difficulty_level">Difficulty</option>
                                <option value="subject_id">Subject</option>
                                <option value="title">Question Text</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Sort Direction</label>
                            <select class="form-select" id="modal_sort_direction">
                                <option value="desc">Descending</option>
                                <option value="asc">Ascending</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Questions Per Page</label>
                            <select class="form-select" id="modal_per_page">
                                <option value="10">10 questions</option>
                                <option value="25" selected>25 questions</option>
                                <option value="50">50 questions</option>
                                <option value="100">100 questions</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" id="reset-modal-filters">
                    <i class="las la-undo me-2"></i>
                    Reset All
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="apply-modal-filters">
                    <i class="las la-search me-2"></i>
                    Apply Filters
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<x-head.tinymce-config/>
<script>
$(document).ready(function() {
    let currentPage = 1;
    let selectedQuestions = new Set();
    let bulkMode = false;

    // Initialize interface
    loadQuestions();
    
    // Modal subject change handler
    $('#modal_subject_id').on('change', function() {
        let id = $(this).val();
        if (id) {
            loadTopicsForModal(id);
        } else {
            $('#modal_topic_id').html('<option value="">All Topics</option>');
        }
    });

    // Apply modal filters
    $('#apply-modal-filters').on('click', function() {
        // Copy modal values to hidden form
        $('#subject_id').val($('#modal_subject_id').val());
        $('#topic_id').val($('#modal_topic_id').val());
        $('#difficulty_level').val($('#modal_difficulty_level').val());
        $('#status').val($('#modal_status').val());
        $('#sort_by').val($('#modal_sort_by').val());
        $('#sort_direction').val($('#modal_sort_direction').val());
        $('#per_page').val($('#modal_per_page').val());
        
        // Close modal and reload questions
        $('#filters-modal').modal('hide');
        currentPage = 1;
        loadQuestions();
    });

    // Reset modal filters
    $('#reset-modal-filters').on('click', function() {
        resetAllFilters();
    });

    // Load current filter values when modal opens
    $('#filters-modal').on('show.bs.modal', function() {
        // Sync modal fields with current filter values
        $('#modal_subject_id').val($('#subject_id').val());
        $('#modal_topic_id').val($('#topic_id').val());
        $('#modal_difficulty_level').val($('#difficulty_level').val());
        $('#modal_status').val($('#status').val());
        $('#modal_sort_by').val($('#sort_by').val());
        $('#modal_sort_direction').val($('#sort_direction').val());
        $('#modal_per_page').val($('#per_page').val());
        
        // Load topics if subject is selected
        if ($('#subject_id').val()) {
            loadTopicsForModal($('#subject_id').val());
        }
    });

    // Quick filter buttons
    $('button[data-filter]').on('click', function() {
        $('button[data-filter]').removeClass('btn-primary btn-success btn-warning btn-danger').addClass('btn-outline-success btn-outline-warning btn-outline-danger btn-outline-primary');
        $('button[data-filter="all"]').removeClass('btn-outline-primary').addClass('btn-outline-primary');
        $('button[data-filter="simple"]').removeClass('btn-outline-success').addClass('btn-outline-success');
        $('button[data-filter="moderate"]').removeClass('btn-outline-warning').addClass('btn-outline-warning');
        $('button[data-filter="difficult"]').removeClass('btn-outline-danger').addClass('btn-outline-danger');
        
        const filter = $(this).data('filter');
        if (filter === 'all') {
            $(this).removeClass('btn-outline-primary').addClass('btn-primary');
            $('#difficulty_level').val('');
        } else if (filter === 'simple') {
            $(this).removeClass('btn-outline-success').addClass('btn-success');
            $('#difficulty_level').val(filter);
        } else if (filter === 'moderate') {
            $(this).removeClass('btn-outline-warning').addClass('btn-warning');
            $('#difficulty_level').val(filter);
        } else if (filter === 'difficult') {
            $(this).removeClass('btn-outline-danger').addClass('btn-danger');
            $('#difficulty_level').val(filter);
        }
        
        currentPage = 1;
        loadQuestions();
    });

    // Real-time search
    let searchTimeout;
    $('#search-input').on('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            currentPage = 1;
            loadQuestions();
        }, 500);
    });

    // Reset filters function (called from various places)
    function resetAllFilters() {
        // Reset search
        $('#search-input').val('');
        
        // Reset quick filters
        $('button[data-filter]').removeClass('btn-primary btn-success btn-warning btn-danger').addClass('btn-outline-success btn-outline-warning btn-outline-danger btn-outline-primary');
        $('button[data-filter="all"]').removeClass('btn-outline-primary').addClass('btn-primary');
        
        // Reset hidden form
        $('#subject_id').val('');
        $('#topic_id').val('');
        $('#difficulty_level').val('');
        $('#status').val('');
        $('#sort_by').val('created_at');
        $('#sort_direction').val('desc');
        $('#per_page').val('25');
        
        // Reset modal form
        $('#modal-filter-form')[0].reset();
        $('#modal_topic_id').html('<option value="">All Topics</option>');
        $('#modal_per_page').val('25');
        $('#modal_sort_by').val('created_at');
        $('#modal_sort_direction').val('desc');
        
        currentPage = 1;
        loadQuestions();
    }

    // Bulk mode toggle
    $('#bulk-mode-toggle').on('click', function() {
        bulkMode = !bulkMode;
        if (bulkMode) {
            $(this).removeClass('btn-primary').addClass('btn-warning');
            $(this).html('<i class="las la-times me-2"></i>Exit Bulk Mode');
            $('#bulk-actions').removeClass('d-none');
        } else {
            $(this).removeClass('btn-warning').addClass('btn-primary');
            $(this).html('<i class="las la-tasks me-2"></i>Bulk');
            $('#bulk-actions').addClass('d-none');
            selectedQuestions.clear();
            updateBulkSelection();
        }
        loadQuestions();
    });

    // Functions
    function showLoading() {
        $('#loading').show();
    }

    function hideLoading() {
        $('#loading').hide();
    }

    function loadTopics(subjectId) {
        $.get('{{ route('admin.authoring.topics', ':id') }}'.replace(':id', subjectId))
            .done(function(data) {
                $('#topic_id').html('<option value="">All Topics</option>' + data);
            })
            .fail(function() {
                showNotification('Error loading topics', 'error');
            });
    }

    function loadTopicsForModal(subjectId) {
        $.get('{{ route('admin.authoring.topics', ':id') }}'.replace(':id', subjectId))
            .done(function(data) {
                $('#modal_topic_id').html('<option value="">All Topics</option>' + data);
            })
            .fail(function() {
                showNotification('Error loading topics', 'error');
            });
    }

    function loadQuestions() {
        showLoading();
        
        const formData = $('#filter-form').serialize() + 
                        '&search=' + encodeURIComponent($('#search-input').val()) +
                        '&page=' + currentPage +
                        '&bulk_mode=' + (bulkMode ? 1 : 0);


        $.post('{{ route('admin.authoring.load.questions.improved') }}', formData)
            .done(function(response) {
                $('#questions-container').html(response.html);
                $('#pagination-container').html(response.pagination);
                updateStatistics(response.stats);
                bindQuestionEvents();
                hideLoading();
            })
            .fail(function(xhr) {
                console.error('Error loading questions:', xhr);
                $('#questions-container').html('<div class="empty-state"><i class="las la-exclamation-triangle"></i><h4>Error Loading Questions</h4><p>Please try again later.</p></div>');
                hideLoading();
            });
    }

    function updateStatistics(stats) {
        $('#total-questions').text(stats.total || 0);
        $('#simple-count').text(stats.simple || 0);
        $('#moderate-count').text(stats.moderate || 0);
        $('#difficult-count').text(stats.difficult || 0);
    }

    function bindQuestionEvents() {
        // Question selection for bulk operations
        $('.question-checkbox').on('change', function() {
            const questionId = $(this).val();
            if ($(this).is(':checked')) {
                selectedQuestions.add(questionId);
            } else {
                selectedQuestions.delete(questionId);
            }
            updateBulkSelection();
        });

        // Select all checkbox
        $('#select-all').on('change', function() {
            const isChecked = $(this).is(':checked');
            $('.question-checkbox').prop('checked', isChecked);
            
            selectedQuestions.clear();
            if (isChecked) {
                $('.question-checkbox').each(function() {
                    selectedQuestions.add($(this).val());
                });
            }
            updateBulkSelection();
        });

        // Expand/collapse question content
        $('.expand-btn').on('click', function() {
            const content = $(this).siblings('.question-content');
            const isExpanded = content.hasClass('expanded');
            
            if (isExpanded) {
                content.removeClass('expanded');
                $(this).text('Show More');
            } else {
                content.addClass('expanded');
                $(this).text('Show Less');
            }
        });

        // Edit single question
        $('.edit-question').on('click', function() {
            const questionId = $(this).data('question-id');
            editQuestion(questionId);
        });

        // Delete single question
        $('.delete-question').on('click', function() {
            const questionId = $(this).data('question-id');
            deleteQuestion(questionId);
        });

        // Pagination
        $('.pagination-link').on('click', function(e) {
            e.preventDefault();
            currentPage = $(this).data('page');
            loadQuestions();
        });
    }

    function updateBulkSelection() {
        $('#selected-count').text(selectedQuestions.size);
        $('#selected_questions').val(Array.from(selectedQuestions).join(','));
    }

    function editQuestion(questionId) {
        showLoading();
        $.get('{{ route('admin.authoring.get.question', ':id') }}'.replace(':id', questionId))
            .done(function(response) {
                $('#edit-question-modal .modal-body').html(response);
                $('#edit-question-modal').modal('show');
                hideLoading();
                
                // Initialize TinyMCE for modal
                setTimeout(() => {
                    if (typeof tinymce !== 'undefined') {
                        tinymce.init({
                            selector: '#edit-question-modal .editor',
                            height: 250,
                            license_key: 'gpl',
                            plugins: 'code table lists',
                            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table',
                            promotion: false,
                            branding: false
                        });
                    }
                }, 100);
            })
            .fail(function() {
                hideLoading();
                showNotification('Error loading question details', 'error');
            });
    }

    function deleteQuestion(questionId) {
        if (!confirm('Are you sure you want to delete this question? This action cannot be undone.')) {
            return;
        }

        showLoading();
        $.post('{{ route('admin.authoring.delete.question') }}', {
            _token: '{{ csrf_token() }}',
            question_id: questionId
        })
        .done(function(response) {
            if (response.success) {
                showNotification('Question deleted successfully', 'success');
                loadQuestions();
            } else {
                showNotification(response.message || 'Error deleting question', 'error');
            }
            hideLoading();
        })
        .fail(function() {
            hideLoading();
            showNotification('Error deleting question', 'error');
        });
    }

    function showNotification(message, type = 'info') {
        // Simple notification system - you can integrate with your preferred notification library
        const alertClass = type === 'success' ? 'alert-success' : 
                          type === 'error' ? 'alert-danger' : 'alert-info';
        
        const notification = $(`
            <div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
                 style="top: 20px; right: 20px; z-index: 10000; min-width: 300px;">
                <strong>${message}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);
        
        $('body').append(notification);
        
        setTimeout(() => {
            notification.alert('close');
        }, 5000);
    }

    // Bulk operations
    $('#bulk-edit').on('click', function() {
        if (selectedQuestions.size === 0) {
            showNotification('Please select questions to edit', 'warning');
            return;
        }
        $('#bulk-edit-modal').modal('show');
    });

    $('#save-bulk-changes').on('click', function() {
        showLoading();
        $.post('{{ route('admin.authoring.bulk.edit') }}', $('#bulk-edit-form').serialize())
            .done(function(response) {
                if (response.success) {
                    showNotification(`Successfully updated ${response.updated} questions`, 'success');
                    $('#bulk-edit-modal').modal('hide');
                    loadQuestions();
                } else {
                    showNotification(response.message || 'Error updating questions', 'error');
                }
                hideLoading();
            })
            .fail(function() {
                hideLoading();
                showNotification('Error updating questions', 'error');
            });
    });

    $('#bulk-delete').on('click', function() {
        if (selectedQuestions.size === 0) {
            showNotification('Please select questions to delete', 'warning');
            return;
        }

        if (!confirm(`Are you sure you want to delete ${selectedQuestions.size} questions? This action cannot be undone.`)) {
            return;
        }

        showLoading();
        $.post('{{ route('admin.authoring.bulk.delete') }}', {
            _token: '{{ csrf_token() }}',
            question_ids: Array.from(selectedQuestions)
        })
        .done(function(response) {
            if (response.success) {
                showNotification(`Successfully deleted ${response.deleted} questions`, 'success');
                selectedQuestions.clear();
                updateBulkSelection();
                loadQuestions();
            } else {
                showNotification(response.message || 'Error deleting questions', 'error');
            }
            hideLoading();
        })
        .fail(function() {
            hideLoading();
            showNotification('Error deleting questions', 'error');
        });
    });

    // Export functionality
    function handleExport(format, isSelected = false) {
        let exportData = $('#filter-form').serialize();
        
        if (isSelected && selectedQuestions.size > 0) {
            exportData += '&selected_only=1&selected_questions=' + Array.from(selectedQuestions).join(',');
        }
        
        const baseUrl = format === 'docx' ? 
            '{{ route('admin.authoring.export.questions.docx') }}' : 
            '{{ route('admin.authoring.export.questions') }}';
            
        window.open(baseUrl + '?' + exportData, '_blank');
    }
    
    // CSV Export handlers
    $('#export-csv').on('click', function(e) {
        e.preventDefault();
        handleExport('csv', false);
    });
    
    $('#bulk-export-csv').on('click', function(e) {
        e.preventDefault();
        if (selectedQuestions.size === 0) {
            showNotification('Please select questions to export', 'warning');
            return;
        }
        handleExport('csv', true);
    });
    
    // DOCX Export handlers
    $('#export-docx').on('click', function(e) {
        e.preventDefault();
        handleExport('docx', false);
    });
    
    $('#bulk-export-docx').on('click', function(e) {
        e.preventDefault();
        if (selectedQuestions.size === 0) {
            showNotification('Please select questions to export', 'warning');
            return;
        }
        handleExport('docx', true);
    });
});
</script>
@endsection