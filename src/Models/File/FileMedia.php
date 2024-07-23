<?php

namespace HaschaDev\Models\File;

use HaschaDev\Database\DBConnect;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileMedia extends Model
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
