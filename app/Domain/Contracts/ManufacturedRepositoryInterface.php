<?php

namespace App\Domain\Contracts;

interface ManufacturedRepositoryInterface
{
    /**
     * @return array
     */
    public function findAll(ManufacturedAttributesInterface $manufactured);
}

