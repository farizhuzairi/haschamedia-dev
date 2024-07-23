<?php

namespace HaschaDev\Production\Abstracts;

use HaschaDev\Production\Abstracts\Production;

interface PriceBuilder
{
    /**
     * membangun koneksi
     * ke Production
     * 
     */
    public function build(): Production;

    /**
     * ====================================================
     * SERVICE PACKAGE PRICE
     * ====================================================
     * 
     */
    public function setPrice(array $validated, bool $isUpdate = false): array;

    /**
     * get Price
     * 
     */
    public function getPrice(string $packageId): array;
}