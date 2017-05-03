<?php

namespace App\Domain\Contracts;

interface ManufacturedRecordInterface
{
    public function findByAttributes(ManufacturedAttributesInterface $parameters);
}

