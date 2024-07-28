<?php

namespace HaschaDev\Models\Production;

use Publisher\Fundamentals\Config\DBConnect;
use HaschaDev\Models\Production\Feature;
use HaschaDev\Database\TimestampModel;
use Illuminate\Database\Eloquent\Model;
use HaschaDev\Database\Abstracts\Modelable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeatureRule extends Model implements Modelable
{
    use SoftDeletes, TimestampModel;
    
    protected $fillable = [
        'feature_id',
        'code',
        'name',
        'description',
        'is_public_info',
        'alias',
        'tagline',
        'details',
        'dev_info',
        'component',
        'component_type',
        'is_public_integration',
        'is_personalized',
        'is_required_authority',
        'content_value',
        'data_type',
        'rule'
    ];

    protected $connection = DBConnect::PRODUCTION->value;
    protected $table = 'feature_rules';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    /**
     * relation to Feature
     * 
     */
    protected function feature(): BelongsTo
    {
        return $this->belongsTo(Feature::class, 'feature_id', 'id');
    }
}
