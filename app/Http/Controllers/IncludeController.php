<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IncludeController extends Controller
{
    public function sidebar(){
        return view('include.sidebar');
    }
    public function header(){
        return view('include.header');
    }
    public function footer(){
        return view('include.footer');
    }

}
