<?php

namespace HaschaDev\Models\Production;

use Illuminate\Support\Str;
use HaschaDev\Database\DBConnect;
use HaschaDev\Models\Production\Feature;
use HaschaDev\Models\Production\Service;
use HaschaDev\File\Media\Imageable;
use HaschaDev\Database\TimestampModel;
use HaschaDev\Models\Production\FeatureModel;
use Illuminate\Database\Eloquent\Model;
use HaschaDev\Database\Abstracts\Modelable;
use Illuminate\Database\Eloquent\SoftDeletes;
use HaschaDev\File\Database\WithFileMediaLabel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ApplicationProduct extends Model implements Modelable
{
    use SoftDeletes, TimestampModel, WithFileMediaLabel;
    protected const LOGO_MEDIA = Imageable::APP_LOGO;
    
    protected $fillable = [
        'code',
        'name',
        'description',
        'brand',
        'tagline',
        'details',
    ];

    protected $connection = DBConnect::PRODUCTION->value;
    protected $table = 'application_products';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    /**
     * Mutators: code
     * 
     */
    protected function code(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => strtoupper($value),
        );
    }

    /**
     * Mutators: name
     * 
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => Str::title($value),
        );
    }

    /**
     * relation to Feature Model
     * 
     */
    protected function featureModels(): HasMany
    {
        return $this->hasMany(FeatureModel::class, 'application_product_id', 'id');
    }

    /**
     * relation to Feature
     * 
     */
    protected function features(): HasMany
    {
        return $this->hasMany(Feature::class, 'application_product_id', 'id');
    }

    /**
     * relation to Service
     * 
     */
    protected function services(): HasMany
    {
        return $this->hasMany(Service::class, 'application_product_id', 'id');
    }
}
