<?php

namespace HaschaDev\Production\Rule;

use HaschaDev\HaschaMedia;
use Publisher\Configurations\DBConnect;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Query\JoinClause;
use HaschaDev\Database\Abstracts\Modelable;
use HaschaDev\Models\Production\ApplicationProduct;
use HaschaDev\Production\Abstracts\Production;
use HaschaDev\Models\Production\FeatureRule as DBRule;
use HaschaDev\Production\Traits\Helpers\ContentValueConvert;

class Rule implements Production
{
    private Collection|Modelable|array|null $modelData = null;

    public function __construct()
    {}

    /**
     * Content Value Convertion
     * to print_r
     * 
     */
    use ContentValueConvert;

    /**
     * menyusun struktur data untuk objek baru
     * dan meneruskan proses pembuatan objek ke sumber daya
     * 
     */
    public function createNewModel(array $attributes): self
    {
        try {
            $store = $attributes ? DBRule::create([
                'feature_id' => $attributes['featureId'],
                'code' => $attributes['code'],
                'name' => $attributes['name'],
                'description' => $attributes['description'],
                'is_public_info' => $attributes['isPublicInfo'],
                'alias' => $attributes['alias'],
                'tagline' => $attributes['tagline'],
                'details' => $attributes['details'],
                'dev_info' => $attributes['devInfo'],
                'component' => $attributes['component'],
                'component_type' => $attributes['componentType'],
                'is_public_integration' => $attributes['isPublicIntegration'],
                'is_personalized' => $attributes['isPersonalized'],
                'is_required_authority' => $attributes['isRequiredAuthority'],
                'content_value' => $attributes['contentValue'],
                'data_type' => $attributes['dataType'],
                'rule' => $attributes['ruleable'],
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
            $model = DBRule::get();
            if($model){
                $result = $model;
                
                // to array ...
                if($isArray){
                    $result = $model->map(function($i){
                        $result = $i->toArray();
                        $result['data_value'] = $this->dataContentValue($i->data_type, $i->content_value);
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
            $rule = DBRule::find($id);
            if($rule){
                $result = $rule;
                
                // to array ...
                if($isArray){
                    $result = $rule->toArray();
                    $result['data_value'] = $this->dataContentValue($rule->data_type, $rule->content_value);
                    // feature ...
                    $feature = $rule->feature;
                    $result['feature'] = $feature ? $feature->toArray() : [];
                    // product ...
                    $product = $feature->applicationProduct;
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
            $rule = DBRule::query();
            foreach($foreigns as $foreignName => $foreignId){
                $foreignName = HaschaMedia::productIdAliases($foreignName);
                $rule = $rule->where($foreignName, '=', $foreignId);
            }
            $rule = $rule->get();
            if($rule){
                $result = $rule;
                
                // to array ...
                if($isArray){
                    $result = $rule->map(function($i){
                        $result = $i->toArray();
                        $feature = $i->feature;
                        $product = $feature->applicationProduct;
                        $result['feature'] = $feature ? $feature->toArray() : [];
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
                ->table('features')
                ->where('application_product_id', '=', $product->id)
                ->where('features.deleted_at', '=', null)
                ->join('feature_rules', function(JoinClause $join){
                    $join->on('features.id', '=', 'feature_rules.feature_id')
                    ->where('feature_rules.deleted_at', '=', null);
                })
                ->select(
                    'features.id as feature_id',
                    'features.name as feature_name',
                    'feature_rules.id',
                    'feature_rules.code',
                    'feature_rules.name',
                    'feature_rules.is_public_info',
                    'feature_rules.component',
                    'feature_rules.component_type',
                )
                ->get();
                $rules = $db ? $db->map(function ($i){
                    return collect($i);
                })->toArray() : [];

                $dataProduct = $product->toArray();
                $dataProduct['logo'] = $product->logo();

                $result = [
                    'product' => $dataProduct,
                    'rules' => $rules
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
}