<?php

namespace HaschaDev\Production\PageFeature;

use HaschaDev\Enums\PageContentable;
use HaschaDev\Production\PageFeature\PageFeatureFactory;
use HaschaDev\Production\Traits\FormValidation\PageContentableDynamicValidation;

class PageContentableFactory extends PageFeatureFactory
{
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