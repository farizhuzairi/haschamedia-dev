<?php

namespace HaschaDev\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Logout
{
    public function __construct(private Request $request)
    {}

    /**
     * clearance,
     * memastikan data pengguna dan menghapus sesi
     * 
     */
    public function clearance(User $user): bool
    {
        if(! $user || ! $this->request) return false;

        /**
         * logout session, clearance
         */
        Auth::logout();
        $this->request->session()->invalidate();
        $this->request->session()->regenerateToken();

        if(! Auth::check()) return true;
        return false;
    }
}