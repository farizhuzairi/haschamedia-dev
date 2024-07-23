<?php

namespace HaschaDev\Production\Traits;

trait ServiceFactoryFormable
{
    // helper variables
    public array $product;
    
    /**
     * attributes
     * 
     */
    public ?string $productId;
    public ?string $code = null;
    public ?string $name;
    public ?string $description;
    public ?string $alias;
    public ?string $tagline;
    public ?string $details;
    public ?object $logo = null;
    public ?string $serviceable;

    /**
     * logo delete
     * 
     */
    public function logoRemove()
    {
        $this->logo = null;
    }
}