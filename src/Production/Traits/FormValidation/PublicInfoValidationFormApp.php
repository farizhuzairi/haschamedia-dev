<?php

namespace HaschaDev\Production\Traits\FormValidation;

trait PublicInfoValidationFormApp
{
    /**
     * Validasi atribut: is public info
     * 
     */
    public function isPublicInfoValidation(): array
    {
        return [
            'required',
            'boolean'
        ];
    }

    /**
     * Validasi atribut: alias
     * 
     */
    public function aliasValidation(): array
    {
        return [
            'string',
            'min:3',
            'max:150',
            'nullable'
        ];
    }

    /**
     * Validasi atribut: tagline
     * 
     */
    public function taglineValidation(): array
    {
        return [
            'string',
            'max:250',
            'nullable'
        ];
    }

    /**
     * Validasi atribut: details
     * 
     */
    public function detailsValidation(): array
    {
        return [
            'string',
            'max:8000',
            'nullable'
        ];
    }
}