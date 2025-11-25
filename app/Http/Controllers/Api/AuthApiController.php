<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class AuthApiController extends Controller
{
    public function login()
    {
        return response()->json(['status' => 'ok']);
    }
}
