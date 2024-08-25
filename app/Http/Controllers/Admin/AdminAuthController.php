<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;


class AdminAuthController extends Controller
{
    //
    function login(): View
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('admin.dashboard.index');
        }
        return view('admin.auth.login');
    }

    function PasswordRequest(): View
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('admin.dashboard.index');
        }
        return view('admin.auth.forgot-password');
    }
}
