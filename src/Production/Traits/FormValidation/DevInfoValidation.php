<?php

namespace HaschaDev\Production\Traits\FormValidation;

trait DevInfoValidation
{
    /**
     * Validasi atribut: devInfo
     * 
     */
    public function devInfoValidation(): array
    {
        return [
            'string',
            'max:2000',
            'nullable'
        ];
    }
}