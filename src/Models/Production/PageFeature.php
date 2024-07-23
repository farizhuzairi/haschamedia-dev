<?php

namespace HaschaDev\Models\Production;

use HaschaDev\Database\DBConnect;
use HaschaDev\Models\Production\PageService;
use HaschaDev\Database\TimestampModel;
use Illuminate\Database\Eloquent\Model;
use HaschaDev\Database\Abstracts\Modelable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageFeature extends Model implements Modelable
{
    use SoftDeletes, TimestampModel;
    
    protected $fillable = [
        'page_service_id',
        'page_contentable',
        'code',
        'name',
        'title',
        'content'
    ];

    protected $connection = DBConnect::PRODUCTION->value;
    protected $table = 'page_features';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    /**
     * relation to Page Service
     * 
     */
    protected function pageService(): BelongsTo
    {
        return $this->belongsTo(PageService::class, 'page_service_id', 'id');
    }
}
