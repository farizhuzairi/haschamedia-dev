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
        elseif($model === PageContentable::IMAGES){
            $results = [];
            foreach($contents as $i){
                $results[] = [
                    'id' => $i['id'],
                    'image' => $i['image'],
                    'description' => $i['description']
                ];
            }
            $results = json_encode($results);
            return (string) $results;
        }

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
        elseif($model === PageContentable::BANNERS){
            $results = [];
            foreach($contents as $i){
                $results[] = [
                    'id' => $i['id'],
                    'banner' => $i['banner'],
                    'description' => $i['description']
                ];
            }
            $results = json_encode($results);
            return (string) $results;
        }
        
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
    public function contentableImageUpload(array $attributes): ?array
    {
        $instance = $this->build();
        $upload = $instance->uploadImagePageContentable($attributes);
        if(! $upload) return null;

        return $upload->toArray();
    }

    /**
     * image upload
     * page contentable: images
     * 
     */
    public function contentableImagesUpload(array $attributes): ?array
    {
        $instance = $this->build();

        $results = [];
        foreach($attributes['images'] as $i){
            $upload = $instance->uploadImagePageContentable([
                'pageServiceId' => $attributes['pageServiceId'],
                'title' => $attributes['title'],
                'image' => $i['image']
            ]);
            if($upload){
                $data = $upload->toArray();
                $data['description'] = $i['description'];
                $results[] = $data;
            }
        }

        if(empty($results)) return null;
        return $results;
    }

    /**
     * banner upload
     * page contentable: banner
     * 
     */
    public function contentableBannerUpload(array $attributes): ?array
    {
        $instance = $this->build();
        $upload = $instance->uploadBannerPageContentable($attributes);
        if(! $upload) return null;

        return $upload->toArray();
    }
}