@if(count($questions)>0)
    @foreach($questions as $question)
        <div class="card border-info">
            <div class="card-header">
                <h4 class="card-title">({{$loop->iteration}}) {{ $question->title }}</h4>
            </div>
            <div class="card-body pt-2 pb-2  mt-1 mb-1">
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
        </div>
    @endforeach
@else
    <div class="card border-info">
        <div class="card-header">
            <h4 class="card-title">&nbsp;</h4>
        </div>
        <div class="card-body pt-2 pb-2  mt-1 mb-1">
            <div class="row">
                <div class="row pb-5 pt-5">
                    <p class="text-center"> No question(s) authored for the above selection</p>
                </div>
            </div>
        </div>
    </div>
@endif
