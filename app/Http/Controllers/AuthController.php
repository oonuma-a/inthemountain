<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function auth_index_get(Request $request){
        return view('auth.index');
    }
}
