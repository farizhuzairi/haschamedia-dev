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
    public ?object $banner = null;
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
}