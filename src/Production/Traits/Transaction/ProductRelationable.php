<?php

namespace HaschaDev\Production\Traits\Transaction;

trait ProductRelationable
{
    /**
     * get By Product Modelable
     * [no interface]
     * 
     */
    public function getByProduct(string $productId): array
    {
        $instance = $this->build();
        return $instance->getByProductModelable($productId);
    }
}