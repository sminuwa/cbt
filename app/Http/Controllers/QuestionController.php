<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\AnsweroptionsTemp;
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
            $bank->save();

            $bank_id = $bank->id;

            foreach ($question->options as $option) {
                $answer = new AnsweroptionsTemp();
                $answer->question_option = $option->text;
                $answer->question_bank_id = $bank_id;
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

        return view('pages.admin.questions.review', compact('questions'));
    }

    public function store(Request $request)
    {

    }

    private function clearTemps($subjectId, $topicId)
    {
        $questions = QuestionBankTemp::where(['subject_id' => $subjectId, 'topic_id' => $topicId, 'author' => 1])->get();

        foreach ($questions as $question) {
            AnsweroptionsTemp::where(['question_bank_id' => $question->id])->delete();

            $question->delete();
        }

    }

}
