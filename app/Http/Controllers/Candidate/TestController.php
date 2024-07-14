<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    //

    public function question(){
        //logic to get questions from question
        $candidate = auth()->user();
        $test = session('test');
        $scheduled_candidate = session('scheduled_candidate');
        $presentations = $candidate->presentation($test->id,$scheduled_candidate->id);
        return $presentations;
        if(!$presentations){
            //getting the question goes here
        }
        return view('pages.candidate.test.question');
    }

}
