<?php

namespace HaschaDev\Production\Release;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use HaschaDev\Database\Abstracts\Modelable;
use HaschaDev\Production\Abstracts\Production;
use Publisher\Fundamentals\Release\Release as DBRelease;

class Release implements Production
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
            $store = $attributes ? DBRelease::create([
                'application_product_id' => $attributes['appId'],
                'code' => $attributes['code'],
                'title' => $attributes['title'],
                'released_at' => now()->format('Y-m-d h:i:s'),
                'notes' => $attributes['notes'],
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
        if($this->modelData instanceof DBRelease) return $this->modelData->toArray();
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
            $model = DBRelease::get();
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
            $model = DBRelease::find($id);
            if($model){
                $result = $model;
                
                // to array ...
                if($isArray){
                    $result = $model->toArray();
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