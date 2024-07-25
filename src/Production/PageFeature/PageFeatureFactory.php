<?php

namespace HaschaDev\Production\PageFeature;

use HaschaDev\Dev;
use HaschaDev\Enums\PageContentable;
use HaschaDev\Production\Abstracts\AppBuilder;
use HaschaDev\Production\Abstracts\Production;
use HaschaDev\Production\PageFeature\PageFeature;
use HaschaDev\Production\Abstracts\FactoryBuilder;
use HaschaDev\Production\Traits\Transaction\Relationable;
use HaschaDev\Production\Traits\LiveSession\LiveSessionable;
use HaschaDev\Production\Traits\Transaction\QuickTransaction;
use HaschaDev\Production\Traits\FormValidation\BaseValidationFormApp;
use HaschaDev\Production\Traits\FormValidation\PageContentableDynamicValidation;

class PageFeatureFactory extends AppBuilder implements FactoryBuilder
{
    public function __construct(Dev $dev)
    {
        parent::__construct($dev);
    }

    /**
     * Validasi atribut: page service id
     * 
     */
    public function pageServiceIdValidation(): array
    {
        return [
            'required',
            'int',
            'min:1'
        ];
    }

    /**
     * Validasi atribut: page contentable
     * 
     */
    public function contentableValidation(): array
    {
        return [
            'required',
            'string',
            'min:3',
            'max:100'
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
            'min:32',
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
     * Validasi atribut: content
     * 
     */
    public function contentValidation(): array
    {
        return [
            'required',
            'string',
            'max:8000'
        ];
    }

    /**
     * Product Id Validation
     * Base Validation Form Application
     * Public Information Validation Form Application
     * 
     */
    use BaseValidationFormApp;

    /**
     * membangun koneksi
     * ke Production
     * 
     */
    public function build(): Production
    {
        return new PageFeature();
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

    /**
     * page contentable validation
     * 
     */
    use PageContentableDynamicValidation;

    /**
     * Validasi data Page Contentable
     * sesuai nilai (value) dan model:value
     * 
     */
    public function adjustment(string $modelValue, array $contents): ?string
    {
        // definisikan nilai modelValue
        $model = PageContentable::tryFrom($modelValue);
        if(empty($contents)) return null;
        
        /**
         * as TEXT
         * 
         */
        if($model === PageContentable::TEXT){
            $result = [
                'content' => $contents['content']
            ];
            $result = json_encode($result);
            return (string) $result;
        }

        /**
         * as ARTICLE
         * 
         */
        elseif($model === PageContentable::ARTICLE){
            $result = [
                'content' => $contents['content']
            ];
            $result = json_encode($result);
            return (string) $result;
        }

        /**
         * as TAG
         * 
         */
        elseif($model === PageContentable::TAG){}

        /**
         * as IMAGE
         * 
         */
        elseif($model === PageContentable::IMAGE){
            $result = [
                'id' => $contents['id'],
                'image' => $contents['image'],
                'description' => $contents['description']
            ];
            $result = json_encode($result);
            return (string) $result;
        }

        /**
         * as IMAGES
         * 
         */
        elseif($model === PageContentable::IMAGES){}

        /**
         * as BANNER
         * 
         */
        elseif($model === PageContentable::BANNER){
            $result = [
                'id' => $contents['id'],
                'banner' => $contents['banner'],
                'description' => $contents['description']
            ];
            $result = json_encode($result);
            return (string) $result;
        }

        /**
         * as BANNERS
         * 
         */
        elseif($model === PageContentable::BANNERS){}
        
        /**
         * mismatch
         * 
         */
        return null;
    }

    /**
     * data contentable
     * array()
     * 
     */
    public function dataContentable(): array
    {
        return PageContentable::data();
    }

    /**
     * image upload
     * page contentable: image
     * 
     */
    public function contentableImageUplad(array $attributes): ?array
    {
        $instance = $this->build();
        $upload = $instance->uploadImagePageContentable($attributes);
        if(! $upload) return null;

        return $upload->toArray();
    }
}