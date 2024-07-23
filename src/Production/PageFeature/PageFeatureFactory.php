<?php

namespace HaschaDev\Production\PageFeature;

use HaschaDev\Dev;
use HaschaDev\Production\Abstracts\AppBuilder;
use HaschaDev\Production\Abstracts\Production;
use HaschaDev\Production\PageFeature\PageFeature;
use HaschaDev\Production\Abstracts\FactoryBuilder;
use HaschaDev\Production\Traits\Transaction\Relationable;
use HaschaDev\Production\Traits\LiveSession\LiveSessionable;
use HaschaDev\Production\Traits\Transaction\QuickTransaction;
use HaschaDev\Production\Traits\FormValidation\BaseValidationFormApp;

class PageFeatureFactory extends AppBuilder implements FactoryBuilder
{
    public function __construct(Dev $dev)
    {
        parent::__construct($dev);
    }

    /**
     * Validasi atribut: page service id
     * 
     */
    public function pageServiceIdValidation(): array
    {
        return [
            'required',
            'int',
            'min:1'
        ];
    }

    /**
     * Validasi atribut: page contentable
     * 
     */
    public function contentableValidation(): array
    {
        return [
            'required',
            'string',
            'min:3',
            'max:100'
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
     * Validasi atribut: title
     * 
     */
    public function titleValidation(): array
    {
        return [
            'required',
            'string',
            'min:3',
            'max:150'
        ];
    }

    /**
     * Validasi atribut: content
     * 
     */
    public function contentValidation(): array
    {
        return [
            'string',
            'max:8000',
            'nullable'
        ];
    }

    /**
     * Product Id Validation
     * Base Validation Form Application
     * Public Information Validation Form Application
     * 
     */
    use BaseValidationFormApp;

    /**
     * membangun koneksi
     * ke Production
     * 
     */
    public function build(): Production
    {
        return new PageFeature();
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