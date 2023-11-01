<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffAuthController extends Controller
{
    public function login()
    {
        return view('staff.login');
    }

    public function handleLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::guard('webstaffs')->attempt($credentials)) {
            return redirect()->route('staff.dashboard');
        }
        return redirect()->back()->withErrors([
            'email' => 'ไม่พบผู้ใช้งานในระบบ',
        ]);
    }
    public function logout()
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('staff.login');
    }
}