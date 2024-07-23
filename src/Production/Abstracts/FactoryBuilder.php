<?php

namespace HaschaDev\Production\Abstracts;

interface FactoryBuilder
{
    /**
     * get data modelable toArray()
     * menampilkan semua data objek dalam koleksi array
     * 
     */
    public function get(): array;

    /**
     * find data modelable toArray()
     * menampilkan data objek dalam array
     * 
     */
    public function find(string $id): array;
    
    /**
    * get where data modelable toArray()
    * menampilkan semua data objek dalam koleksi array
    * berdasarkan foreign key
    * 
    */
    public function getWhere(array $foreigns = []): array;
}