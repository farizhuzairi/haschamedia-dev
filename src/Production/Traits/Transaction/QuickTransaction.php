<?php

namespace HaschaDev\Production\Traits\Transaction;

trait QuickTransaction
{
    /**
     * get data modelable toArray()
     * menampilkan semua data objek dalam koleksi array
     * 
     */
    public function get(): array
    {
        $instance = $this->build();
        return $instance->getModelable(true);
    }

    /**
     * find data modelable toArray()
     * menampilkan data objek dalam array
     * 
     */
    public function find(string $id): array
    {
        $instance = $this->build();
        return $instance->findModelable($id, true);
    }
}