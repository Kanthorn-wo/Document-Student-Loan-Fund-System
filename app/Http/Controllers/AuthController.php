<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index()
    {
        return view('test');
    }

    public function logout()
    {
        Session::flush();
    }
}