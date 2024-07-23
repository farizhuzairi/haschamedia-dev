<?php

namespace HaschaDev\File\Media;

use HaschaDev\HaschaMedia;
use Illuminate\Support\Str;
use HaschaDev\File\Media\Imageable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Facades\Storage;
use HaschaDev\File\Abstracts\BaseFileMedia;

class Media extends BaseFileMedia
{
    public function __construct(
        private string|int $id,
        private ?Imageable $imageable,
        private string $title = '',
        private ?object $root = null,
        private ?string $disk = null
    )
    {
        if(empty($disk)) $this->disk = HaschaMedia::$defaultStorageDisk;
    }

    /**
     * file image Upload
     * 
     */
    public function upload(): ?string
    {
        $result = null;
        try {
            if(
                !empty($this->title) &&
                !empty($this->root)
            ){
                $file = $this->root;
                $name = Str::slug($this->title) . '-' . now()->timestamp;
    
                $dir = $this->imageable->value;
                $fileName = $name . "." . $file->extension();
    
                $uploading = $file->storeAs($dir, $fileName, $this->disk);
    
                if($uploading){
                    $store = $this->addNewMedia([
                        'imageable' => $this->imageable->value,
                        'imageable_id' => $this->id,
                        'name' => $this->title,
                        'title' => $this->title,
                        'path' => $uploading,
                        'disk' => $this->disk,
                        'is_active' => true,
                    ]);
                    $result = $store ? $store->path : null;
    
                    if(! $store || empty($store)){
                        $this->delete($path, $this->disk);
                    }
                }
            }
        } catch (\Throwable $th) {
            Log::error("Gagal mengunggah file image. error_in_PHP_class: " . __CLASS__, [
                'error' => $th
            ]);
        }
        return $result;
    }

    /**
     * file image Delete
     * 
     */
    public function delete(?string $path = null, ?string $disk = null): bool
    {
        \Illuminate\Support\Facades\Log::info("two");
        $result = false;
        try {
            if(!empty($path) && !empty($disk)){
                $delete = Storage::disk($disk)->delete($path);
            }
            else{
                $data = $this->fileMedia;
                if($data){
                    if(Storage::disk($data->disk)->exists($data->path)){
                        $delete = Storage::disk($data->disk)->delete($data->path);
                        if($delete) $this->fileMedia->delete();
                        $result = $delete;
                    }
                }
            }
        } catch (\Throwable $th) {
            Log::error("Gagal menghapus file image. error_in_PHP_class: " . __CLASS__, [
                'error' => $th
            ]);
        }
        return $result;
    }

    /**
     * first Media
     * 
     */
    public function firstWhereImageable(): string
    {
        try {
            $fileMedia = $this->firstWhere($this->id, $this->imageable->value);
            // if(! $fileMedia) return Vite::images('devstart.png'); // default image
            if(! $fileMedia) return ''; // default image
            return asset("storage/" . $fileMedia->path);
        } catch (\Throwable $th) {
            Log::error("Gagal mengambil file image #id:{$this?->id}# #imageable:{$this?->imageable?->value}#. error_in_PHP_class: " . __CLASS__, [
                'error' => $th
            ]);
        }
        return '';
    }
}