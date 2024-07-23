<?php

namespace HaschaDev\Observers;

use App\Models\User;
use HaschaDev\Roleable;
use HaschaDev\HaschaMedia;
use HaschaDev\Models\Role;

class UserObserver
{
    public function created(User $user): void
    {
        $roleable = $user->email === HaschaMedia::AUTHOR ? Roleable::MASTER : Roleable::GUEST;
        $role = Role::create([
            'user_id' => $user->id,
            'name' => $roleable->value,
            'role' => $roleable->name,
            'description' => "{$user->name} role as {$roleable->value}",
        ]);

        if(! $role) throw new \Exception("Gagal membuat Role baru. error_in_PHP_class: " . __CLASS__);
    }
}