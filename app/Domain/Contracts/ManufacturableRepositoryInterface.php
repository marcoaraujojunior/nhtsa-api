<?php

namespace App\Domain\Contracts;

interface ManufacturableRepositoryInterface
{
    /**
     * @return array
     */
    public function findAll(ManufacturableAttributesInterface $manufacturable);
}

