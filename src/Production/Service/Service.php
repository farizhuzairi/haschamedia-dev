<?php

namespace HaschaDev\Production\Service;

use HaschaDev\HaschaMedia;
use Illuminate\Support\Collection;
use HaschaDev\File\Media\Imageable;
use Illuminate\Support\Facades\Log;
use HaschaDev\Database\Abstracts\Modelable;
use HaschaDev\File\Traits\GlobalImageUpload;
use HaschaDev\Production\Abstracts\Production;
use App\Models\Production\Service as DBService;

class Service implements Production
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
            $store = $attributes ? DBService::create([
                'application_product_id' => $attributes['productId'],
                'code' => $attributes['code'],
                'name' => $attributes['name'],
                'description' => $attributes['description'],
                'alias' => $attributes['alias'],
                'tagline' => $attributes['tagline'],
                'details' => $attributes['details'],
                'serviceable' => $attributes['serviceable'],
            ]) : false;
            if(!empty($attributes['logo']) && $store){
                $upload = $this->imageUpload(
                    id: $store->id,
                    title: $attributes['name'],
                    imageable: Imageable::SERVICE_LOGO,
                    root: $attributes['logo']
                );
            }
            if($store){
                
                $this->modelData = $store;
            }
        } catch (\Throwable $th) {
            Log::error("Failed to perform a data transaction to the resource. #createNewModel error_in_PHP_class" . __CLASS__, [
                'error' => $th
            ]);
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
            $services = DBService::get();
            if($services){
                $result = $services;
                
                // to array ...
                if($isArray){
                    $result = $services->map(function($i){
                        $result = $i->toArray();
                        return $result;
                    })->toArray();
                }
            }
        } catch (\Throwable $th) {
            Log::error("Invalid data modelable. #getModelable error_in_PHP_class: " . __CLASS__, [
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
            $service = DBService::find($id);
            if($service){
                $result = $service;
                
                // to array ...
                if($isArray){
                    $result = $service->toArray();
                    $result['logo'] = $service->logo();
                    // product ...
                    $product = $service->applicationProduct;
                    $result['product'] = $product ? $product->toArray() : [];
                    $result['product']['logo'] = $product ? $product->logo() : [];
                }
            }
        } catch (\Throwable $th) {
            Log::error("Invalid data modelable. #findModelable error_in_PHP_class: " . __CLASS__, [
                'error' => $th
            ]);
        }
    
        $this->modelData = $result;
        return $result;
    }

    /**
     * get where data Modelable
     * mengambil semua data model objek aplikasi
     * berdasarkan foreign key
     * 
     */
    public function getWhereModelable(array $foreigns, bool $isArray = true): Collection|array|null
    {
        if(empty($foreigns)) return null;

        $result = $isArray ? [] : null;
        try {
            $services = DBService::query();
            foreach($foreigns as $foreignName => $foreignId){
                $foreignName = HaschaMedia::productIdAliases($foreignName);
                $services = $services->where($foreignName, '=', $foreignId);
            }
            $services = $services->get();
            if($services){
                $result = $services;
                
                // to array ...
                if($isArray){
                    $result = $services->map(function($i){
                        $result = $i->toArray();
                        $product = $i->applicationProduct;
                        $result['product'] = $product ? $product->toArray() : [];
                        $result['product']['logo'] = $product ? $product->logo() : [];
                        return $result;
                    })->toArray();
                }
            }
        } catch (\Throwable $th) {
            Log::error("Invalid data modelable. #getWhereModelable error_in_PHP_class: " . __CLASS__, [
                'error' => $th
            ]);
        }
    
        $this->modelData = $result;
        return $result;
    }
}