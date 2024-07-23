<?php

namespace HaschaDev\Production\Traits;

use HaschaDev\Enums\Periodically;

trait PackagePriceFactoryFormable
{
    // helper variables
    public bool $isUpdate = false;
    public array $package;
    public array $periodically = [];

    /**
     * set periodically
     */
    public function setPeriodically(): void
    {
        $this->periodically = Periodically::data();
    }
    
    /**
     * attributes
     * 
     */
    public ?string $packageId;
    public ?string $price = null;
    public ?string $currency;
    public ?string $period;
    public ?string $minOrder;

    /**
     * updated Price
     * 
     */
    public function updatedPrice(string $value): void
    {
        if(!empty($value)){
            $value = str_replace('.', '', $value);
            $value = (int) $value;
            $price = preg_replace('/[^0-9\.]/', '', $value);
            $this->price = number_format($price, 0, ',', '.');
        }
    }

    /**
     * price formatted
     * 
     */
    public function setPriceProperty()
    {
        $this->price = number_format($this->price, 0, ',', '.');
    }
}