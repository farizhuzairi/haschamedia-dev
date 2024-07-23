<?php

namespace HaschaDev\Http\Controllers\Integration;

use Illuminate\View\View;
use App\Http\Controllers\Controller;

class IntegrationController extends Controller
{
    public function index(): View
    {
        return view('integration.index');
    }
}
