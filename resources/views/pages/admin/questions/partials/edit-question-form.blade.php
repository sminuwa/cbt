@php use App\Models\Subject; use App\Models\Topic; @endphp

<form id="edit-question-form" method="post" action="{{ route('admin.authoring.update.question') }}">
    <input type="hidden" name="question_id" value="{{ $question->id }}">
    @csrf
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="edit_subject_id" class="form-label fw-bold">Paper:</label>
                <select class="form-control form-select" name="subject_id" id="edit_subject_id" required>
                    <option value="">Select Paper</option>
                    @foreach(Subject::all() as $subject)
                        <option value="{{$subject->id}}" {{ $question->subject_id==$subject->id?'selected':'' }}>{{ $subject->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="edit_topic_id" class="form-label fw-bold">Subject:</label>
                <select class="form-control form-select" name="topic_id" id="edit_topic_id" required>
                    <option value="">Select Subject</option>
                    @foreach(Topic::all() as $topic)
                        <option value="{{ $topic->id }}" {{ $topic->id==$question->topic_id?'selected':'' }}>{{ $topic->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="edit_difficulty_level" class="form-label fw-bold">Difficulty Level:</label>
                <select class="form-control form-select" name="difficulty_level" id="edit_difficulty_level" required>
                    <option value="">Select Difficulty</option>
                    <option value="simple" {{ $question->difficulty_level=='simple'?'selected':'' }}>Simple</option>
                    <option value="moderate" {{ $question->difficulty_level=='moderate'?'selected':'' }}>Moderate</option>
                    <option value="difficult" {{ $question->difficulty_level=='difficult'?'selected':'' }}>Difficult</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="edit_active" class="form-label fw-bold">Status:</label>
                <select class="form-control form-select" name="active" id="edit_active" required>
                    <option value="">Select Status</option>
                    <option value="true"{{ $question->active=='true'?'selected':'' }}>Active</option>
                    <option value="false"{{ $question->active=='false'?'selected':'' }}>Inactive</option>
                </select>
            </div>
        </div>
    </div>
    
    <div class="form-group mb-4">
        <label for="edit_title" class="form-label fw-bold">Question:</label>
        <textarea class="form-control editor" name="title" id="edit_title" placeholder="Enter question text" required rows="4">{{ $question->title }}</textarea>
    </div>
    
    <div class="mb-4">
        <h6 class="fw-bold mb-3">Answer Options</h6>
        @foreach($question->answer_options as $option)
            <div class="form-group mb-3">
                <label class="form-label">Option {{ \App\Helper::indexToChar($loop->index) }}</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <input type="radio" name="correctness" {{ $option->correctness==1?'checked':'' }} value="{{ $option->id }}" class="form-check-input mt-0">
                    </span>
                    <textarea class="form-control editor" name="question_option[]" placeholder="Enter option text" rows="2">{{ $option->question_option }}</textarea>
                </div>
                <small class="form-text text-muted">Select the radio button to mark this as the correct answer</small>
            </div>
        @endforeach
    </div>
    
    <div class="d-flex justify-content-end gap-2">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="las la-times me-2"></i>Cancel
        </button>
        <button type="submit" class="btn btn-primary">
            <i class="las la-save me-2"></i>Save Changes
        </button>
    </div>
</form>

<script>
$(document).ready(function() {
    // Handle subject change for topics loading
    $('#edit_subject_id').on('change', function() {
        let id = $(this).val();
        if (id) {
            $.get('{{ route('admin.authoring.topics', ':id') }}'.replace(':id', id))
                .done(function(data) {
                    $('#edit_topic_id').html('<option value="">Select Subject</option>' + data);
                })
                .fail(function() {
                    console.error('Error loading topics');
                });
        } else {
            $('#edit_topic_id').html('<option value="">Select Subject</option>');
        }
    });
    
    // Handle form submission
    $('#edit-question-form').on('submit', function(e) {
        e.preventDefault();
        
        // Show loading state
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.prop('disabled', true).html('<i class="las la-spinner fa-spin me-2"></i>Saving...');
        
        // Update TinyMCE content before submitting
        if (typeof tinymce !== 'undefined') {
            tinymce.triggerSave();
        }
        
        $.post($(this).attr('action'), $(this).serialize())
            .done(function(response) {
                if (response.success) {
                    $('#edit-question-modal').modal('hide');
                    
                    // Show success notification
                    showNotification('Question updated successfully', 'success');
                    
                    // Reload questions list
                    if (typeof loadQuestions === 'function') {
                        loadQuestions();
                    }
                } else {
                    showNotification(response.message || 'Error updating question', 'error');
                }
            })
            .fail(function(xhr) {
                let errorMessage = 'Error updating question';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = Object.values(xhr.responseJSON.errors).flat();
                    errorMessage = errors.join(', ');
                }
                showNotification(errorMessage, 'error');
            })
            .always(function() {
                // Restore button state
                submitBtn.prop('disabled', false).html(originalText);
            });
    });
});
</script>