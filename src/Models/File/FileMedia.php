<?php

namespace HaschaDev\Models\File;

use Publisher\Fundamentals\Config\DBConnect;
use Illuminate\Database\Eloquent\Model;
use HaschaDev\Database\Abstracts\Modelable;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileMedia extends Model implements Modelable
{
    use SoftDeletes;
    
    protected $fillable = [
        'imageable',
        'imageable_id',
        'name',
        'title',
        'path',
        'disk',
        'is_active'
    ];

    protected $connection = DBConnect::FILE->value;
    protected $table = 'file_media';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;
}
