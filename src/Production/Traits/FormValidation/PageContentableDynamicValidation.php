<?php

namespace HaschaDev\Production\Traits\FormValidation;

trait PageContentableDynamicValidation
{
    /**
     * Validasi atribut: image
     * 
     */
    public function imageDynamicValidation(): array
    {
        return [
            'required',
            'image',
            'mimes:png,jpg,jpeg',
            'max:12288'
        ];
    }
    
    /**
     * Validasi atribut: image description
     * 
     */
    public function descriptionDynamicValidation(): array
    {
        return [
            'string',
            'max:2000',
            'nullable'
        ];
    }
    
    /**
     * Validasi atribut: content
     * 
     */
    public function contentDynamicValidation(): array
    {
        return [
            'required',
            'string',
            'max:8000'
        ];
    }
    
    /**
     * Validasi atribut: text
     * 
     */
    public function textDynamicValidation(): array
    {
        return [
            'required',
            'string',
            'max:800'
        ];
    }
}