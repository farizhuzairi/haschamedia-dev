<?php

namespace HaschaDev\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index(Request $request): View
    {
        return view('index');
    }
}
