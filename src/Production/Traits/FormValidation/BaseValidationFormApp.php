<?php

namespace HaschaDev\Production\Traits\FormValidation;

trait BaseValidationFormApp
{
    /**
     * Validasi atribut: name
     * 
     */
    public function nameValidation(): array
    {
        return [
            'required',
            'string',
            'min:5',
            'max:150'
        ];
    }

    /**
     * Validasi atribut: description
     * 
     */
    public function descriptionValidation(): array
    {
        return [
            'required',
            'string',
            'max:2000'
        ];
    }
}