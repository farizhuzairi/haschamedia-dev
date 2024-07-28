<?php

namespace HaschaDev\Models\Production;

use Illuminate\Support\Str;
use Publisher\Fundamentals\Config\DBConnect;
use HaschaDev\Models\Production\Feature;
use HaschaDev\Database\TimestampModel;
use Illuminate\Database\Eloquent\Model;
use HaschaDev\Database\Abstracts\Modelable;
use HaschaDev\Models\Production\ApplicationProduct;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeatureModel extends Model implements Modelable
{
    use SoftDeletes, TimestampModel;
    
    protected $fillable = [
        'application_product_id',
        'name',
        'description',
        'base_model',
        'base_name'
    ];

    protected $connection = DBConnect::PRODUCTION->value;
    protected $table = 'feature_models';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

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
     * Mutators: base_name
     * 
     */
    protected function baseName(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => Str::title($value),
        );
    }

    /**
     * relation to Application Product
     * 
     */
    protected function applicationProduct(): BelongsTo
    {
        return $this->belongsTo(ApplicationProduct::class, 'application_product_id', 'id');
    }

    /**
     * relation to Feature
     * 
     */
    protected function features(): HasMany
    {
        return $this->belongsTo(Feature::class, 'feature_model_id', 'id');
    }
}
