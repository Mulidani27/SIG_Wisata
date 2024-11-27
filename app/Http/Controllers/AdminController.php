<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('Admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect("/");
        }

        return redirect()->back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();  // Logout admin
        $request->session()->invalidate();  // Menghapus semua sesi
        $request->session()->regenerateToken();  // Regenerasi token CSRF

        return redirect('/');  // Redirect ke halaman dashboard setelah logout
    }

    public function dashboard()
    {
        return view('dashboard');
    }
}

