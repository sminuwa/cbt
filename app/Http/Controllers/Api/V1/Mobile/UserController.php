<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Get authenticated user information
     */
    public function index(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
            'status' => 'success'
        ]);
    }
}

