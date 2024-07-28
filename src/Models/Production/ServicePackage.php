<?php

namespace HaschaDev\Models\Production;

use Publisher\Fundamentals\Config\DBConnect;
use HaschaDev\Models\Production\Service;
use HaschaDev\Database\TimestampModel;
use Illuminate\Database\Eloquent\Model;
use HaschaDev\Database\Abstracts\Modelable;
use Illuminate\Database\Eloquent\SoftDeletes;
use HaschaDev\Models\Production\ServicePackagePrice;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServicePackage extends Model implements Modelable
{
    use SoftDeletes, TimestampModel;
    
    protected $fillable = [
        'service_id',
        'code',
        'name',
        'description',
        'alias',
        'tagline',
        'details'
    ];

    protected $connection = DBConnect::PRODUCTION->value;
    protected $table = 'service_packages';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    /**
     * relation to Service
     * 
     */
    protected function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    /**
     * relation to Service Package Price
     * 
     */
    protected function servicePackagePrice(): HasOne
    {
        return $this->hasOne(ServicePackagePrice::class, 'service_package_id', 'id');
    }
}
