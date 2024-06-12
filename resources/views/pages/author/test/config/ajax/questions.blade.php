<div class="card border-info">
    <div class="card-header border-info">
        <div class="row">
            <div class="d-flex justify-content-between">
                <h4 class="card-title">
                    <span>
                        {{count($questions)}} questions selected
                        ({{$statistics['easy']}} easy,
                        {{$statistics['moderate']}} modeerate,
                        {{$statistics['difficult']}} difficult)
                    </span>
                </h4>
                <div>
                    <label for="select-all">Unselect all</label>
                    <input id="select-all" class="btn btn-info text-light" checked type="checkbox">
                </div>
            </div>
        </div>
    </div>
    <div class="card-body pt-3">
        @foreach($questions as $question)
            <div class="row mb-3">
                <div class="col-12">
                    <div class="mt-3 d-flex justify-content-between">
                        <p>
                            @php echo $question->title; @endphp
                        </p>
                        <div>
                            <label for="question-{{$question->id}}">Unselect</label>
                            <input class="btn btn-info selection" data-id="{{$question->id}}"
                                   checked type="checkbox">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a class="btn btn-sm btn-outline-light text-info" href="javascript:;">Full Question</a>
                        <span>Difficulty: {{$question->difficulty_level=='simple'?'Easy':($question->difficulty_level=='moderate'?'Medium':'Hard')}}</span>
                    </div>
                    <hr>
                </div>
            </div>
        @endforeach
    </div>
</div>
