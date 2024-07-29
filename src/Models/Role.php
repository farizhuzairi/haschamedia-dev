<?php

namespace HaschaDev\Models;

use HaschaDev\Roleable;
use HaschaDev\Models\RolePermission;
use Publisher\Configurations\DBConnect;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'role',
        'description',
    ];

    protected $connection = DBConnect::BASE->value;
    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    /**
     * appends
     */
    protected $appends = [
        'roleable'
    ];

    /**
     * roleable mutators
     */
    protected function roleable(): Attribute
    {
        return Attribute::make(
            get: fn (string $value, array $attributes) => Roleable::tryFrom($attributes['role']),
        );
    }

    /**
     * relation to role permission
     */
    public function permissions(): HasMany
    {
        return $this->hasMany(RolePermission::class, 'role_id', 'id');
    }
}
