<?php

namespace App\Domain\Contracts;

interface ManufacturedRecordInterface
{
    public function findByAttributes(ManufacturedRequestedAttributesInterface $parameters);
}

