<?php

namespace HaschaDev\Production\Service;

use HaschaDev\Dev;
use HaschaDev\Production\Service\Service;
use HaschaDev\Production\Abstracts\AppBuilder;
use HaschaDev\Production\Abstracts\Production;
use HaschaDev\Production\Abstracts\FactoryBuilder;
use HaschaDev\Production\Traits\Transaction\Relationable;
use HaschaDev\Production\Traits\LiveSession\LiveSessionable;
use HaschaDev\Production\Traits\Transaction\QuickTransaction;
use HaschaDev\Production\Traits\FormValidation\ProductIdValidation;
use HaschaDev\Production\Traits\FormValidation\BaseValidationFormApp;
use HaschaDev\Production\Traits\FormValidation\PublicInfoValidationFormApp;

class ServiceFactory extends AppBuilder implements FactoryBuilder
{
    public function __construct(Dev $dev)
    {
        parent::__construct($dev);
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
            'min:3',
            'max:30'
        ];
    }

    /**
     * Validasi atribut: logo (file)
     * 
     */
    public function logoValidation(): array
    {
        return [
            'required',
            'image',
            'mimes:png,jpg,jpeg',
            'max:12288'
        ];
    }
    
    /**
     * Validasi atribut: serviceable
     * 
     */
    public function serviceableValidation(): array
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
    use ProductIdValidation, BaseValidationFormApp, PublicInfoValidationFormApp;

    /**
     * membangun koneksi
     * ke Production
     * 
     */
    public function build(): Production
    {
        return new Service();
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
}