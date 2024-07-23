<?php

namespace HaschaDev\Production\Traits;

trait PageServiceFactoryFormable
{
    // helper variables
    public array $product;
    public ?string $productId;
    public array $service;
    
    /**
     * attributes
     * 
     */
    public ?string $serviceId;
    public ?string $routeName = null;
    public ?string $name;
    public ?string $title;
    public ?string $tagline;
    public ?string $description;
    public ?string $content;
}