<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MiscController extends Controller
{
    //

    public function instruction(){
        return view('pages.candidate.test.instruction');
    }
}
