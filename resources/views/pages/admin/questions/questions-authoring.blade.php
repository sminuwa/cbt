@php use App\Models\Subject; @endphp
@extends('layouts.app')
@section('css')
    <style>
        #loading {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            z-index: 1000;
        }
        /* Modal styling for preview */
        .modal-xl {
            max-width: 90%;
        }
        
        #preview-modal-content {
            max-height: 70vh;
            overflow-y: auto;
        }
        
        /* Custom scrollbar for modal */
        #preview-modal-content::-webkit-scrollbar {
            width: 8px;
        }
        
        #preview-modal-content::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        
        #preview-modal-content::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }
        
        #preview-modal-content::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        
        /* Question card styling in modal preview */
        #preview-modal-content .card {
            margin-bottom: 15px !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        /* Modal body padding */
        #preview-modal .modal-body {
            padding: 1.5rem;
        }
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
        .preview-controls {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
            align-items: center;
        }
    </style>
@endsection
@section('content')

    <div class="row">
        <x-head.tinymce-config/>

        <div class="col-md-12 col-lg-12 col-xl-12">

            <div class="row patient-graph-col">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Question Authoring</h4>
                        </div>
                        <div class="card-body pt-2 pb-2 mt-1 mb-1">
                            <div id="form" class="row">
                                <form id="authoringForm" method="post" action="" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row pb-3 pt-2">
                                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="form-group">
                                                <label class="form-label" for="subject_id">Subject:</label>
                                                <div class="input-group">
                                                    <select class="form-control form-select" name="subject_id"id="subject_id" required>
                                                        <option value="">Select Paper</option>
                                                        @foreach(Subject::all() as $subject)
                                                            <option value="{{$subject->id}}">{{ $subject->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <a class="btn btn-success" 
                                                       data-bs-toggle="modal" id="add" href="#add_new_subject">
                                                        <i class="fa fa-plus"></i> Add</a>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        
                                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="form-group">
                                                <label class="form-label" for="topic_id">Course/Topic:</label>
                                                <select class="form-control form-select" name="topic_id" id="topic_id"
                                                        required>
                                                    <option value="">Select Subject</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Input Method Tabs -->
                                    <div class="mt-3">
                                        <ul class="nav nav-tabs" id="inputMethodTabs" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="editor-tab" data-bs-toggle="tab" data-bs-target="#editor-pane" type="button" role="tab">
                                                    <i class="fa fa-edit"></i> Text Editor
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="upload-tab" data-bs-toggle="tab" data-bs-target="#upload-pane" type="button" role="tab">
                                                    <i class="fa fa-upload"></i> File Upload
                                                </button>
                                            </li>
                                        </ul>
                                        
                                        <div class="tab-content mt-3" id="inputMethodContent">
                                            <!-- Text Editor Tab -->
                                            <div class="tab-pane fade show active" id="editor-pane" role="tabpanel">
                                                <textarea id="question-editor" name="content" placeholder="Enter your questions here using the format:
??Question text here {S/M/D}
**Option A
**Option B  
**Option C ==correct answer
**Option D

??Next question here {S/M/D}
**Option A ==correct answer
**Option B
**Option C
**Option D"></textarea>
                                                
                                                <div class="mt-2">
                                                    <small class="text-muted">
                                                        <strong>Format Guide:</strong> 
                                                        <code>??</code> for questions, 
                                                        <code>**</code> for options, 
                                                        <code>==</code> for correct answers, 
                                                        <code>{S/M/D}</code> for difficulty
                                                    </small>
                                                </div>
                                            </div>
                                            
                                            <!-- File Upload Tab -->
                                            <div class="tab-pane fade" id="upload-pane" role="tabpanel">
                                                <div class="card border-info">
                                                    <div class="card-header bg-light">
                                                        <h6 class="mb-0">
                                                            <i class="fa fa-upload"></i> Upload Question File
                                                        </h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="mb-3">
                                                            <label for="question-file" class="form-label">
                                                                <strong>Choose File:</strong>
                                                            </label>
                                                            <input type="file" class="form-control" id="question-file" name="question_file" accept=".txt,.doc,.docx">
                                                            <div class="form-text">
                                                                <strong>Supported formats:</strong> .txt, .doc, .docx (max 5MB)
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="">
                                                            <strong><i class="fa fa-info-circle"></i> File Format Requirements:</strong>
                                                            <ul class="mb-0 mt-2">
                                                                <li>Use the same format as the text editor</li>
                                                                <li><code>??</code> to start each question</li>
                                                                <li><code>**</code> for each option</code>
                                                                <li><code>==</code> to mark correct answers</li>
                                                                <li><code>{S}</code> = Simple, <code>{M}</code> = Moderate, <code>{D}</code> = Difficult</li>
                                                            </ul>
                                                        </div>
                                                        
                                                        <div class="mt-3">
                                                            <button type="button" class="btn btn-sm btn-secondary" id="download-template">
                                                                <i class="fa fa-download"></i> Download Template File
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-3">
                                        <input class="btn btn-sm btn-info text-light" type="submit" value="Preview Questions">
                                    </div>
                                </form>
                            </div>
                            <div id="loading" style="display: none;">Loading...</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Questions Preview Modal -->
    <div class="modal fade" id="preview-modal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">
                        <i class="fa fa-eye"></i> Questions Preview
                        <span class="badge bg-info ms-2" id="question-count-badge">0 Questions</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="preview-modal-content">
                        <!-- Preview content will be loaded here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-times"></i> Close
                    </button>
                    <button type="button" class="btn btn-warning" id="edit-questions-modal">
                        <i class="fa fa-edit"></i> Edit Questions
                    </button>
                    <button type="button" class="btn btn-success" id="submit-questions-modal" style="display: none;">
                        <i class="fa fa-check"></i> Submit Questions
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

    <div class="modal fade custom-modal" id="add_new_subject">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Subject</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form id="add-subject" action="" method="post">
                    @csrf
                    <input type="hidden" id="subject" name="subject_id"/>
                    <div class="modal-body">
                        <div class="hours-info">
                            <div class="row hours-cont">
                                <div class="col-12 col-md-12">
                                    <div class="row">
                                        <div class="col-12 col-md-12">
                                            <div class="mb-6">
                                                <label for="topic" class="mb-6">Subject</label>
                                                <input type="text" id="topic" name="name" class="form-control"
                                                       placeholder="Subject" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer submit-section text-end">
                        <button type="submit" class="btn btn-sm btn-info text-light">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(function () {
            function fetchSubjects(id) {
                $.get('{{ route('admin.authoring.topics',[':id']) }}'.replace(':id', id), function (data) {
                    $('#topic_id').html(data)
                })
            }

            $('#subject_id').on('change', function () {
                let id = $(this).val();
                fetchSubjects(id)
            })

            $('#add').on('click', function () {
                const subject = $('#subject_id').val()
                if (subject === '') {
                    alert('Select paper to add the subject first')
                } else {
                    $('#topic').val('')
                    $('#subject').val(subject)
                }
            })

            $('#add-subject').on('submit', function (e) {
                e.preventDefault()
                $.post('{{route('admin.authoring.topics.add')}}', $(this).serialize(), function (response) {
                    if (!response.success) alert(response.message)
                    $('#add_new_subject').modal('hide')
                    fetchSubjects($('#subject_id').val())
                })
            })

            $('#authoringForm').on('submit', function (e) {
                e.preventDefault()

                const loader = $('#loading')
                loader.show()
                
                // Check if we're using file upload or text editor
                const activeTab = $('#inputMethodTabs .nav-link.active').attr('id')
                
                if (activeTab === 'upload-tab') {
                    // Handle file upload
                    const fileInput = $('#question-file')[0]
                    if (!fileInput.files.length) {
                        alert('Please select a file to upload.')
                        loader.hide()
                        return
                    }
                    
                    // Use FormData for file upload
                    const formData = new FormData(this)
                    
                    $.ajax({
                        url: '{{ route('admin.authoring.store') }}',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            loader.hide()
                            loadPreviewModal(response.url)
                        },
                        error: function(xhr) {
                            loader.hide()
                            let errorMessage = 'Error processing file. Please try again.'
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message
                            }
                            alert(errorMessage)
                        }
                    })
                } else {
                    // Handle text editor (existing functionality)
                    $.post('{{ route('admin.authoring.store') }}', $(this).serialize(), function (response) {
                        loader.hide()
                        loadPreviewModal(response.url)
                    }).fail(function(xhr) {
                        loader.hide()
                        let errorMessage = 'Error processing questions. Please try again.'
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message
                        }
                        alert(errorMessage)
                    })
                }
            })
            
            // Function to load preview content in modal
            function loadPreviewModal(reviewUrl) {
                $.get(reviewUrl, function(data) {
                    console.log('Loading preview data for modal...')
                    
                    // Extract the form content from the review page
                    const parser = new DOMParser()
                    const doc = parser.parseFromString(data, 'text/html')
                    const questions = doc.querySelectorAll('.card.border-info')
                    
                    console.log('Found', questions.length, 'questions')
                    
                    let previewHTML = '<form id="final-submit-form" method="post" action="{{ route('admin.authoring.submit') }}">'
                    previewHTML += '<input type="hidden" name="_token" value="{{ csrf_token() }}">'
                    previewHTML += '<input type="hidden" name="subject_id" value="' + $('#subject_id').val() + '">'
                    previewHTML += '<input type="hidden" name="topic_id" value="' + $('#topic_id').val() + '">'
                    
                    if (questions.length === 0) {
                        previewHTML += `
                            <div class="">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fa fa-info-circle me-2"></i>
                                    <strong>No Questions Available for Preview</strong>
                                </div>
                                <p class="mb-2">This could happen because:</p>
                                <ul class="mb-3">
                                    <li>All questions had validation errors and were filtered out</li>
                                    <li>All questions were duplicates (either within your upload or already exist in the database)</li>
                                    <li>No questions were detected in your content - please check your question format</li>
                                </ul>
                                <div class="mt-3">
                                    <strong>What to do next:</strong>
                                    <ol class="mt-2">
                                        <li>Go back and check your question format</li>
                                        <li>Ensure you're using the correct delimiters (??question, **option, ==correct answer)</li>
                                        <li>Make sure each question has at least 2 options and 1 correct answer</li>
                                        <li>Check that your questions are unique</li>
                                    </ol>
                                </div>
                            </div>
                        `
                    } else {
                        questions.forEach(function(question, index) {
                            previewHTML += '<div class="mb-3">' + question.outerHTML + '</div>'
                        })
                    }
                    
                    previewHTML += '</form>'
                    
                    // Load content into modal and show it
                    $('#preview-modal-content').html(previewHTML)
                    
                    // Update question count badge and show/hide submit button
                    const questionCount = questions.length
                    if (questionCount === 0) {
                        $('#question-count-badge').text('No Valid Questions').removeClass('bg-info').addClass('bg-warning')
                        $('#submit-questions-modal').hide()
                    } else {
                        $('#question-count-badge').text(questionCount + ' Question' + (questionCount !== 1 ? 's' : '')).removeClass('bg-warning').addClass('bg-info')
                        $('#submit-questions-modal').show()
                    }
                    
                    // Show the modal
                    const previewModal = new bootstrap.Modal(document.getElementById('preview-modal'))
                    previewModal.show()
                    
                    console.log('Preview modal displayed with', questions.length, 'questions')
                    
                }).fail(function(xhr, status, error) {
                    console.error('Failed to load preview:', error)
                    $('#preview-modal-content').html(`
                        <div class="alert alert-danger">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fa fa-exclamation-triangle me-2"></i>
                                <strong>Failed to Load Preview</strong>
                            </div>
                            <p class="mb-2">There was an error loading the question preview. This might be due to:</p>
                            <ul class="mb-3">
                                <li>Server connection issues</li>
                                <li>Session timeout - you might need to log in again</li>
                                <li>Invalid question format causing processing errors</li>
                            </ul>
                            <div class="mt-3">
                                <strong>Please try:</strong>
                                <ol class="mt-2">
                                    <li>Refreshing the page and trying again</li>
                                    <li>Checking your internet connection</li>
                                    <li>Verifying your question format</li>
                                    <li>Contacting support if the problem persists</li>
                                </ol>
                            </div>
                        </div>
                    `)
                    
                    // Update badge for error state
                    $('#question-count-badge').text('Preview Error').removeClass('bg-info bg-warning').addClass('bg-danger')
                    $('#submit-questions-modal').hide()
                    
                    // Still show modal even with error
                    const previewModal = new bootstrap.Modal(document.getElementById('preview-modal'))
                    previewModal.show()
                })
            }
            
            // Handle edit questions button from modal
            $('#edit-questions-modal').on('click', function() {
                // Close the modal
                const previewModal = bootstrap.Modal.getInstance(document.getElementById('preview-modal'))
                if (previewModal) {
                    previewModal.hide()
                }
                
                // Focus back to the editor
                setTimeout(function() {
                    if (typeof tinymce !== 'undefined' && tinymce.get('question-editor')) {
                        tinymce.get('question-editor').focus()
                    }
                }, 300)
            })
            
            // Handle final submit from modal
            $('#submit-questions-modal').on('click', function() {
                const loader = $('#loading')
                const submitBtn = $(this)
                
                // Disable button and show loading
                submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Submitting...')
                loader.show()
                
                $.post('{{ route('admin.authoring.submit') }}', $('#final-submit-form').serialize())
                .done(function(response, textStatus, xhr) {
                    loader.hide()
                    
                    // Check if response is a redirect (Laravel returns HTML for redirects via AJAX)
                    if (xhr.status === 200 && typeof response === 'string' && response.includes('<!DOCTYPE html>')) {
                        // Close modal
                        const previewModal = bootstrap.Modal.getInstance(document.getElementById('preview-modal'))
                        if (previewModal) {
                            previewModal.hide()
                        }
                        
                        // Extract redirect URL from response or use default
                        const redirectMatch = response.match(/window\.location\.href\s*=\s*['"]([^'"]+)['"]/);
                        const redirectUrl = redirectMatch ? redirectMatch[1] : '{{ route('admin.authoring.completed', [0]) }}';
                        
                        // Redirect to completion page
                        window.location.href = redirectUrl;
                    } else if (response && response.success === false) {
                        // Handle JSON error response
                        submitBtn.prop('disabled', false).html('<i class="fa fa-check"></i> Submit Questions')
                        alert(response.message || 'Error submitting questions. Please try again.')
                        if (response.error_details && console) {
                            console.error('Submission error details:', response.error_details)
                        }
                    } else {
                        // Handle other success responses
                        const previewModal = bootstrap.Modal.getInstance(document.getElementById('preview-modal'))
                        if (previewModal) {
                            previewModal.hide()
                        }
                        window.location.href = '{{ route('admin.authoring.completed', [0]) }}'
                    }
                })
                .fail(function(xhr) {
                    loader.hide()
                    submitBtn.prop('disabled', false).html('<i class="fa fa-check"></i> Submit Questions')
                    
                    let errorMessage = 'Error submitting questions. Please try again.'
                    
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message
                        if (xhr.responseJSON.error_details && console) {
                            console.error('Submission error details:', xhr.responseJSON.error_details)
                        }
                    } else if (xhr.status === 500) {
                        errorMessage = 'Server error occurred. Please try again or contact support.'
                    }
                    
                    alert(errorMessage)
                })
            })
            
            // Handle template download
            $('#download-template').on('click', function() {
                const templateContent = `??What is the capital of France? {S}
**London
**Berlin
**Paris ==correct answer
**Madrid

??Which of the following is a programming language? {M}
**HTML
**CSS
**JavaScript ==correct answer
**XML

??What is the time complexity of quicksort in the worst case? {D}
**O(n) 
**O(n log n)
**O(n²) ==correct answer
**O(log n)

??Python is an interpreted language. {S}
**True ==correct answer
**False

Format Guide:
- ?? starts a new question
- {S} = Simple, {M} = Moderate, {D} = Difficult
- ** starts each option
- == marks the correct answer
- Leave blank lines between questions for better readability`

                const blob = new Blob([templateContent], { type: 'text/plain' })
                const url = window.URL.createObjectURL(blob)
                const a = document.createElement('a')
                a.href = url
                a.download = 'question-template.txt'
                document.body.appendChild(a)
                a.click()
                window.URL.revokeObjectURL(url)
                document.body.removeChild(a)
            })
        })
    </script>
@endsection
