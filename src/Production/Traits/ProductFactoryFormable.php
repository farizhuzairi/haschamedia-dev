<?php

namespace HaschaDev\Production\Traits;

trait ProductFactoryFormable
{
    /**
     * attributes
     * 
     */
    public ?string $code;
    public ?string $name;
    public ?string $description;
    public ?string $tagline;
    public ?string $details;
    public ?object $logo = null;

    /**
     * logo delete
     * 
     */
    public function logoRemove()
    {
        $this->logo = null;
    }
}