<?php

namespace HaschaDev\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function login(): View
    {
        return view('auth.login');
    }

    public function register(): View
    {
        return view('auth.register');
    }
}
