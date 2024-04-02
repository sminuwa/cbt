<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\AnswerOption;
use App\Models\AnsweroptionsTemp;
use App\Models\QuestionBank;
use App\Models\QuestionBankTemp;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
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
            $bank->author = 1;
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

        return redirect(route('questions.authoring.review', [request('subject_id'), request('topic_id')]));
    }

    public function review($subjectId, $topicId)
    {
        $questions = QuestionBankTemp::where(['subject_id' => $subjectId, 'topic_id' => $topicId, 'author' => 1])
            ->get();

        return view('pages.admin.questions.review', compact('questions', 'subjectId', 'topicId'));
    }

    public function store(Request $request)
    {
        $tempQuestions = QuestionBankTemp::where(
            ['subject_id' => $request->subject_id, 'topic_id' => $request->topic_id, 'author' => 1]
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
        return redirect(route('questions.authoring.completed'));
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
        $questions = QuestionBank::where(
            ['subject_id' => $request->subject_id, 'topic_id' => $request->topic_id, 'author' => 1]
        )->get();

        return view('pages.admin.questions.ajax.ajax-preview-questions', compact('questions'));
    }

    private function clearTemps($subjectId, $topicId)
    {
        $questions = QuestionBankTemp::where(['subject_id' => $subjectId, 'topic_id' => $topicId, 'author' => 1])->get();

        foreach ($questions as $question) {
            AnsweroptionsTemp::where(['question_bank_temp_id' => $question->id])->delete();

            $question->delete();
        }

    }

}
