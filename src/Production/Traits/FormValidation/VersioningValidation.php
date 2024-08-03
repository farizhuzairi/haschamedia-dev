<?php

namespace HaschaDev\Production\Traits\FormValidation;

trait VersioningValidation
{
    /**
     * Validasi atribut: vinTag
     * 
     */
    public function vinTagValidation(): array
    {
        return [
            'required',
            'string',
            'min:10',
            'max:13'
        ];
    }

    /**
     * =============================================
     * Versioning Validation
     * 
     */
    // major ...
    public function majorValidation(): array
    {
        return [
            'required',
            'int',
            'min:1',
            'max:999'
        ];
    }
    // minor ...
    public function minorValidation(): array
    {
        return [
            'required',
            'int',
            'min:0',
            'max:99'
        ];
    }
    // patch ...
    public function patchValidation(): array
    {
        return [
            'required',
            'int',
            'min:0',
            'max:99'
        ];
    }
    // candidate ...
    public function candidateValidation(): array
    {
        return [
            'required',
            'int',
            'min:0',
            'max:9'
        ];
    }
    // beta ...
    public function betaValidation(): array
    {
        return [
            'required',
            'int',
            'min:0',
            'max:9'
        ];
    }
    // alpha ...
    public function alphaValidation(): array
    {
        return [
            'required',
            'int',
            'min:0',
            'max:9'
        ];
    }
}