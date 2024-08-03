<?php

namespace HaschaDev\Production\Traits\FormValidation;

trait ReleaseIdValidation
{
    /**
     * Validasi atribut: releaseId
     * 
     */
    public function releaseIdValidation(): array
    {
        return [
            'required',
            'int',
            'min:1'
        ];
    }
}