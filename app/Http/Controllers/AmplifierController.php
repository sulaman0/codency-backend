<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AmplifierController extends Controller
{
    public function amplifierStart()
    {
        return view("amplifier/index", [
            'userEmail' => Auth::user()->email,
        ]);
    }
}
