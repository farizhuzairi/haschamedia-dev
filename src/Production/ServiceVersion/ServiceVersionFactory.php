<?php

namespace HaschaDev\Production\Version;

use HaschaDev\Dev;
use HaschaDev\Production\Abstracts\AppBuilder;
use HaschaDev\Production\Abstracts\Production;
use HaschaDev\Production\Version\ServiceVersion;
use HaschaDev\Production\Abstracts\FactoryBuilder;
use HaschaDev\Production\Traits\Transaction\Relationable;
use HaschaDev\Production\Traits\LiveSession\LiveSessionable;
use HaschaDev\Production\Traits\Transaction\QuickTransaction;
use HaschaDev\Production\Traits\FormValidation\ReleaseIdValidation;
use HaschaDev\Production\Traits\FormValidation\VersioningValidation;

class ServiceVersionFactory extends AppBuilder implements FactoryBuilder
{
    public function __construct(Dev $dev)
    {
        parent::__construct($dev);
    }

    /**
     * Validasi atribut: serviceCode
     * 
     */
    public function serviceCodeValidation(): array
    {
        return [
            'required',
            'string',
            'min:3',
            'max:30'
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
     * validation rules
     * 
     */
    use ReleaseIdValidation, VersioningValidation;

    /**
     * membangun koneksi
     * ke Production
     * 
     */
    public function build(): Production
    {
        return new ServiceVersion();
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