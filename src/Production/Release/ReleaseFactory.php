<?php

namespace HaschaDev\Production\Release;

use HaschaDev\Dev;
use HaschaDev\Production\Release\Release;
use HaschaDev\Production\Abstracts\AppBuilder;
use HaschaDev\Production\Abstracts\Production;
use HaschaDev\Production\Abstracts\FactoryBuilder;
use HaschaDev\Production\Traits\Transaction\Relationable;
use HaschaDev\Production\Traits\LiveSession\LiveSessionable;
use HaschaDev\Production\Traits\Transaction\QuickTransaction;

class ReleaseFactory extends AppBuilder implements FactoryBuilder
{
    public function __construct(Dev $dev)
    {
        parent::__construct($dev);
    }

    /**
     * Validasi atribut: application product id
     * 
     */
    public function appIdValidation(): array
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
            'min:20',
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
     * Validasi atribut: notes
     * 
     */
    public function notesValidation(): array
    {
        return [
            'string',
            'max:1000',
            'nullable'
        ];
    }

    /**
     * membangun koneksi
     * ke Production
     * 
     */
    public function build(): Production
    {
        return new Release();
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