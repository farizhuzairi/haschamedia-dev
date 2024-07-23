<?php

namespace HaschaDev\Production\Product;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use HaschaDev\File\Media\Imageable;
use Illuminate\Support\Facades\Log;
use HaschaDev\Database\Abstracts\Modelable;
use HaschaDev\File\Traits\GlobalImageUpload;
use HaschaDev\Models\Production\ApplicationProduct;
use HaschaDev\Production\Abstracts\Production;

class Product implements Production
{
    private Collection|Modelable|array|null $modelData = null;

    public function __construct()
    {}

    /**
     * image uploading
     * add new media
     * 
     */
    use GlobalImageUpload;

    /**
     * menyusun struktur data untuk objek baru
     * dan meneruskan proses pembuatan objek ke sumber daya
     * 
     */
    public function createNewModel(array $attributes): self
    {
        try {
            $store = $attributes ? ApplicationProduct::create([
                'code' => $attributes['code'],
                'name' => $attributes['name'],
                'description' => $attributes['description'],
                'brand' => null,
                'tagline' => $attributes['tagline'],
                'details' => $attributes['details'],
            ]) : false;
            if(!empty($attributes['logo']) && $store){
                $upload = $this->imageUpload(
                    id: $store->id,
                    title: $attributes['name'],
                    imageable: Imageable::APP_LOGO,
                    root: $attributes['logo']
                );
            }
            if($store) $this->modelData = $store;
        } catch (\Throwable $th) {
            Log::error("Failed to perform a data transaction to the resource. {$th}");
        }
        return $this;
    }

    /**
     * mengambil data objek baru
     * berdasarkan pemuatan transaksi dari sumber daya
     * 
     */
    public function data(): array
    {
        if($this->modelData instanceof Modelable) return $this->modelData->toArray();
        elseif(is_array($this->modelData)) return $this->modelData;
        return [];
    }

    /**
     * get data Modelable
     * mengambil semua data model objek aplikasi
     * 
     */
    public function getModelable(bool $isArray = true): Collection|array|null
    {
        $result = $isArray ? [] : null;
        try {
            $model = ApplicationProduct::get();
            if($model){
                $result = $model;
                
                // to array ...
                if($isArray){
                    $result = $model->map(function($i){
                        $result = $i->toArray();
                        $result['logo'] = $i->logo();
                        return $result;
                    })->toArray();
                }
            }
        } catch (\Throwable $th) {
            Log::error("Invalid data modelable. error_in_PHP_class: " . __CLASS__, [
                'error' => $th
            ]);
        }
    
        $this->modelData = $result;
        return $result;
    }

    /**
     * find data modelable toArray()
     * menampilkan data objek dalam array
     * 
     */
    public function findModelable(string $id, bool $isArray = true): Modelable|array|null
    {
        $result = $isArray ? [] : null;
        try {
            $model = ApplicationProduct::find($id);
            if($model){
                $result = $model;
                
                // to array ...
                if($isArray){
                    $result = $model->toArray();
                    $result['logo'] = $model->logo();
                }
            }
        } catch (\Throwable $th) {
            Log::error("Invalid data modelable. error_in_PHP_class: " . __CLASS__, [
                'error' => $th
            ]);
        }
    
        $this->modelData = $result;
        return $result;
    }
}