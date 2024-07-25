<?php

namespace HaschaDev\File\Abstracts;

use HaschaDev\HaschaMedia;
use Illuminate\Support\Facades\Log;
use HaschaDev\Models\File\FileMedia;
use HaschaDev\Database\Abstracts\Modelable;

abstract class BaseFileMedia
{
    /**
     * objek dari sumber daya,
     * hanya akan bernilai (true) jikaproses upload|delete dijalankan
     * 
     */
    protected ?Modelable $fileMedia = null;

    /**
     * add new file image
     * 
     */
    public function addNewMedia(array $attributes): ?Modelable
    {
        $store = null;
        try {
            if($attributes){
                $store = FileMedia::create([
                    'imageable' => $attributes['imageable'],
                    'imageable_id' => $attributes['imageable_id'],
                    'name' => $attributes['name'],
                    'title' => $attributes['title'] ?? null,
                    'path' => $attributes['path'],
                    'disk' => $attributes['disk'] ?? HaschaMedia::$defaultStorageDisk,
                    'is_active' => $attributes['is_active'] ?? HaschaMedia::$defaultIsActiveFileMedia,
                ]);
                if($store) $this->fileMedia = $store;
            }
        } catch (\Throwable $th) {
            Log::error("Gagal menambahkan data file image. error_in_PHP_class: " . __CLASS__);
        }
        return $store;
    }

    /**
     * get filemedia
     * 
     */
    public function fileMedia(): Modelable
    {
        return $this->fileMedia;
    }

    /**
     * firstWhere
     * 
     */
    protected function firstWhere(string $id, string $imageable): ?FileMedia
    {
        return FileMedia::where('imageable', '=', $imageable)->where('imageable_id', '=', $id)->first();
    }

    /**
     * file image Upload
     * 
     */
    abstract public function upload(): ?string;
    
    /**
     * file image Delete
     * 
     */
    abstract public function delete(): bool;
    
    /**
     * first Media
     * 
     */
    abstract public function firstWhereImageable(): string;
}