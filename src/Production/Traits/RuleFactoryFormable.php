<?php

namespace HaschaDev\Production\Traits;

use HaschaDev\Enums\DataType;

trait RuleFactoryFormable
{
    // helper variables
    public array $product;
    public ?string $productId;
    public bool $isRequiredAuthorityReadonly = false;
    public string $featureName = '';
    public string $featureTagline = '';
    public array $dataComponents = [];
    public array $dataComponentType = [];
    public array $dataLicenses = [];
    public array $dataTypes = [];

    /**
     * attributes
     * 
     */
    public ?string $featureId;
    public ?string $code = null;
    public ?string $name;
    public ?string $description;
    public bool $isPublicInfo = true;
    public ?string $alias;
    public ?string $tagline;
    public ?string $details;
    public ?string $devInfo;
    public ?string $component;
    public ?string $componentType;
    public bool $isPublicIntegration = true;
    public bool $isPersonalized = false;
    public bool $isRequiredAuthority = false;
    public ?string $contentValue;
    public ?string $dataType;
    public ?string $ruleable;

    /**
     * execute for livewire
     * 
     */
    public function updatedIsPublicIntegration(): void
    {
        if(! $this->isPublicIntegration){
            $this->isRequiredAuthority = false;
            $this->isRequiredAuthorityReadonly = true;
        }
        else{
            $this->isRequiredAuthorityReadonly = false;
        }
    }

    /**
     * execute for livewire
     * ============================================
     * validasi tambahan
     * khusus konversi data konten (content value)
     * berdasarkan nilai tipe data (data_type)
     * 
     */
    public function contentValueValidationExtra(string $dataType, string $contentValue): string
    {
        if($dataType === DataType::ARR->value){
            $data = trim($contentValue);
            $data = explode(',', $data);
            $newData = [];
            foreach($data as $i){
                $e = explode('=', $i);
                $newData = array_merge($newData, [
                    trim($e[0]) => trim($e[1])
                ]);
            }
            return (string) json_encode($newData);
        }
        elseif($dataType === DataType::STR->value){
            $data = trim($contentValue);
            return (string) $data;
        }
        elseif($dataType === DataType::INT->value){
            $data = (int) $contentValue;
            return (string) $data;
        }
        elseif($dataType === DataType::BOOL->value){
            $data = (bool) $contentValue;
            return (string) $data;
        }
        else{
            throw new \Exception("Error Processing Content Value. error_in_PHP_class: " . __CLASS__);
        }
    }

    /**
     * is public info updated
     * 
     */
    public function updatedIsPublicInfo(): void
    {
        if(! $this->isPublicInfo){
            $this->alias = null;
            $this->tagline = null;
            $this->details = null;
        }
    }
}