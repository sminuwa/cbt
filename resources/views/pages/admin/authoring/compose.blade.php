@php
    use Illuminate\Support\Str;
@endphp
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
    
    <!-- Header Card -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="card-title mb-0 ">
                        <i class="las la-layer-group me-2"></i>Test Section Composition
                    </h4>
                    <small class="">Configure test sections for: <strong>{{ $testSubject->subject->subject_code }} - {{ $testSubject->subject->name }}</strong></small>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.test.config.composition', [$testSubject->test_config_id]) }}" class="btn btn-outline-light btn-sm">
                        <i class="las la-arrow-left me-1"></i>Back to Papers
                    </a>
                    <a href="{{ route('admin.test.config.index') }}" class="btn btn-light btn-sm">
                        <i class="las la-home me-1"></i>Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Existing Sections -->
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">
                                <i class="las la-list-ol me-2"></i>Available Test Sections
                            </h5>
                            <small class="">Manage sections for {{ $testSubject->subject->subject_code }}</small>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-light text-dark">{{ count($sections) }} section(s)</span>
                            <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addSectionModal">
                                <i class="las la-plus me-1"></i>Add Section
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(count($sections))
                        <!-- Sections Accordion -->
                        <div class="accordion" id="sectionsAccordion">
                            @foreach($sections as $section)
                                @php
                                    $composedQuestions = count($section->test_questions ?? []);
                                    $totalQuestions = $section->num_to_answer;
                                    $completionPercentage = $totalQuestions > 0 ? round(($composedQuestions / $totalQuestions) * 100) : 0;
                                    $isComplete = $composedQuestions >= $totalQuestions;
                                @endphp
                                <div class="accordion-item border mb-2">
                                    <!-- Accordion Header -->
                                    <h2 class="accordion-header" id="heading{{ $section->id }}">
                                        <div class="d-flex align-items-center">
                                            <!-- Accordion Button -->
                                            <button class="accordion-button collapsed flex-grow-1" type="button" 
                                                    data-bs-toggle="collapse" data-bs-target="#collapse{{ $section->id }}"
                                                    aria-expanded="false" aria-controls="collapse{{ $section->id }}">
                                                <div class="d-flex justify-content-between align-items-center w-100 me-3">
                                                    <div class="d-flex align-items-center">
                                                        <span class="badge bg-secondary me-2">{{ $loop->iteration }}</span>
                                                        <div>
                                                            <strong class="text-dark">{{ $section->title }}</strong>
                                                            @if($section->instruction)
                                                                <br><small class="text-muted">{{ Str::limit(strip_tags($section->instruction), 60) }}</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <!-- Question Status -->
                                                        <div class="text-center">
                                                            <small class="text-muted d-block">Questions</small>
                                                            <span class="badge {{ $isComplete ? 'bg-success' : ($composedQuestions > 0 ? 'bg-warning' : 'text-dark') }}">
                                                                {{ $composedQuestions }}/{{ $totalQuestions }}
                                                            </span>
                                                        </div>
                                                        <!-- Total Marks -->
                                                        <div class="text-center">
                                                            <small class="text-muted d-block">Total Marks</small>
                                                            <span class="badge bg-info">{{ $section->num_to_answer * $section->mark_per_question }}</span>
                                                        </div>
                                                        <!-- Status Icon -->
                                                        @if($isComplete)
                                                            <i class="las la-check-circle text-success fs-5"></i>
                                                        @elseif($composedQuestions > 0)
                                                            <i class="las la-clock text-warning fs-5"></i>
                                                        @else
                                                            <i class="las la-exclamation-circle text-danger fs-5"></i>
                                                        @endif
                                                    </div>
                                                </div>
                                            </button>
                                            
                                            <!-- Action Buttons - Outside accordion button -->
                                            <div class="d-flex gap-1 ms-2 me-2">
                                                <a class="btn btn-primary btn-sm compose"
                                                   href="{{route('admin.test.config.composition.compose.questions',[$section->id])}}"
                                                   title="Manage questions for this section">
                                                    <i class="las la-plus"></i>
                                                </a>
                                                <button class="btn btn-outline-warning btn-sm edit" 
                                                        data-id="{{ $section->id }}"
                                                        data-title="{{$section->title}}"
                                                        data-mark="{{$section->mark_per_question}}"
                                                        data-count="{{$section->num_to_answer}}"
                                                        data-easy="{{$section->num_of_easy}}"
                                                        data-mod="{{$section->num_of_moderate}}"
                                                        data-diff="{{$section->num_of_difficult}}"
                                                        data-inst="{{$section->instruction}}"
                                                        title="Edit section settings">
                                                    <i class="las la-edit"></i>
                                                </button>
                                                <button class="btn btn-outline-danger btn-sm remove"
                                                        data-id="{{ $section->id }}"
                                                        title="Delete this section">
                                                    <i class="las la-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </h2>
                                    
                                    <!-- Accordion Body -->
                                    <div id="collapse{{ $section->id }}" class="accordion-collapse collapse"
                                         aria-labelledby="heading{{ $section->id }}" data-bs-parent="#sectionsAccordion">
                                        <div class="accordion-body">
                                            <div class="row">
                                                <!-- Section Details -->
                                                <div class="col-md-8">
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <h6 class="text-primary mb-2">
                                                                <i class="las la-info-circle me-1"></i>Section Information
                                                            </h6>
                                                            <div class="mb-2">
                                                                <strong>Points per Question:</strong> 
                                                                <span class="badge bg-warning text-dark">{{ $section->mark_per_question }}</span>
                                                            </div>
                                                            <div class="mb-2">
                                                                <strong>Total Questions:</strong> 
                                                                <span class="badge bg-info">{{ $section->num_to_answer }}</span>
                                                            </div>
                                                            <div class="mb-2">
                                                                <strong>Maximum Score:</strong> 
                                                                <span class="badge bg-success">{{ $section->num_to_answer * $section->mark_per_question }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6 class="text-success mb-2">
                                                                <i class="las la-chart-bar me-1"></i>Difficulty Distribution
                                                            </h6>
                                                            <div class="mb-2">
                                                                <span class="badge bg-success me-1">Easy</span>
                                                                <span class="text-muted">{{ $section->num_of_easy }} questions</span>
                                                            </div>
                                                            <div class="mb-2">
                                                                <span class="badge bg-warning text-dark me-1">Moderate</span>
                                                                <span class="text-muted">{{ $section->num_of_moderate }} questions</span>
                                                            </div>
                                                            <div class="mb-2">
                                                                <span class="badge bg-danger me-1">Hard</span>
                                                                <span class="text-muted">{{ $section->num_of_difficult }} questions</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Instructions -->
                                                    @if($section->instruction)
                                                        <div class="mb-3">
                                                            <h6 class="text-info mb-2">
                                                                <i class="las la-clipboard me-1"></i>Section Instructions
                                                            </h6>
                                                            <div class="p-3 rounded">
                                                                {!! $section->instruction !!}
                                                            </div>
                                                        </div>
                                                    @endif
                                                    
                                                    <!-- Question Composition Progress -->
                                                    <div class="mb-3">
                                                        <h6 class="text-warning mb-2">
                                                            <i class="las la-tasks me-1"></i>Question Composition Progress
                                                        </h6>
                                                        <div class="progress mb-2" style="height: 10px;">
                                                            <div class="progress-bar {{ $isComplete ? 'bg-success' : 'bg-warning' }}" 
                                                                 role="progressbar" style="width: {{ $completionPercentage }}%"
                                                                 aria-valuenow="{{ $completionPercentage }}" aria-valuemin="0" aria-valuemax="100">
                                                                {{ $completionPercentage }}%
                                                            </div>
                                                        </div>
                                                        <small class="text-muted">
                                                            {{ $composedQuestions }} of {{ $totalQuestions }} questions composed
                                                            @if($isComplete)
                                                                <span class="text-success ms-2"><i class="las la-check"></i> Complete</span>
                                                            @elseif($composedQuestions > 0)
                                                                <span class="text-warning ms-2"><i class="las la-clock"></i> In Progress</span>
                                                            @else
                                                                <span class="text-danger ms-2"><i class="las la-exclamation-circle"></i> Not Started</span>
                                                            @endif
                                                        </small>
                                                    </div>
                                                </div>
                                                
                                                <!-- Section Stats Card -->
                                                <div class="col-md-12">
                                                    <div class="row justify-content-center">
                                                        <div class="col-md-6">
                                                            <div class="card">
                                                                <div class="card-body p-3">
                                                                    <h6 class="card-title text-muted mb-2 text-center">Section Progress Stats</h6>
                                                                    <div class="row text-center">
                                                                        <div class="col-6">
                                                                            <div class="text-primary">
                                                                                <i class="las la-question-circle"></i>
                                                                            </div>
                                                                            <small class="text-muted d-block">Questions</small>
                                                                            <strong>{{ $composedQuestions }}/{{ $totalQuestions }}</strong>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="text-success">
                                                                                <i class="las la-percentage"></i>
                                                                            </div>
                                                                            <small class="text-muted d-block">Complete</small>
                                                                            <strong>{{ $completionPercentage }}%</strong>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="las la-plus-circle display-4 text-muted"></i>
                            </div>
                            <h5 class="text-muted mb-2">No Sections Created</h5>
                            <p class="text-muted">Get started by creating your first test section below.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Add/Edit Section Modal -->
    <div class="modal fade" id="addSectionModal" tabindex="-1" aria-labelledby="addSectionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSectionModalLabel">
                        <i class="las la-plus-circle me-2"></i><span id="modal-title">Create New Section</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.test.config.composition.compose.store') }}" method="post" id="sectionForm">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" id="section_id">
                        <input type="hidden" name="test_subject_id" value="{{ $testSubject->id }}">
                        
                        <!-- Instructions -->
                        <div class="mb-4">
                            <label for="instruction" class="form-label">
                                <i class="las la-info-circle text-info me-1"></i>Section Instructions <small class="text-muted">(optional)</small>
                            </label>
                            <textarea id="instruction" name="instruction" class="form-control" rows="3"
                                      placeholder="Enter any special instructions for this section..."></textarea>
                            <div class="form-text">Provide candidates with specific guidance for this section if needed.</div>
                        </div>

                        <!-- Basic Section Info -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label for="title" class="form-label">
                                    <i class="las la-tag text-primary me-1"></i>Section Title <span class="text-danger">*</span>
                                </label>
                                <input class="form-control" type="text" name="title" id="title" 
                                       placeholder="e.g., SECTION A, Part I, etc." required>
                                <div class="form-text">A clear identifier for this section</div>
                            </div>
                            <div class="col-md-4">
                                <label for="mark" class="form-label">
                                    <i class="las la-star text-warning me-1"></i>Points Per Question <span class="text-danger">*</span>
                                </label>
                                <input class="form-control" type="number" step="0.01" min="0.01" name="mark_per_question" id="mark" required>
                                <div class="form-text">Marks awarded for each correct answer</div>
                            </div>
                            <div class="col-md-4">
                                <label for="count" class="form-label">
                                    <i class="las la-question-circle text-info me-1"></i>Total Questions <span class="text-danger">*</span>
                                </label>
                                <input class="form-control" type="number" min="1" name="num_to_answer" id="count" required>
                                <div class="form-text">Number of questions in this section</div>
                            </div>
                        </div>

                        <!-- Difficulty Distribution -->
                        <div class="mb-4">
                            <h6 class="mb-3">
                                <i class="las la-chart-bar text-success me-1"></i>Question Difficulty Distribution
                            </h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="easy" class="form-label">
                                        <span class="badge bg-success me-1">Easy</span>Questions <span class="text-danger">*</span>
                                    </label>
                                    <input class="form-control" type="number" min="0" name="num_of_easy" id="easy" required>
                                    <div class="form-text">Number of simple/basic questions</div>
                                </div>
                                <div class="col-md-4">
                                    <label for="moderate" class="form-label">
                                        <span class="badge bg-warning text-dark me-1">Moderate</span>Questions <span class="text-danger">*</span>
                                    </label>
                                    <input class="form-control" type="number" min="0" name="num_of_moderate" id="moderate" required>
                                    <div class="form-text">Number of intermediate questions</div>
                                </div>
                                <div class="col-md-4">
                                    <label for="difficult" class="form-label">
                                        <span class="badge bg-danger me-1">Hard</span>Questions <span class="text-danger">*</span>
                                    </label>
                                    <input class="form-control" type="number" min="0" name="num_of_difficult" id="difficult" required>
                                    <div class="form-text">Number of challenging questions</div>
                                </div>
                            </div>
                            <div class="mt-2">
                                <small class="text-muted">
                                    <i class="las la-info-circle me-1"></i>
                                    <strong>Note:</strong> The sum of all difficulty levels should equal the total number of questions.
                                </small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <div>
                                <small class="text-muted">
                                    <span class="text-danger">*</span> Required fields
                                </small>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-secondary" id="reset-modal-form">
                                    <i class="las la-undo me-1"></i>Reset
                                </button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="las la-times me-1"></i>Cancel
                                </button>
                                <button type="submit" class="btn btn-primary" id="modal-submit">
                                    <i class="las la-save me-1"></i>Add Section
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            height: 200,
            license_key: 'gpl',
            selector: 'textarea#instruction', // Replace this CSS selector to match the placeholder element for TinyMCE
            plugins: 'code table lists',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table',
            promotion: false,
            branding: false
        });
    </script>
    <script>
        $(function () {
            // Reset modal form function
            function resetModalForm() {
                $('#section_id').val('');
                $('#title').val('');
                $('#mark').val('');
                $('#count').val('');
                $('#easy').val('');
                $('#moderate').val('');
                $('#difficult').val('');
                
                // Reset TinyMCE content
                if (tinymce.get('instruction')) {
                    tinymce.get('instruction').setContent('');
                } else {
                    $('#instruction').val('');
                }
                
                $('#modal-title').text('Create New Section');
                $('#modal-submit').html('<i class="las la-save me-1"></i>Add Section');
            }
            
            // Initialize modal reset button
            $('#reset-modal-form').on('click', function() {
                resetModalForm();
            });
            
            // Reset form when modal is closed
            $('#addSectionModal').on('hidden.bs.modal', function () {
                resetModalForm();
            });
            
            // Reset form when modal opens for new section (but not for edit)
            $('#addSectionModal').on('show.bs.modal', function (e) {
                // Only reset if it's NOT triggered by an edit button
                if (!$(e.relatedTarget).hasClass('edit')) {
                    resetModalForm();
                }
            });

            // Form validation
            $('#sectionForm').on('submit', function(e) {
                const total = parseInt($('#count').val());
                const easy = parseInt($('#easy').val()) || 0;
                const moderate = parseInt($('#moderate').val()) || 0;
                const difficult = parseInt($('#difficult').val()) || 0;
                
                const sum = easy + moderate + difficult;
                
                if (sum !== total) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Validation Error',
                        html: `The sum of difficulty levels (${sum}) must equal the total number of questions (${total}).<br><br>
                              <div class="text-start">
                                <strong>Current distribution:</strong><br>
                                - Easy: ${easy}<br>
                                - Moderate: ${moderate}<br>
                                - Difficult: ${difficult}<br>
                                <strong>Total: ${sum}</strong> (should be ${total})
                              </div>`,
                        icon: 'error',
                        confirmButtonText: 'Fix Distribution'
                    });
                }
            });

            $(document).on('click', '.composition', function () {
                let id = $(this).data('id');
                $.get('{{ route('admin.test.config.subject.remove',[':id']) }}'.replace(':id', id), function () {
                });
            })

            // Handle delete button clicks with event delegation for dynamically created buttons
            $(document).on('click', '.remove', function () {
                const sectionId = $(this).data('id');
                const sectionTitle = $(this).closest('.accordion-item').find('.accordion-button strong').text();
                const accordionItem = $(this).closest('.accordion-item');
                
                Swal.fire({
                    title: 'Delete Section?',
                    html: `Are you sure you want to delete the section <strong>"${sectionTitle}"</strong>?<br><br>
                           <div class="text-warning">
                               <i class="las la-exclamation-triangle"></i> 
                               This will also delete all questions associated with this section.
                           </div><br>
                           <strong>This action cannot be undone.</strong>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, Delete Section!',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true,
                    customClass: {
                        confirmButton: 'btn btn-danger',
                        cancelButton: 'btn btn-secondary'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading
                        Swal.fire({
                            title: 'Deleting...',
                            text: 'Please wait while we delete the section and related questions.',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        const deleteUrl = '{{ route('admin.test.config.composition.section.delete', ':id') }}'.replace(':id', sectionId);
                        
                        $.ajax({
                            url: deleteUrl,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    // Show success message
                                    Swal.fire({
                                        title: 'Deleted!',
                                        text: response.message,
                                        icon: 'success',
                                        timer: 3000,
                                        showConfirmButton: false
                                    });
                                    
                                    // Remove the accordion item
                                    accordionItem.fadeOut(300, function() {
                                        $(this).remove();
                                        // Check if accordion is empty and show message
                                        if ($('#sectionsAccordion .accordion-item').length === 0) {
                                            $('#sectionsAccordion').parent().html(`
                                                <div class="text-center py-5">
                                                    <div class="mb-3">
                                                        <i class="las la-plus-circle display-4 text-muted"></i>
                                                    </div>
                                                    <h5 class="text-muted mb-2">No Sections Created</h5>
                                                    <p class="text-muted">Get started by creating your first test section below.</p>
                                                </div>
                                            `);
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: response.message,
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            },
                            error: function(xhr) {
                                const errorMessage = xhr.responseJSON?.message || 'An error occurred while deleting the section';
                                Swal.fire({
                                    title: 'Error!',
                                    text: errorMessage,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                });
            });
            
            // Handle edit button clicks with event delegation
            $(document).on('click', '.edit', function (e) {
                e.preventDefault();
                const editBtn = $(this);
                
                console.log('Edit button clicked, data:', {
                    id: editBtn.data('id'),
                    title: editBtn.data('title'),
                    mark: editBtn.data('mark'),
                    count: editBtn.data('count'),
                    easy: editBtn.data('easy'),
                    mod: editBtn.data('mod'),
                    diff: editBtn.data('diff'),
                    inst: editBtn.data('inst')
                });
                
                // Set form values
                $('#section_id').val(editBtn.data('id'));
                $('#title').val(editBtn.data('title'));
                $('#mark').val(editBtn.data('mark'));
                $('#count').val(editBtn.data('count'));
                $('#easy').val(editBtn.data('easy'));
                $('#moderate').val(editBtn.data('mod'));
                $('#difficult').val(editBtn.data('diff'));
                
                // Update modal UI for editing first
                $('#modal-title').text('Edit Section: ' + editBtn.data('title'));
                $('#modal-submit').html('<i class="las la-edit me-1"></i>Update Section');
                
                // Show modal first
                $('#addSectionModal').modal('show');
                
                // Set instruction content with delay to ensure TinyMCE is ready
                const instructionContent = editBtn.data('inst') || '';
                setTimeout(function() {
                    if (tinymce.get('instruction')) {
                        console.log('Setting TinyMCE content:', instructionContent);
                        tinymce.get('instruction').setContent(instructionContent);
                    } else {
                        console.log('TinyMCE not available, setting textarea value:', instructionContent);
                        $('#instruction').val(instructionContent);
                    }
                }, 300); // Give TinyMCE time to initialize after modal opens
            });
        })
    </script>
@endsection
