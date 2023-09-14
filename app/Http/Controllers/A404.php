<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class A404 extends Controller
{
    public function a404(){
        return view('404');
    }
}
