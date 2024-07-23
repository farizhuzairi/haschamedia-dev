<?php

namespace HaschaDev\Production\Traits;

trait PackageFactoryFormable
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
    public ?string $code = null;
    public ?string $name;
    public ?string $description;
    public ?string $alias;
    public ?string $tagline;
    public ?string $details;
}