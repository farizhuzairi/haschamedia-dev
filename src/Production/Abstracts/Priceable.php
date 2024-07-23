<?php

namespace HaschaDev\Production\Abstracts;

use Illuminate\Support\Collection;

interface Priceable
{
    /**
     * ====================================================
     * SERVICE PACKAGE PRICE
     * ====================================================
     * 
     */
    public function createNewServicePackagePrice(array $attributes): self;

    /**
     * get data Package Price Modelable
     * mengambil semua data model objek aplikasi
     * berdasarkan package id
     * 
     */
    public function getPriceModelable(string $packageId, bool $isArray = true): Collection|array|null;
}