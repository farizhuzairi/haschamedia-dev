<?php

namespace HaschaDev\Production\PageService;

use HaschaDev\Dev;
use HaschaDev\Production\Abstracts\AppBuilder;
use HaschaDev\Production\Abstracts\Production;
use HaschaDev\Production\PageService\PageService;
use HaschaDev\Production\Abstracts\FactoryBuilder;
use HaschaDev\Production\Traits\Transaction\Relationable;
use HaschaDev\Production\Traits\LiveSession\LiveSessionable;
use HaschaDev\Production\Traits\Transaction\QuickTransaction;
use HaschaDev\Production\Traits\FormValidation\BaseValidationFormApp;
use HaschaDev\Production\Traits\FormValidation\PublicInfoValidationFormApp;

class PageServiceFactory extends AppBuilder implements FactoryBuilder
{
    public function __construct(Dev $dev)
    {
        parent::__construct($dev);
    }

    /**
     * Validasi atribut: service id
     * 
     */
    public function serviceIdValidation(): array
    {
        return [
            'required',
            'int',
            'min:1'
        ];
    }

    /**
     * Validasi atribut: route name
     * 
     */
    public function routeNameValidation(): array
    {
        return [
            'required',
            'string',
            'min:3',
            'max:100'
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
     * Product Id Validation
     * Base Validation Form Application
     * Public Information Validation Form Application
     * 
     */
    use BaseValidationFormApp, PublicInfoValidationFormApp;

    /**
     * membangun koneksi
     * ke Production
     * 
     */
    public function build(): Production
    {
        return new PageService();
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
     * new service in page
     * 
     */
    public function createFirstPageService(array $service): bool
    {
        $instance = $this->build();
        return $instance->createNewFirstPageService($service); 
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