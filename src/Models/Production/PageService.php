<?php

namespace HaschaDev\Models\Production;

use Illuminate\Support\Str;
use Publisher\Fundamentals\Config\DBConnect;
use HaschaDev\Models\Production\Service;
use HaschaDev\Models\Production\PageFeature;
use HaschaDev\Database\TimestampModel;
use Illuminate\Database\Eloquent\Model;
use HaschaDev\Database\Abstracts\Modelable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageService extends Model implements Modelable
{
    use SoftDeletes, TimestampModel;
    
    protected $fillable = [
        'service_id',
        'route_name',
        'name',
        'title',
        'tagline',
        'description',
        'content'
    ];

    protected $connection = DBConnect::PRODUCTION->value;
    protected $table = 'page_services';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    /**
     * mutators: name
     * 
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => Str::title($value)
        );
    }

    /**
     * mutators: title
     * 
     */
    protected function title(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => Str::title($value)
        );
    }

    /**
     * relation to Service
     * 
     */
    protected function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    /**
     * relation to Page Feature
     * 
     */
    protected function pageFeatures(): HasMany
    {
        return $this->hasMany(PageFeature::class, 'page_service_id', 'id');
    }
}
