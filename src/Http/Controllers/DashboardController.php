<?php

namespace HaschaDev\Http\Controllers;

use HaschaDev\Dev;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(Request $request, Dev $dev): View
    {
        // dd($dev);
        return view('dashboard');
    }
}
