<?php

namespace HaschaDev\Production\Traits;

trait PageContentableFactoryFormable
{
    /**
     * attributes
     * 
     */
    public string $pageServiceId;
    public string $contentable;
    public ?object $image = null;
    public array $images = [];
    public ?object $banner = null;
    public array $banners = [];
    public ?string $content = null;
    public ?string $description = null;
    

    /**
     * bannerRemove
     * 
     */
    public function bannerRemove(): void
    {
        $this->banner = null;
    }
    

    /**
     * imageRemove
     * 
     */
    public function imageRemove(): void
    {
        $this->image = null;
    }

    /**
     * images uploaded
     * 
     */
    public ?object $imageUploaded = null;
    public function updatedImageUploaded(?object $value): void
    {
        if($value){
            $this->images['image'] = $value;
        }

        $this->imageUploaded = null;
    }
}