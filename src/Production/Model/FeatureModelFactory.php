<?php

namespace HaschaDev\Production\Model;

use HaschaDev\Dev;
use HaschaDev\Production\Model\FeatureModel;
use HaschaDev\Production\Abstracts\AppBuilder;
use HaschaDev\Production\Abstracts\Production;
use HaschaDev\Production\Abstracts\FactoryBuilder;
use HaschaDev\Production\Traits\Transaction\Relationable;
use HaschaDev\Production\Traits\LiveSession\LiveSessionable;
use HaschaDev\Production\Traits\Transaction\QuickTransaction;
use HaschaDev\Production\Traits\FormValidation\ProductIdValidation;
use HaschaDev\Production\Traits\FormValidation\BaseValidationFormApp;

class FeatureModelFactory extends AppBuilder implements FactoryBuilder
{
    public function __construct(Dev $dev)
    {
        parent::__construct($dev);
    }

    /**
     * Product Id Validation
     * Base Validation Form Application
     * 
     */
    use ProductIdValidation, BaseValidationFormApp;

    /**
     * Validasi atribut: baseModel
     * 
     */
    public function baseModelValidation(): array
    {
        return [
            'required',
            'string',
            'min:1'
        ];
    }

    /**
     * Validasi atribut: baseModelName
     * 
     */
    public function baseModelNameValidation(): array
    {
        return [
            'required',
            'string',
            'min:3',
            'max:70'
        ];
    }

    /**
     * membangun koneksi
     * ke Production
     * 
     */
    public function build(): Production
    {
        return new FeatureModel();
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