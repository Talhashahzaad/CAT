<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class BusinessAuthController extends Controller
{
    //
    function login(): View
    {
        return view('business.auth.login');
    }

    function forgotPassword(): View
    {
        return view('business.auth.forgot-password');
    }
}
