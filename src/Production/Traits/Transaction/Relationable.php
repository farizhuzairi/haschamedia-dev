<?php

namespace HaschaDev\Production\Traits\Transaction;

trait Relationable
{
    /**
     * get where data modelable toArray()
     * menampilkan semua data objek dalam koleksi array
     * berdasarkan foreign key
     * 
     */
    public function getWhere(array $foreigns = []): array
    {
        $instance = $this->build();
        return $instance->getWhereModelable($foreigns, true);
    }
}