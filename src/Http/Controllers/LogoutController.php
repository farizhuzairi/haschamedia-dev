<?php

namespace HaschaDev\Http\Controllers;

use HaschaDev\Auth\Logout;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class LogoutController extends Controller
{
    public function index(Logout $log): RedirectResponse
    {
        if($log->clearance(Auth::user()) && Auth::check()) return redirect(route('login'));
        return redirect(route('dashboard'));
    }
}
