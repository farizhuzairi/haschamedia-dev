<?php

namespace HaschaDev\Models;

use Publisher\Fundamentals\Config\DBConnect;
use HaschaDev\Models\Scopes\IsActive;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    protected $fillable = [
        'role_id',
        'permission',
        'model',
        'is_active'
    ];

    protected $connection = DBConnect::BASE->value;
    protected $table = 'role_permissions';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    /**
     * boot
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new IsActive);
    }
}
