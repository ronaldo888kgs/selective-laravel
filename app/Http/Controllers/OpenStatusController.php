<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OpenStatusController extends Controller
{
    //
    public function __invoke()
    {
        return view('open_status');
        
    }

    public function index()
    {
        __invoke();
    }
}
