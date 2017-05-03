<?php

namespace App\Domain\Contracts;

interface ManufacturableServiceAdapterInterface
{
    /*
     * @param array $source
     * @param ManufacturableInterface $manufacturable
     * @return array ManufacturableInterface[]
     */
    public function toAdapter(Array $source, ManufacturableInterface $manufacturable);
}
