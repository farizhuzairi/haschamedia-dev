<?php

namespace HaschaDev\Production\Feature;

use HaschaDev\HaschaMedia;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use HaschaDev\Database\Abstracts\Modelable;
use HaschaDev\Production\Abstracts\Production;
use App\Models\Production\Feature as DBFeature;

class Feature implements Production
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
            $store = $attributes ? DBFeature::create([
                'application_product_id' => $attributes['productId'],
                'feature_model_id' => $attributes['modelId'],
                'code' => $attributes['code'],
                'priority' => $attributes['priority'],
                'type' => $attributes['type'],
                'name' => $attributes['name'],
                'description' => $attributes['description'],
                'alias' => $attributes['alias'],
                'tagline' => $attributes['tagline'],
                'details' => $attributes['details'],
                'dev_info' => $attributes['devInfo'],
            ]) : false;
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
            $model = DBFeature::get();
            if($model){
                $result = $model;
                
                // to array ...
                if($isArray){
                    $result = $model->map(function($i){
                        $result = $i->toArray();
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
            $feature = DBFeature::find($id);
            if($feature){
                $result = $feature;
                
                // to array ...
                if($isArray){
                    $result = $feature->toArray();
                    $model = $feature->featureModel;
                    $product = $feature->applicationProduct;
                    $result['model'] = $model ? $model->toArray() : [];
                    $result['product'] = $product ? $product->toArray() : [];
                    $result['product']['logo'] = $product ? $product->logo() : [];
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
            $model = DBFeature::query();
            foreach($foreigns as $foreignName => $foreignId){
                $foreignName = HaschaMedia::productIdAliases($foreignName);
                $model = $model->where($foreignName, '=', $foreignId);
            }
            $model = $model->get();
            if($model){
                $result = $model;
                
                // to array ...
                if($isArray){
                    $result = $model->map(function($i){
                        $result = $i->toArray();
                        $model = $i->featureModel;
                        $product = $i->applicationProduct;
                        $result['model'] = $model ? $model->toArray() : [];
                        $result['product'] = $product ? $product->toArray() : [];
                        $result['product']['logo'] = $product ? $product->logo() : [];
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
}