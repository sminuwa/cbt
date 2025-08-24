<!-- Questions Results -->
<div class="mb-3">
    <div class="d-flex justify-content-between align-items-center">
        <div>
                <h5 class="mb-0">
                    @if(isset($mode) && $mode === 'composed')
                        <i class="las la-check-circle me-2 text-info"></i>Composed Questions
                    @else
                        <i class="las la-search me-2 text-success"></i>Question Bank Results
                    @endif
                </h5>
            <small class="text-muted">
                Found {{ $statistics['count'] }} questions 
                <span class="badge bg-success badge-sm ms-1">{{ $statistics['easy'] }} easy</span>
                <span class="badge bg-warning badge-sm ms-1">{{ $statistics['moderate'] }} moderate</span>
                <span class="badge bg-danger badge-sm ms-1">{{ $statistics['difficult'] }} hard</span>
            </small>
        </div>
        <div class="d-flex align-items-center gap-3">
            <!-- Pagination Controls -->
            <div class="btn-group" role="group">
                <button id="previous" class="btn btn-outline-primary btn-xs" title="Previous Page" {{ $page == 1 ? 'disabled' : '' }}>
                    <i class="las la-arrow-left"></i> 
                </button>
                <button id="next" class="btn btn-outline-primary btn-xs" title="Next Page" {{ $page * $pageSize >= $statistics['count'] ? 'disabled' : '' }}>
                     <i class="las la-arrow-right"></i>
                </button>
            </div>
            
            <!-- Select All Toggle -->
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="select-all">
                <label class="form-check-label" for="select-all">
                    <small>Select All</small>
                </label>
            </div>
        </div>
    </div>
</div>
<div class="mt-3">
    @if($statistics['count'] > 0)
        <form id="questions-form" method="post">
            @csrf
            <input type="hidden" id="section_id" name="test_section_id">
            
            @foreach($questions as $index => $question)
                @php
                    $difficultyColor = $question->difficulty_level == 'simple' ? 'success' : 
                                        ($question->difficulty_level == 'moderate' ? 'warning' : 'danger');
                    $difficultyText = $question->difficulty_level == 'simple' ? 'Easy' : 
                                    ($question->difficulty_level == 'moderate' ? 'Moderate' : 'Hard');
                @endphp
                <div class="card mb-3 question-card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="d-flex align-items-start">
                                <span class="badge bg-secondary me-2">{{ (($page - 1) * $pageSize) + $index + 1 }}</span>
                                <div class="flex-grow-1">
                                    <div class="question-text">
                                        {!! $question->title !!}
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-{{ $difficultyColor }}">{{ $difficultyText }}</span>
                                <div class="form-check form-switch">
                                    <input class="form-check-input selection" type="checkbox" 
                                            name="bank_ids[]" value="{{ $question->id }}"
                                            id="question-{{ $question->id }}" {{ $question->checked ? 'checked' : '' }}>
                                    <label class="form-check-label" for="question-{{ $question->id }}">
                                        <small>Select</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Answer Options (Hidden by default) -->
                    <div id="options-{{ $question->id }}" class="card-body border-top" style="display: none;">
                        <h6 class="text-muted mb-3">
                            <i class="las la-list-ol me-1"></i>Answer Options
                        </h6>
                        <ol class="list-group list-group-flush ordered-list">
                            @foreach($question->answer_options as $option)
                                <li class="list-group-item {{ $option->correctness == '1' ? 'list-group-item-success' : '' }}">
                                    {{ $option->question_option }}
                                    @if($option->correctness == '1')
                                        <i class="las la-check-circle text-success float-end"></i>
                                    @endif
                                </li>
                            @endforeach
                        </ol>
                    </div>
                    
                    <!-- Question Actions -->
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <button type="button" class="btn btn-outline-info btn-sm full-question" data-id="{{ $question->id }}">
                                <i class="las la-eye me-1"></i>Show Options
                            </button>
                            <small class="text-muted">
                                <i class="las la-layer-group me-1"></i>Difficulty: {{ $difficultyText }}
                                @if(isset($question->topic))
                                    | <i class="las la-tag me-1"></i>{{ $question->topic->name }}
                                @endif
                            </small>
                        </div>
                    </div>
                </div>
            @endforeach
        </form>
        
        <!-- Bottom Controls -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <small class="text-muted me-3">
                        Showing {{ (($page - 1) * $pageSize) + 1 }} to {{ min($page * $pageSize, $statistics['count']) }} of {{ $statistics['count'] }} questions
                    </small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-end align-items-center gap-3">
                    <!-- Select All Toggle -->
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="select-all-bottom">
                        <label class="form-check-label" for="select-all-bottom">
                            <small>Select All on Page</small>
                        </label>
                    </div>
                    
                    <!-- Pagination Controls -->
                    <div class="btn-group" role="group">
                        <button id="previous-bottom" class="btn btn-primary btn-xs" title="Previous Page" {{ $page == 1 ? 'disabled' : '' }}>
                            <i class="las la-arrow-left"></i> 
                        </button>
                        <span class="btn btn-outline-primary btn-xs disabled">
                            Page {{ $page }} of {{ ceil($statistics['count'] / $pageSize) }}
                        </span>
                        <button id="next-bottom" class="btn btn-primary btn-xs" title="Next Page" {{ $page * $pageSize >= $statistics['count'] ? 'disabled' : '' }}>
                             <i class="las la-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <div class="mb-3">
                <i class="las la-search text-muted" style="font-size: 4rem;"></i>
            </div>
            <h5 class="text-muted">No Questions Found</h5>
            <p class="text-muted mb-4">No questions match your current filter criteria. Try adjusting your filters or search terms.</p>
            <div class="d-flex justify-content-center gap-2">
                <button class="btn btn-outline-primary" onclick="$('#difficulty').val('%'); $('#topic').val('%'); $('#author').val('%'); $('#phrase').val(''); loadQuestions();">
                    <i class="las la-undo me-1"></i>Clear Filters
                </button>
                <button class="btn btn-primary" onclick="loadQuestions();">
                    <i class="las la-sync me-1"></i>Refresh
                </button>
            </div>
        </div>
    @endif
</div>

<script>
    $(document).ready(function() {
        // Sync both select-all checkboxes
        $('#select-all, #select-all-bottom').on('change', function() {
            const isChecked = $(this).is(':checked');
            $('#select-all, #select-all-bottom').prop('checked', isChecked);
        });
        
        // Sync bottom pagination with top pagination
        $('#previous-bottom').on('click', function() {
            $('#previous').click();
        });
        
        $('#next-bottom').on('click', function() {
            $('#next').click();
        });
    });
</script>
