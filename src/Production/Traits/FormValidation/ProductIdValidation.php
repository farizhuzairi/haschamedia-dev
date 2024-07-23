<?php

namespace HaschaDev\Production\Traits\FormValidation;

trait ProductIdValidation
{
    /**
     * Validasi atribut: productId
     * 
     */
    public function productIdValidation(): array
    {
        return [
            'required',
            'int',
            'min:1'
        ];
    }
}