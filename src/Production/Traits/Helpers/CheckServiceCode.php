<?php

namespace HaschaDev\Production\Traits\Helpers;

use HaschaDev\Enums\DataType;
use HaschaDev\Production\Service\ServiceFactory;

trait CheckServiceCode
{
    /**
     * has service code
     * with :blur from Livewire
     * 
     */
    public function hasCode(): void
    {
        $code = $this->code;
        if(!empty($code)){
            $factory = app(ServiceFactory::class);
            $db = $factory->getWhere(['code' => $code]);
            if(!empty($db)){
                $this->addError('code', 'Kode tidak valid!');
            }
            else{
                $this->resetValidation('code');
            }
        }
    }
}