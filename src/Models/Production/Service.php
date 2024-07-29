<?php

namespace HaschaDev\Models\Production;

use Publisher\Configurations\DBConnect;
use HaschaDev\File\Media\Imageable;
use HaschaDev\Models\Production\PageService;
use HaschaDev\Database\TimestampModel;
use Illuminate\Database\Eloquent\Model;
use HaschaDev\Models\Production\ServicePackage;
use HaschaDev\Database\Abstracts\Modelable;
use HaschaDev\Models\Production\ApplicationProduct;
use Illuminate\Database\Eloquent\SoftDeletes;
use HaschaDev\File\Database\WithFileMediaLabel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model implements Modelable
{
    use SoftDeletes, TimestampModel, WithFileMediaLabel;
    protected const LOGO_MEDIA = Imageable::SERVICE_LOGO;
    
    protected $fillable = [
        'application_product_id',
        'code',
        'name',
        'description',
        'alias',
        'tagline',
        'details',
        'serviceable'
    ];

    protected $connection = DBConnect::PRODUCTION->value;
    protected $table = 'services';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    /**
     * relation to Application Product
     * 
     */
    protected function applicationProduct(): BelongsTo
    {
        return $this->belongsTo(ApplicationProduct::class, 'application_product_id', 'id');
    }

    /**
     * relation to Service Package
     * 
     */
    protected function servicePackages(): HasMany
    {
        return $this->hasMany(ServicePackage::class, 'service_id', 'id');
    }

    /**
     * relation to Page Service
     * 
     */
    protected function pageServices(): HasMany
    {
        return $this->hasMany(PageService::class, 'service_id', 'id');
    }
}
