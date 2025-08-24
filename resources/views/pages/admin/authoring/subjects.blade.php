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

    <!-- Test Information Header -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title d-flex justify-content-between">
                        <span>Test Papers</span>
                        <a href="{{ route('admin.test.config.index') }}" class="btn btn-info btn-xs text-light">
                            <i class="las la-arrow-left"></i> Back
                        </a>
                    </h4>
                </div>
                <div class="card-body text-center">
                    <h5 class="text-muted">Manage Test Papers</h5>
                    <h4 class="test-title">{{ $config->title }} - {{ $config->session }} - {{ $config->test_code->name ?? 'No Code' }} - {{ $config->test_type->name ?? 'No Type' }}</h4>
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
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Available Papers Section -->
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="p-3">
                    <h5 class="mb-0">
                        <i class="las la-book-open me-2"></i>
                        Available Papers
                    </h5>
                    <small>Select papers to add to your test</small>
                </div>
                <div class="card-body">
                    <div class="search-container mb-3">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="las la-search"></i>
                            </span>
                            <input type="text" id="searchAvailable" class="form-control" placeholder="Search available papers...">
                        </div>
                    </div>
                    <div id="loading-available" class="text-center py-4" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Loading available papers...</p>
                    </div>
                    <div id="subjects" class="papers-container">
                        <!-- Available papers will be loaded here via AJAX -->
                    </div>
                    <div id="no-available-papers" class="empty-state" style="display: none;">
                        <div class="text-center py-4">
                            <i class="las la-inbox text-muted" style="font-size: 3rem;"></i>
                            <h6 class="text-muted mt-2">No Available Papers</h6>
                            <p class="text-muted small">All papers have been added to this test</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Selected Papers Section -->
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="p-3">
                    <h5 class="mb-0">
                        <i class="las la-check-circle me-2"></i>
                        Selected Papers
                        <span id="papers-count" class="badge bg-light text-dark ms-2">0</span>
                    </h5>
                    <small>Papers included in this test</small>
                </div>
                <div class="card-body">
                    <div class="search-container mb-3">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="las la-search"></i>
                            </span>
                            <input type="text" id="searchSelected" class="form-control" placeholder="Search selected papers...">
                        </div>
                    </div>
                    <div id="loading-selected" class="text-center py-4" style="display: none;">
                        <div class="spinner-border text-success" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Loading selected papers...</p>
                    </div>
                    <div id="registered-subjects" class="papers-container">
                        <!-- Selected papers will be loaded here via AJAX -->
                    </div>
                    <div id="no-selected-papers" class="empty-state" style="display: none;">
                        <div class="text-center py-4">
                            <i class="las la-plus-circle text-muted" style="font-size: 3rem;"></i>
                            <h6 class="text-muted mt-2">No Papers Selected</h6>
                            <p class="text-muted small">Add papers from the available list</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="las la-info-circle me-1"></i>
                            Click papers to manage them
                        </small>
                        <button type="button" class="btn btn-sm btn-outline-danger" id="clear-all-papers" style="display: none;">
                            <i class="las la-trash me-1"></i>
                            Clear All
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        let availablePapersCache = [];
        let selectedPapersCache = [];

        function subjects() {
            $('#loading-available').show();
            $('#subjects').hide();
            
            $.get('{{ route('admin.test.config.subjects.ajax',[$config_id]) }}', function (response) {
                $('#subjects').html(response);
                $('#loading-available').hide();
                $('#subjects').show();
                
                // Cache available papers for search
                availablePapersCache = $('#subjects tbody tr');
                updateAvailablePapersVisibility();
                
                // Show/hide empty state
                if (availablePapersCache.length === 0) {
                    $('#no-available-papers').show();
                    $('#subjects').hide();
                } else {
                    $('#no-available-papers').hide();
                }
            }).fail(function() {
                $('#loading-available').hide();
                $('#subjects').html('<div class="alert alert-danger">Error loading available papers</div>');
            });
        }

        function registered() {
            $('#loading-selected').show();
            $('#registered-subjects').hide();
            
            $.get('{{ route('admin.test.config.registered.subjects',[$config_id]) }}', function (response) {
                $('#registered-subjects').html(response);
                $('#loading-selected').hide();
                $('#registered-subjects').show();
                
                // Cache selected papers for search
                selectedPapersCache = $('#registered-subjects tbody tr');
                updateSelectedPapersVisibility();
                updatePapersCount();
                
                // Show/hide empty state and clear button
                if (selectedPapersCache.length === 0) {
                    $('#no-selected-papers').show();
                    $('#registered-subjects').hide();
                    $('#clear-all-papers').hide();
                } else {
                    $('#no-selected-papers').hide();
                    $('#clear-all-papers').show();
                }
            }).fail(function() {
                $('#loading-selected').hide();
                $('#registered-subjects').html('<div class="alert alert-danger">Error loading selected papers</div>');
            });
        }

        function updatePapersCount() {
            const count = selectedPapersCache.length;
            $('#papers-count').text(count);
        }

        function updateAvailablePapersVisibility() {
            const searchTerm = $('#searchAvailable').val().toLowerCase();
            let visibleCount = 0;
            
            availablePapersCache.each(function() {
                const paperText = $(this).text().toLowerCase();
                if (paperText.includes(searchTerm)) {
                    $(this).show();
                    visibleCount++;
                } else {
                    $(this).hide();
                }
            });

            // Show appropriate message if no results
            if (visibleCount === 0 && searchTerm) {
                $('#subjects tbody').append('<tr id="no-search-results-available"><td colspan="4" class="text-center py-4"><i class="las la-search text-muted" style="font-size: 2rem;"></i><h6 class="text-muted mt-2">No papers found</h6><p class="text-muted small">Try adjusting your search terms</p></td></tr>');
            } else {
                $('#no-search-results-available').remove();
            }
        }

        function updateSelectedPapersVisibility() {
            const searchTerm = $('#searchSelected').val().toLowerCase();
            let visibleCount = 0;
            
            selectedPapersCache.each(function() {
                const paperText = $(this).text().toLowerCase();
                if (paperText.includes(searchTerm)) {
                    $(this).show();
                    visibleCount++;
                } else {
                    $(this).hide();
                }
            });

            // Show appropriate message if no results
            if (visibleCount === 0 && searchTerm) {
                $('#registered-subjects tbody').append('<tr id="no-search-results-selected"><td colspan="4" class="text-center py-4"><i class="las la-search text-muted" style="font-size: 2rem;"></i><h6 class="text-muted mt-2">No papers found</h6><p class="text-muted small">Try adjusting your search terms</p></td></tr>');
            } else {
                $('#no-search-results-selected').remove();
            }
        }

        function refreshBothSections() {
            subjects();
            registered();
        }

        $(function () {
            // Initial load
            refreshBothSections();

            // Search functionality for available papers
            $('#searchAvailable').on('input', function() {
                updateAvailablePapersVisibility();
            });

            // Search functionality for selected papers
            $('#searchSelected').on('input', function() {
                updateSelectedPapersVisibility();
            });

            // Add paper to test (from available to selected)
            $(document).on('click', '.delete_schedule', function () {
                const $button = $(this);
                const id = $button.data('id');
                const $row = $button.closest('tr');
                
                // Add loading state
                $button.prop('disabled', true);
                $button.html('<i class="fas fa-spinner fa-spin"></i>');
                
                $.post('{{ route('admin.test.config.subject.register') }}', {
                    'subject_id': id,
                    '_token': '{{ csrf_token() }}',
                    'test_config_id': {{ $config_id }}
                }, function () {
                    // Add success animation
                    $row.addClass('fade-out');
                    setTimeout(() => {
                        refreshBothSections();
                    }, 300);
                }).fail(function() {
                    // Reset button on error
                    $button.prop('disabled', false);
                    $button.html('<i class="las la-plus me-1"></i>Add');
                    Swal.fire('Error', 'Failed to add paper to test. Please try again.', 'error');
                });
            });

            // Remove paper from test (from selected to available)
            $(document).on('click', '.remove', function () {
                const $button = $(this);
                const id = $button.data('id');
                const $row = $button.closest('tr');
                
                // Add loading state
                $button.prop('disabled', true);
                $button.html('<i class="fas fa-spinner fa-spin"></i>');
                
                $.get('{{ route('admin.test.config.subject.remove',[':id']) }}'.replace(':id', id), function () {
                    // Add success animation
                    $row.addClass('fade-out');
                    setTimeout(() => {
                        refreshBothSections();
                    }, 300);
                }).fail(function() {
                    // Reset button on error
                    $button.prop('disabled', false);
                    $button.html('<i class="las la-times me-1"></i>Remove');
                    Swal.fire('Error', 'Failed to remove paper from test. Please try again.', 'error');
                });
            });

            // Clear all papers
            $('#clear-all-papers').on('click', function() {
                const $button = $(this);
                
                Swal.fire({
                    title: 'Remove All Papers?',
                    text: 'Are you sure you want to remove all papers from this test? This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, remove all',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $button.prop('disabled', true);
                        $button.html('<i class="fas fa-spinner fa-spin me-1"></i>Clearing...');
                        
                        // Get all selected paper IDs
                        const paperIds = [];
                        $('#registered-subjects .remove').each(function() {
                            paperIds.push($(this).data('id'));
                        });
                        
                        if (paperIds.length === 0) {
                            Swal.fire('No Papers', 'There are no papers to remove.', 'info');
                            $button.prop('disabled', false);
                            $button.html('<i class="las la-trash me-1"></i>Clear All');
                            return;
                        }
                        
                        // Remove papers sequentially
                        let completed = 0;
                        let failed = 0;
                        
                        paperIds.forEach(function(id) {
                            $.get('{{ route('admin.test.config.subject.remove',[':id']) }}'.replace(':id', id))
                                .done(function () {
                                    completed++;
                                    checkCompletion();
                                })
                                .fail(function() {
                                    failed++;
                                    checkCompletion();
                                });
                        });
                        
                        function checkCompletion() {
                            if (completed + failed === paperIds.length) {
                                setTimeout(() => {
                                    refreshBothSections();
                                    $button.prop('disabled', false);
                                    $button.html('<i class="las la-trash me-1"></i>Clear All');
                                    
                                    if (failed > 0) {
                                        Swal.fire('Partially Complete', 
                                            `${completed} papers removed successfully, but ${failed} failed to remove.`, 
                                            'warning');
                                    } else {
                                        Swal.fire('Success!', 
                                            `All ${completed} papers have been removed from the test.`, 
                                            'success');
                                    }
                                }, 300);
                            }
                        }
                    }
                });
            });

            // Auto-refresh every 30 seconds to sync with other users
            setInterval(refreshBothSections, 30000);
        });
    </script>

    <style>
        .fade-out {
            opacity: 0;
            transform: scale(0.95);
            transition: all 0.3s ease;
        }
        
        .papers-container {
            min-height: 200px;
            max-height: 400px;
            overflow-y: auto;
        }
        
        .doc-slot-list {
            margin-bottom: 0.5rem;
            padding: 0.75rem;
            border-radius: 0.375rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.2s ease;
            cursor: pointer;
        }
        
        .doc-slot-list:hover {
            transform: translateY(-1px);
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        
        .empty-state {
            min-height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .search-container {
            position: sticky;
            top: 0;
            background: white;
            z-index: 10;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 1rem !important;
        }
        
        .table-responsive {
            max-height: 400px;
            overflow-y: auto;
        }
        
        .btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }
    </style>
@endsection
