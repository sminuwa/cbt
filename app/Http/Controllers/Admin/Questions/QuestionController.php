<?php

namespace App\Http\Controllers\Admin\Questions;

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
        //
    }

    public function index()
    {
        return view('pages.admin.dashboard.index');
    }

    /**
     * Show questions management index
     */
    public function questions()
    {
        return view('pages.admin.questions.index');
    }

}
