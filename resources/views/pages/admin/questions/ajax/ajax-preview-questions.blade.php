@if(count($questions)>0)
    <form action="" method="post">
        @csrf
        {{--        @if($preview)--}}
        {{--            <div class="row mb-4">--}}
        {{--                <div class="col-12 d-flex justify-content-end">--}}
        {{--                    Select all <input style="margin-left: 10px; margin-right: 25px;" id="check-all" type="checkbox">--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        @endif--}}
        @foreach($questions as $question)
            <div
                class="card border-{{$question->difficulty_level=='simple'?'info':($question->difficulty_level=='moderate'?'warning':'danger')}}">
                <div
                    class="card-header @if(!$preview) @endifborder-{{$question->difficulty_level=='simple'?'info':($question->difficulty_level=='moderate'?'warning':'danger')}} @endif">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="card-title">
                                @if(!$preview)
                                    ({{$loop->iteration}})
                                @endif
                                @php
                                    $title = $question->title;
                                    $title = str_replace('<p>', '', $title);
                                    $title = str_replace('</p>', '', $title);
                                    echo $title;
                                @endphp
                            </h4>
                        </div>
                        <div class="mt-4 d-flex justify-content-end">
                            @if(!$preview)
                                <a href="{{ route('admin.questions.authoring.edit.question',[$question->id]) }}"
                                   class="btn btn-sm btn-warning text-white"><i class="fa fa-edit"></i>
                                </a>
                                &nbsp;
                                <a href="{{ route('admin.questions.authoring.edit.question',[$question->id]) }}"
                                   class="btn btn-sm btn-danger text-white m-l-5"><i class="fa fa-trash"></i>
                                </a>
{{--                            @else--}}
                                {{--                                <input class="selection" type="checkbox" name="previews[]" value="{{ $question->id }}">--}}
                            @endif
                        </div>
                    </div>
                </div>
                {{--                @if(!$preview)--}}
                <div class="card-body pt-2 pb-2  mt-1 mb-1">
                    <div class="row">
                        <div class="row pb-3 pt-2">
                            <ol class="list-group list-group-flush ordered-list">
                                @foreach($question->answer_options as $option)
                                    <li class="list-group-item {{$option->correctness=='1'?'list-group-item-success':''}}">
                                        @php
                                            $option = $option->question_option;
                                            $option = str_replace('<p>', '', $option);
                                            $option = str_replace('</p>', '', $option);
                                            echo $option;
                                        @endphp
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>
                {{--                @endif--}}
            </div>
        @endforeach
        {{--        @if($preview)--}}
        {{--            <div class="d-flex justify-content-end">--}}
        {{--                <input class="btn btn-sm btn-info text-white" type="submit" value="Preview Selected">--}}
        {{--            </div>--}}
        {{--        @endif--}}
    </form>
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
