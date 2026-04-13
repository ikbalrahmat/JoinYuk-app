<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KuisController extends Controller
{
    public function index()
    {
        return view('pages.kuis.index');
    }
}
