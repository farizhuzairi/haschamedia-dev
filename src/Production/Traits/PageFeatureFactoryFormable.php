<?php

namespace HaschaDev\Production\Traits;

trait PageFeatureFactoryFormable
{
    // helper variables
    public array $product;
    public ?string $productId;
    public array $service;
    public ?string $serviceId;
    public array $pageService;
    
    /**
     * attributes
     * 
     */
    public ?string $pageServiceId;
    public ?string $contentable;
    public ?string $code;
    public ?string $name;
    public ?string $title;
    public ?string $content;
}