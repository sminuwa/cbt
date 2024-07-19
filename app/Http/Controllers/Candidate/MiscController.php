<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\ScheduledCandidate;
use App\Models\TimeControl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MiscController extends Controller
{
    //

    public function instruction(){
        return view('pages.candidate.test.instruction');
    }
}
