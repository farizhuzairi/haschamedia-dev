<?php

namespace HaschaDev\Production\PageFeature;

use HaschaDev\HaschaMedia;
use Illuminate\Support\Collection;
use HaschaDev\File\Media\Imageable;
use Illuminate\Support\Facades\Log;
use HaschaDev\Application\ClientWebRoute;
use HaschaDev\Database\Abstracts\Modelable;
use HaschaDev\Production\Abstracts\Production;
use HaschaDev\Models\Production\PageFeature as DBPageFeature;

class PageFeature implements Production
{
    private Collection|Modelable|array|null $modelData = null;

    public function __construct()
    {}

    /**
     * menyusun struktur data untuk objek baru
     * dan meneruskan proses pembuatan objek ke sumber daya
     * 
     */
    public function createNewModel(array $attributes): self
    {
        try {
            $store = $attributes ? DBPageFeature::create([
                'page_service_id' => $attributes['pageServiceId'],
                'pageContentable' => $attributes['contentable'],
                'code' => $attributes['code'],
                'name' => $attributes['name'],
                'title' => $attributes['title'],
                'content' => $attributes['content'],
            ]) : false;
            if($store) $this->modelData = $store;
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
            $pageFeatures = DBPageFeature::get();
            if($pageFeatures){
                $result = $pageFeatures;
                
                // to array ...
                if($isArray){
                    $result = $pageFeatures->map(function($i){
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
            $pageFeature = DBPageFeature::find($id);
            if($pageFeature){
                $result = $pageFeature;
                
                // to array ...
                if($isArray){
                    $result = $pageFeature->toArray();
                    // page service ...
                    $pageService = $pageFeature->pageService;
                    $result['page_service'] = $pageService ? $pageService->toArray() : [];
                    // service ...
                    $service = $pageFeature->service;
                    $result['service'] = $service ? $service->toArray() : [];
                    $result['service']['logo'] = $service ? $service->logo() : [];
                    // product ...
                    $product = $pageFeature->applicationProduct;
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
            $pageFeatures = DBPageFeature::query();
            foreach($foreigns as $foreignName => $foreignId){
                $foreignName = HaschaMedia::productIdAliases($foreignName);
                $pageFeatures = $pageFeatures->where($foreignName, '=', $foreignId);
            }
            $pageFeatures = $pageFeatures->get();
            if($pageFeatures){
                $result = $pageFeatures;
                
                // to array ...
                if($isArray){
                    $result = $pageFeatures->map(function($i){
                        $result = $i->toArray();
                        // page service ...
                        $pageService = $i->pageService;
                        $result['page_service'] = $pageService ? $pageService->toArray() : [];
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