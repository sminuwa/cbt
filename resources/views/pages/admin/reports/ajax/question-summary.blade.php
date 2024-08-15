@if(count($report))
    @foreach($report as $item)
        <div class="card border-info">
            <div class="card-header">
                <h4 class="card-title">{{$item['subject']}}</h4>
            </div>
            <div class="card-body" style="padding: 0.1px !important;"></div>
        </div>

        @if(count($item['questions'])>0)
            @foreach($item['questions'] as $question)
                <div class="card border-info">
                    <div class="card-header border-info">
                        <h4 class="card-title">({{$loop->iteration}}) {{$question['question']}}</h4>
                    </div>
                    <div class="card-body p-1">
                        <table class="table">
                            <tr>
                                <td>Candidate(s) Presented to: {{ $question['presented'] }}</td>
                                <td>Correct Response(s): {{ $question['passed'] }}</td>
                                <td>Incorrect Response(s): {{ $question['failed'] }}</td>
                                <td>No response: {{ $question['no_count'] }}</td>
                            </tr>
                        </table>
                        <div class="p-3" id="options-{{$question['id']}}" style="display: none">
                            <ol class="list-group list-group-flush ordered-list">
                                @foreach($question['options'] as $option)
                                    <li class="list-group-item {{$option['correct']==1?'list-group-item-success':''}}">
                                        <div class="d-flex justify-content-between">
                                            <div>{{$option['option']}}</div>
                                            <div class="ms-2">({{ $option['count']==0?'None':$option['count'] }}) chose
                                                this
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                        <a class="btn btn-sm btn-outline-light text-info full-question"
                           data-id="<?php echo e($question['id']); ?>"
                           href="javascript:;">
                            Show Options
                        </a>
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
                            <p class="text-center"> No question authored for the selected test</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@else
    <div class="card border-info">
        <div class="card-header">
            <h4 class="card-title">&nbsp;</h4>
        </div>
        <div class="card-body pt-2 pb-2  mt-1 mb-1">
            <div class="row">
                <div class="row pb-5 pt-5">
                    <p class="text-center"> No record found</p>
                </div>
            </div>
        </div>
    </div>
@endif
