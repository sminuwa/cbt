<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CentreController extends Controller
{
    //
    public function index(Request $request){
        $user = $request->user();
        if($user){
            $u = [
                'name' => $user->name,
                'location' => $user->location,
                'username' => $user->api_key,
                'status' => $user->status,
            ];
            return jResponse(true, 'successful', $u);
        }
        return jResponse(false, 'successful');
    }
}
