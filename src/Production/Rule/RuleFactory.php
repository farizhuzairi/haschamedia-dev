<?php

namespace HaschaDev\Production\Rule;

use HaschaDev\Dev;
use HaschaDev\Production\Rule\Rule;
use HaschaDev\Production\Abstracts\AppBuilder;
use HaschaDev\Production\Abstracts\Production;
use HaschaDev\Production\Abstracts\FactoryBuilder;
use HaschaDev\Production\Traits\Transaction\Relationable;
use HaschaDev\Production\Traits\LiveSession\LiveSessionable;
use HaschaDev\Production\Traits\Transaction\QuickTransaction;
use HaschaDev\Production\Traits\Transaction\ProductRelationable;
use HaschaDev\Production\Traits\FormValidation\DevInfoValidation;
use HaschaDev\Production\Traits\FormValidation\ProductIdValidation;
use HaschaDev\Production\Traits\FormValidation\BaseValidationFormApp;
use HaschaDev\Production\Traits\FormValidation\PublicInfoValidationFormApp;

class RuleFactory extends AppBuilder implements FactoryBuilder
{
    public function __construct(Dev $dev)
    {
        parent::__construct($dev);
    }

    /**
     * Validasi atribut: modelId
     * 
     */
    public function featureIdValidation(): array
    {
        return [
            'required',
            'int',
            'min:1'
        ];
    }

    /**
     * Validasi atribut: code
     * 
     */
    public function codeValidation(): array
    {
        return [
            'required',
            'string',
            'min:32',
            'max:150'
        ];
    }

    /**
     * Validasi atribut: component
     * 
     */
    public function componentValidation(): array
    {
        return [
            'required',
            'string',
            'min:3',
            'max:30'
        ];
    }

    /**
     * Validasi atribut: component type
     * 
     */
    public function componentTypeValidation(): array
    {
        return [
            'required',
            'string',
            'min:3',
            'max:50'
        ];
    }

    /**
     * Validasi atribut: is public integration
     * 
     */
    public function isPublicIntegrationValidation(): array
    {
        return [
            'required',
            'boolean'
        ];
    }

    /**
     * Validasi atribut: is personalized
     * 
     */
    public function isPersonalizedValidation(): array
    {
        return [
            'required',
            'boolean'
        ];
    }

    /**
     * Validasi atribut: is required authority
     * 
     */
    public function isRequiredAuthorityValidation(): array
    {
        return [
            'required',
            'boolean'
        ];
    }

    /**
     * Validasi atribut: contentValue
     * 
     */
    public function contentValueValidation(): array
    {
        return [
            'required',
            'string',
            'min:1',
            'max:4000'
        ];
    }

    /**
     * Validasi atribut: dataType
     * 
     */
    public function dataTypeValidation(): array
    {
        return [
            'required',
            'string',
            'min:1',
            'max:20'
        ];
    }

    /**
     * Validasi atribut: rule
     * 
     */
    public function ruleableValidation(): array
    {
        return [
            'required',
            'string',
            'min:1',
            'max:30'
        ];
    }

    /**
     * Product Id Validation
     * Base Validation Form Application
     * Public Information Validation Form Application
     * 
     */
    use ProductIdValidation, BaseValidationFormApp, PublicInfoValidationFormApp, DevInfoValidation;

    /**
     * membangun koneksi
     * ke Production
     * 
     */
    public function build(): Production
    {
        return new Rule();
    }

    /**
     * membuat objek ke sumber daya
     * melalui Production
     * 
     */
    public function make(array $validated): array
    {
        $instance = $this->build();
        $instance->createNewModel($validated);
        $data = $instance->data();
        if($data) return $data;
        return [];
    }

    /**
     * Live Session
     * Quick Transactionable
     * 
     */
    use LiveSessionable, QuickTransaction;

    /**
     * Relationable Transaction
     * 
     */
    use Relationable;

    /**
     * Product Modelable
     * Relations
     * 
     */
    use ProductRelationable;
}