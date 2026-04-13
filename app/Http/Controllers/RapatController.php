<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RapatController extends Controller
{
    public function index()
    {
        return view('pages.rapat.index');
    }
public function zoom()
    {
        // Contoh URL meeting, ganti sesuai kebutuhan atau data dinamis
        $zoomUrl = 'https://us04web.zoom.us/myhome';
        return redirect()->away($zoomUrl);
    }

    public function gmeet()
    {
        $gmeetUrl = 'https://meet.google.com/landing';
        return redirect()->away($gmeetUrl);
    }
}
