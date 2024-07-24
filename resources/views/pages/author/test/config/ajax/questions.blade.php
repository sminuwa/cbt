<div class="card border-info">
    <div class="card-header border-info">
        <div class="row">
            <div class="d-flex justify-content-between">
                <h4 class="card-title">
                    <span>
                        {{$statistics['count']}} questions selected
                        ({{$statistics['easy']}} easy,
                        {{$statistics['moderate']}} moderate,
                        {{$statistics['difficult']}} difficult)
                    </span>
                </h4>
                <div>
                    <label for="select-all">Select all</label>
                    <input id="select-all" class="btn btn-info text-light" type="checkbox">
                </div>
            </div>
        </div>
    </div>
    <div class="card-body pt-3">
        <div class="row pb-3">
            <div class="d-flex justify-content-center">
                <button id="previous" class="btn btn-info text-light m-2" title="Previous"{{$page==1?'disabled':''}} >
                    <i class="fa fa-arrow-left"></i>
                </button>
                <button id="next" class="btn btn-info text-light m-2" title="Next"
                    {{$page*$pageSize>=$statistics['count']?'disabled':''}}>
                    <i class="fa fa-arrow-right"></i>
                </button>
            </div>
        </div>
        <hr>
        <form id="questions-form" method="post">
            @csrf
            <input type="hidden" id="section_id" name="test_section_id">
            @foreach($questions as $question)
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="mt-3 d-flex justify-content-between">
                            <p>
                                @php echo $question->title; @endphp
                            </p>
                            <div>
                                <label for="question-{{$question->id}}">Select</label>
                                <input class="btn btn-info selection" name="bank_ids[]" value="{{$question->id}}"
                                       {{$question->checked?'checked':''}} type="checkbox">
                            </div>
                        </div>
                        <div id="options-{{$question->id}}" style="display: none"
                             class="card-body pt-2 pb-2  mt-1 mb-1">
                            <div class="row">
                                <div class="row pb-3 pt-2">
                                    <ol class="list-group list-group-flush ordered-list">
                                        @foreach($question->answer_options as $option)
                                            <li class="list-group-item {{$option->correctness=='1'?'list-group-item-success':''}}">{{ $option->question_option }}</li>
                                        @endforeach
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a class="btn btn-sm btn-outline-light text-info full-question" data-id="{{$question->id}}"
                               href="javascript:;">
                                Full Question
                            </a>
                            <span>Difficulty: {{$question->difficulty_level=='simple'?'Simple':($question->difficulty_level=='moderate'?'Moderate':'Difficult')}}</span>
                        </div>
                        <hr>
                    </div>
                </div>
            @endforeach
        </form>

        <div class="d-flex justify-content-between">
            <span>&nbsp;</span>
            <div>
                <label for="select-all">Select all</label>
                <input id="select-all" class="btn btn-info text-light" type="checkbox">
            </div>
        </div>
        <div class="row">
            <div class="d-flex justify-content-center">
                <button id="previous" class="btn btn-info text-light m-2" title="Previous"{{$page==1?'disabled':''}} >
                    <i class="fa fa-arrow-left"></i>
                </button>
                <button id="next" class="btn btn-info text-light m-2" title="Next"
                    {{$page*$pageSize>=$statistics['count']?'disabled':''}}>
                    <i class="fa fa-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>
