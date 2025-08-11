@if(count($questions) > 0)
    @if($bulkMode)
        <div class="row mb-3">
            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="select-all">
                    <label class="form-check-label fw-bold" for="select-all">
                        Select All Questions ({{ count($questions) }})
                    </label>
                </div>
            </div>
        </div>
    @endif

    @foreach($questions as $question)
        <div class="card mb-3 border-start 
            @if($question->difficulty_level == 'simple') border-success border-3
            @elseif($question->difficulty_level == 'moderate') border-warning border-3  
            @elseif($question->difficulty_level == 'difficult') border-danger border-3
            @else border-secondary border-3
            @endif" data-question-id="{{ $question->id }}">
            
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center gap-3">
                            @if($bulkMode)
                                <input type="checkbox" class="form-check-input question-checkbox" value="{{ $question->id }}">
                            @endif
                            <div>
                                <h6 class="mb-1 fw-bold">Question #{{ $question->id }}</h6>
                                <div class="d-flex gap-2 flex-wrap mb-2">
                                    <span class="badge 
                                        @if($question->difficulty_level == 'simple') bg-success
                                        @elseif($question->difficulty_level == 'moderate') bg-warning text-dark
                                        @elseif($question->difficulty_level == 'difficult') bg-danger
                                        @else bg-secondary
                                        @endif">
                                        {{ ucfirst($question->difficulty_level ?? 'Unknown') }}
                                    </span>
                                    <small class="text-muted">
                                        <i class="las la-book me-1"></i>{{ $question->subject->name ?? 'No Subject' }}
                                    </small>
                                    <small class="text-muted">
                                        <i class="las la-bookmark me-1"></i>{{ $question->topic->name ?? 'No Topic' }}
                                    </small>
                                </div>
                                <small class="text-muted">
                                    <i class="las la-clock me-1"></i>Updated {{ $question->updated_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-primary btn-sm edit-question" data-question-id="{{ $question->id }}" title="Edit Question">
                                <i class="las la-edit"></i>
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" title="Duplicate Question">
                                <i class="las la-copy"></i>
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-sm delete-question" data-question-id="{{ $question->id }}" title="Delete Question">
                                <i class="las la-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <div class="question-content mb-4">
                    <h6 class="fw-bold mb-3">
                        @php
                            $title = $question->title;
                            $title = str_replace('<p>', '', $title);
                            $title = str_replace('</p>', '', $title);
                            echo $title;
                        @endphp
                    </h6>
                </div>
                
                <div class="question-options">
                    <h6 class="small text-muted mb-3">ANSWER OPTIONS:</h6>
                    @if($question->answer_options && count($question->answer_options) > 0)
                        <div class="list-group">
                            @php $optionLabels = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H']; @endphp
                            @foreach($question->answer_options as $index => $option)
                                <div class="list-group-item d-flex align-items-start
                                    @if($option->correctness == 1) 
                                        list-group-item-success border-success
                                    @endif">
                                    <div class="me-3">
                                        <span class="badge 
                                            @if($option->correctness == 1) 
                                                bg-success 
                                            @else 
                                                bg-secondary 
                                            @endif 
                                            rounded-circle d-flex align-items-center justify-content-center" 
                                            style="width: 32px; height: 32px; font-weight: bold; font-size: 14px;">
                                            {{ $optionLabels[$index] ?? ($index + 1) }}
                                        </span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="option-text 
                                            @if($option->correctness == 1) 
                                                fw-bold text-success 
                                            @endif d-flex align-items-center">
                                            <span>
                                                @php
                                                    $optionText = $option->question_option;
                                                    $optionText = str_replace('<p>', '', $optionText);
                                                    $optionText = str_replace('</p>', '', $optionText);
                                                    echo $optionText;
                                                @endphp
                                            </span>
                                            @if($option->correctness == 1)
                                                <i class="las la-check-circle text-success ms-2" style="font-size: 1.2rem;"></i>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="las la-exclamation-triangle me-1"></i>
                            No answer options available for this question.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach

    @if(isset($showPagination) && $showPagination && $questions instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
        <div class="d-flex justify-content-center mt-4">
            {{ $questions->appends(request()->query())->links() }}
        </div>
    @endif
@else
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="las la-search display-1 text-muted mb-3"></i>
            <h4 class="text-muted mb-3">No Questions Found</h4>
            <p class="text-muted mb-4">No questions match your current search criteria. Try adjusting your filters or search terms.</p>
            <button type="button" class="btn btn-primary" id="clear-filters">
                <i class="las la-refresh me-2"></i>
                Clear All Filters
            </button>
        </div>
    </div>
@endif

<script>
// Bind clear filters functionality if empty state is shown
$('#clear-filters').on('click', function() {
    if (typeof resetAllFilters === 'function') {
        resetAllFilters();
    }
});
</script>