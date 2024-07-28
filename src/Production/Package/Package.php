<?php

namespace HaschaDev\Production\Package;

use HaschaDev\HaschaMedia;
use Publisher\Fundamentals\Config\DBConnect;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Query\JoinClause;
use HaschaDev\Database\Abstracts\Modelable;
use HaschaDev\Models\Production\ApplicationProduct;
use HaschaDev\Production\Abstracts\Priceable;
use HaschaDev\Production\Abstracts\Production;
use HaschaDev\Models\Production\ServicePackage as DBPackage;

class Package implements Production, Priceable
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
            $store = $attributes ? DBPackage::create([
                'service_id' => $attributes['serviceId'],
                'code' => $attributes['code'],
                'name' => $attributes['name'],
                'description' => $attributes['description'],
                'alias' => $attributes['alias'],
                'tagline' => $attributes['tagline'],
                'details' => $attributes['details'],
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
        $result = [];
        try {
            if($this->modelData instanceof Modelable) return $this->modelData->toArray();
            elseif(is_array($this->modelData)) return $this->modelData;
        } catch (\Throwable $th) {
            Log::error("Failed to perform a data transaction to the resource. #data error_in_PHP_class: " . __CLASS__, [
                'error' => $th
            ]);
        }
        return $result;
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
            $packages = DBPackage::get();
            if($packages){
                $result = $packages;
                
                // to array ...
                if($isArray){
                    $result = $packages->map(function($i){
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
            $package = DBPackage::find($id);
            if($package){
                $result = $package;
                
                // to array ...
                if($isArray){
                    $result = $package->toArray();
                    // service
                    $service = $package->service;
                    $result['service'] = $service ? $service->toArray() : [];
                    // product ...
                    $product = $service ? $service->applicationProduct : false;
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
            $packages = DBPackage::query();
            foreach($foreigns as $foreignName => $foreignId){
                $foreignName = HaschaMedia::productIdAliases($foreignName);
                $packages = $packages->where($foreignName, '=', $foreignId);
            }
            $packages = $packages->get();
            if($packages){
                $result = $packages;
                
                // to array ...
                if($isArray){
                    $result = $packages->map(function($i){
                        $result = $i->toArray();
                        $service = $i->service;
                        $result['service'] = $service ? $service->toArray() : [];
                        $product = $service ? $service->applicationProduct : false;
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

    /**
     * get by product Id
     * mengambil semua data model objek aplikasi
     * berdasarkan product id
     * 
     */
    public function getByProductModelable(string $productId): array
    {
        $result = [];
        try {
            $product = ApplicationProduct::findOrFail($productId);
            if($product){
                $db = DB::connection(DBConnect::PRODUCTION->value)
                ->table('services')
                ->where('application_product_id', '=', $product->id)
                ->where('services.deleted_at', '=', null)
                ->join('service_packages', function(JoinClause $join){
                    $join->on('services.id', '=', 'service_packages.service_id')
                    ->where('service_packages.deleted_at', '=', null);
                })
                ->select(
                    'services.id as service_id',
                    'services.name as service_name',
                    'service_packages.id',
                    'service_packages.code',
                    'service_packages.name',
                )
                ->get();
                $packages = $db ? $db->map(function ($i){
                    return collect($i);
                })->toArray() : [];

                $dataProduct = $product->toArray();
                $dataProduct['logo'] = $product->logo();

                $result = [
                    'product' => $dataProduct,
                    'packages' => $packages
                ];
            }
        } catch (\Throwable $th) {
            Log::error("Invalid data modelable. #getByProductModelable error_in_PHP_class: " . __CLASS__, [
                'error' => $th
            ]);
        }

        $this->modelData = $result;
        return $result;
    }

    /**
     * ====================================================
     * SERVICE PACKAGE PRICE
     * ====================================================
     * 
     */
    public function createNewServicePackagePrice(array $attributes): self
    {
        try {
            $store = $attributes ? \HaschaDev\Models\Production\ServicePackagePrice::create([
                'service_package_id' => $attributes['packageId'],
                'price' => $attributes['price'],
                // 'currency' => $attributes['currency'],
                'period' => $attributes['period'],
                // 'min_order_based_on_period' => $attributes['minOrder'],
            ]) : false;
            if($store) $this->modelData = $store;
        } catch (\Throwable $th) {
            Log::error("Failed to perform a extra data transaction to the resource. #createNewServicePackagePrice error_in_PHP_class: " . __CLASS__, [
                'error' => $th
            ]);
        }
        return $this;
    }

    /**
     * update data Package Price Modelable dan
     * 
     */
    public function updateServicePackagePrice(array $attributes): self
    {
        try {
            $db = \HaschaDev\Models\Production\ServicePackagePrice::where('service_package_id', '=', $attributes['packageId'])->first();
            if(! $db) return $this;

            $store = $db ? $db->update([
                'price' => $attributes['price'],
                // 'currency' => $attributes['currency'],
                'period' => $attributes['period'],
                // 'min_order_based_on_period' => $attributes['minOrder'],
            ]) : false;
            if($store){
                // $openNewData = \HaschaDev\Models\Production\ServicePackagePrice::find($db->id);
                $this->modelData = $db;
            }
        } catch (\Throwable $th) {
            Log::error("Failed to perform a extra data transaction to the resource. #updateServicePackagePrice error_in_PHP_class: " . __CLASS__, [
                'error' => $th
            ]);
        }
        return $this;
    }

    /**
     * get data Package Price Modelable
     * mengambil semua data model objek aplikasi
     * berdasarkan package id
     * 
     */
    public function getPriceModelable(string $packageId, bool $isArray = true): Collection|array|null
    {
        $result = $isArray ? [] : null;
        try {
            $packagePrice = \HaschaDev\Models\Production\ServicePackagePrice::where('service_package_id', '=', $packageId)->first();
            if($packagePrice){
                $result = $packagePrice;
                
                // to array ...
                if($isArray){
                    $result = $packagePrice->toArray();
                }
            }
        } catch (\Throwable $th) {
            Log::error("#getPriceModelable error_in_PHP_class: " . __CLASS__, [
                'error' => $th
            ]);
        }
    
        $this->modelData = $result;
        return $result;
    }
}