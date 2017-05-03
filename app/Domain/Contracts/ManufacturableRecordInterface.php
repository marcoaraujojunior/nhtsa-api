<?php

namespace App\Domain\Contracts;

interface ManufacturableRecordInterface
{
    public function findByAttributes(ManufacturableAttributesInterface $parameters);
}

