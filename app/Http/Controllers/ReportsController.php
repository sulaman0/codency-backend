<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportsController extends Controller
{
    function index()
    {
        return view('reports.code_pressed');
    }
}
