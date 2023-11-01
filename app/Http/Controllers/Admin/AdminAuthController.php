<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminAuthController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }
    public function handleLogin(Request $request)
    {

        try {
            DB::connection()->getPdo();
            if (DB::connection()->getDatabaseName()) {
                $credentials = $request->validate([
                    'email' => ['required', 'email'],
                    'password' => ['required'],
                ]);
                if (Auth::guard('webadmins')->attempt($credentials)) {
                    return redirect()->route('admin.dashboard');
                }
                return redirect()->back()->withErrors([
                    'email' => 'ไม่พบผู้ใช้งานในระบบ',
                ]);
            }
        } catch (\Exception $e) {
            die("Could not connect to the database. " . $e->getMessage());
        }

        // If the database connection is working, proceed with the login attempt

    }
    public function logout()
    {

        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
