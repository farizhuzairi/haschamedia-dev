<?php

namespace HaschaDev\Auth;

use Illuminate\Support\Facades\Auth;

class Login
{
    /**
     * authentcation,
     * memastikan kredensial data pengguna
     * dan memulai sesi
     * 
     */
    public function authentcation(string $email, string $password, bool $rememberMe = false): bool
    {
        $credentials = [
            'email'    => (string) $email,
            'password' => (string) $password,
        ];
        $remember = (bool) $rememberMe;

        $auth = Auth::attempt($credentials, $remember);
        if($auth) return true;
        return false;
    }

    /**
     * validation,
     * form data login
     * 
     */
    public function validation(): array
    {
        return [
            'email' => [
                'required',
                'email',
                'max:150'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:100'
            ],
            'rememberMe' => [
                'required',
                'boolean'
            ]
        ];
    }
}