@php use App\Models\AnswerOption;use App\Models\Score;use App\Models\TestSection;use Illuminate\Support\Facades\DB; @endphp
@if(count($candidates)>0)
    <hr>
    @foreach($candidates as $candidate)
        <div class="card border-info">
            <div class="card-body p-2">
                <div>
                    <h3 class="card-title d-flex justify-content-center mb-1">
                        <span><strong>{{$candidate->indexing}}</strong></span>
                    </h3>
                    <h3 class="d-flex justify-content-center">
                        <span>{{strtoupper($candidate->surname)}}, {{$candidate->firstname}} {{$candidate->other_names}}</span>
                    </h3>
                </div>
            </div>
        </div>

        @foreach($subjects as $subject)
            @php
                $sections = TestSection::select('id', 'title', 'instruction')
                                     ->where('test_subject_id', $subject->id)->get();
            @endphp
            @foreach($sections as $section)
                <div class="card border-info">
                    <div class="card-header border-info">
                        <div>
                            <h4 class="card-title d-flex justify-content-center mb-1">
                                <span><strong>{{$subject->subject_code}} - {{$subject->name}}</strong></span>
                            </h4>
                            <h4 class="d-flex justify-content-center">
                                <span> {{$section->title}}</span>
                            </h4>
                            <div class="d-flex justify-content-center">
                                @php echo $section->instruction; @endphp
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @php
                            $questions = DB::table('presentations')
                              ->join('test_sections', 'test_sections.id', '=', 'presentations.test_section_id')
                              ->join('question_banks', 'question_banks.id', '=', 'presentations.question_bank_id')
                              ->join('test_subjects', 'test_subjects.id', '=', 'test_sections.test_subject_id')//
                              ->select('question_banks.id', 'question_banks.title as question')
                              ->where([
                                  'test_sections.id' => $section->id,
                                  'presentations.test_config_id' => $config,
                                  'presentations.scheduled_candidate_id' => $candidate->id
                              ])
                              ->distinct('presentations.question_bank_id')
                              ->get();
                        @endphp

                        @foreach($questions as $question)
                            @php
                                $options = AnswerOption::select('id', 'question_option as option', 'correctness')
                                   ->where('question_bank_id', $question->id)->get();
                               $selection = Score::select('answer_option_id as selection')
                                   ->where([
                                       'test_config_id' => $config,
                                       'question_bank_id' => $question->id,
                                       'scheduled_candidate_id' => $candidate->id
                                   ])->pluck('selection')->first();
                            @endphp
                            <h4>({{$loop->iteration}}) {{ $question->question }}</h4>
                            <div class="row p-4">
                                <ol class="list-group list-group-flush ordered-list">
                                    @foreach($options as $option)
                                        <li class="list-group-item {{$selection==$option->id?($option->correctness=='1'?'list-group-item-success':'list-group-item-danger'):''}}">{{ $option->option }}</li>
                                    @endforeach
                                </ol>
                            </div>
                            <hr>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endforeach
    @endforeach
@else
    <div class="card border-info">
        <div class="card-header">
            <h4 class="card-title">&nbsp;</h4>
        </div>
        <div class="card-body pt-2 pb-2  mt-1 mb-1">
            <div class="row">
                <div class="row pb-5 pt-5">
                    <p class="text-center"> No presentation record found</p>
                </div>
            </div>
        </div>
    </div>
@endif
