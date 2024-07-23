<?php

namespace HaschaDev\Production\Traits;

trait FeatureFactoryFormable
{
    /**
     * attributes
     * 
     */
    public ?string $productId;
    public ?string $modelId;
    public ?string $code = null;
    public ?int $priority;
    public ?string $type;
    public ?string $name;
    public ?string $description;
    public ?string $alias;
    public ?string $tagline;
    public ?string $details;
    public ?string $devInfo;
}