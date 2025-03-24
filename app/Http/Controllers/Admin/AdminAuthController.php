<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;


class AdminAuthController extends Controller
{
    //
    function login(Request $request): View|RedirectResponse
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('admin.dashboard.index');
        }
        if ($request->session()->has('errors')) {
            return redirect()->route('login')->with('error', 'Your session has expired. Please log in again.');
        }
        return view('admin.auth.login');
    }

    function PasswordRequest(): View|RedirectResponse
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('admin.dashboard.index');
        }
        return view('admin.auth.forgot-password');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}