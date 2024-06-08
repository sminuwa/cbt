<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Http\Request;

class MiscController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function venues($centre_id)
    {
        return Venue::where(['centre_id' => $centre_id])->get();
    }
}
