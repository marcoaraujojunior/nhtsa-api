<?php

namespace App\Domain\Contracts;

interface ManufacturableRecordInterface
{
    public function findAll(ManufacturableAttributesInterface $parameters);
}

