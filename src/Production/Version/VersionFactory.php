<?php

namespace HaschaDev\Production\Version;

use HaschaDev\Dev;
use HaschaDev\Production\Version\Version;
use HaschaDev\Production\Abstracts\AppBuilder;
use HaschaDev\Production\Abstracts\Production;
use HaschaDev\Production\Abstracts\FactoryBuilder;
use HaschaDev\Production\Traits\Transaction\Relationable;
use HaschaDev\Production\Traits\LiveSession\LiveSessionable;
use HaschaDev\Production\Traits\Transaction\QuickTransaction;
use HaschaDev\Production\Traits\FormValidation\ReleaseIdValidation;
use HaschaDev\Production\Traits\FormValidation\VersioningValidation;

class VersionFactory extends AppBuilder implements FactoryBuilder
{
    public function __construct(Dev $dev)
    {
        parent::__construct($dev);
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
        return new Version();
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