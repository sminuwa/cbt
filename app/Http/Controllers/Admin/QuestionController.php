<?php

namespace App\Http\Controllers\Admin;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\AnswerOption;
use App\Models\AnsweroptionsTemp;
use App\Models\QuestionBank;
use App\Models\QuestionBankTemp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        return view('pages.admin.dashboard.index');
    }

    public function author()
    {
        return view('pages.admin.questions.questions-authoring');
    }

    public function authorPost(Request $request)
    {
        $this->clearTemps(request('subject_id'), request('topic_id'));

        $questions = Helper::extractQuestions(request('content'));

        foreach ($questions as $question) {
            $bank = new  QuestionBankTemp();
            $bank->author = Auth::user()->id;
            $bank->title = $question->text;
            $bank->topic_id = $request->topic_id;
            $bank->subject_id = $request->subject_id;
            if ($question->difficulty != 'S')
                $bank->difficulty_level = $question->difficulty == 'M' ? 'moredifficult' : 'difficult';
            $bank->save();

            $bank_id = $bank->id;

            foreach ($question->options as $option) {
                $answer = new AnsweroptionsTemp();
                $answer->question_option = $option->text;
                $answer->question_bank_temp_id = $bank_id;
                $answer->correctness = $option->isCorrect ? '1' : '0';
                $answer->save();
            }
        }

        return redirect(route('admin.questions.authoring.review', [request('subject_id'), request('topic_id')]));
    }

    public function review($subjectId, $topicId)
    {
        $questions = QuestionBankTemp::where(['subject_id' => $subjectId, 'topic_id' => $topicId, 'author' => Auth::user()->id])
            ->get();

        return view('pages.admin.questions.review', compact('questions', 'subjectId', 'topicId'));
    }

    public function store(Request $request)
    {
        $tempQuestions = QuestionBankTemp::where(
            ['subject_id' => $request->subject_id, 'topic_id' => $request->topic_id, 'author' => Auth::user()->id]
        )->get();

        foreach ($tempQuestions as $tempQuestion) {
            $question = new QuestionBank();
            $question->title = $tempQuestion->title;
            $question->active = $tempQuestion->active;
            $question->author = $tempQuestion->author;
            $question->subject_id = $tempQuestion->subject_id;
            $question->topic_id = $tempQuestion->topic_id;
            $question->difficulty_level = $tempQuestion->difficulty_level;
            $question->save();

            $question_id = $question->id;

            foreach ($tempQuestion->options as $tempOption) {
                $option = new AnswerOption();
                $option->question_bank_id = $question_id;
                $option->correctness = $tempOption->correctness;
                $option->question_option = $tempOption->question_option;
                $option->save();

                $tempOption->delete();
            }

            $tempQuestion->delete();
        }
        return redirect(route('admin.questions.authoring.completed'));
    }

    public function completed()
    {
        return view('pages.admin.questions.completed');
    }

    public function preview()
    {
        return view('pages.admin.questions.preview-questions');
    }

    public function loadPreview(Request $request)
    {
        $where = [];
        $preview = $request->preview;

        if ($request->difficulty_level != '%')
            $where[] = ['difficulty_level' => $request->difficulty_level];

        $questions = QuestionBank::where([
            'subject_id' => $request->subject_id,
            'topic_id' => $request->topic_id,
            'author' => Auth::user()->id])
            ->where($where);

        $questions = $questions->get();

        return view('pages.admin.questions.ajax.ajax-preview-questions', compact('questions', 'preview'));
    }

    public function editQuestions()
    {
        return view('pages.admin.questions.edit-questions-index');
    }

    public function editQuestion(QuestionBank $question)
    {
        return view('pages.admin.questions.edit-question', compact('question'));
    }

    public function storeQuestion(Request $request)
    {
        $question = QuestionBank::where(['id' => $request->question_id])->first();
        $question->title = $request->title;
        $question->active = $request->active;
        $question->subject_id = $request->subject_id;
        $question->topic_id = $request->topic_id;
        $question->difficulty_level = $request->difficulty_level;
        $question->save();

        $index = 0;

        $options = $request->question_option;
        foreach ($question->answer_options as $option) {
            $option->question_option = $options[$index++];
            $option->correctness = $option->id == $request->input('correctness') ? 1 : 0;
            $option->save();
        }

        return redirect(route('admin.questions.authoring.edit.questions'));
    }

    private function clearTemps($subjectId, $topicId)
    {
        $questions = QuestionBankTemp::where(['subject_id' => $subjectId, 'topic_id' => $topicId, 'author' => Auth::user()->id])->get();
        foreach ($questions as $question) {
            AnsweroptionsTemp::where(['question_bank_temp_id' => $question->id])->delete();
            $question->delete();
        }
    }

}
