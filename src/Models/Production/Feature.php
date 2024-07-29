<?php

namespace HaschaDev\Models\Production;

use Illuminate\Support\Str;
use Publisher\Configurations\DBConnect;
use HaschaDev\Database\TimestampModel;
use Illuminate\Database\Eloquent\Model;
use HaschaDev\Database\Abstracts\Modelable;
use HaschaDev\Models\Production\FeatureRule;
use HaschaDev\Models\Production\FeatureModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use HaschaDev\Models\Production\ApplicationProduct;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feature extends Model implements Modelable
{
    use SoftDeletes, TimestampModel;
    
    protected $fillable = [
        'application_product_id',
        'feature_model_id',
        'code',
        'priority',
        'type',
        'name',
        'description',
        'is_public_info',
        'alias',
        'tagline',
        'details',
        'dev_info'
    ];

    protected $connection = DBConnect::PRODUCTION->value;
    protected $table = 'features';
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
     * relation to Application Product
     * 
     */
    protected function applicationProduct(): BelongsTo
    {
        return $this->belongsTo(ApplicationProduct::class, 'application_product_id', 'id');
    }

    /**
     * relation to Feature Model
     * 
     */
    protected function featureModel(): BelongsTo
    {
        return $this->belongsTo(FeatureModel::class, 'feature_model_id', 'id');
    }

    /**
     * relation to Feature Rule
     * 
     */
    protected function featureRules(): HasMany
    {
        return $this->hasMany(FeatureRule::class, 'feature_id', 'id');
    }
}
