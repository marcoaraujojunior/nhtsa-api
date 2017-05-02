<?php

namespace App\Domain\Repositories;

use App\Domain\Contracts\ManufacturedRecordInterface;
use App\Domain\Contracts\ManufacturedRequestedAttributesInterface;
use App\Domain\Contracts\ManufacturedRepositoryInterface;

class VehicleRepository implements ManufacturedRepositoryInterface
{
    protected $record;

    public function __construct(ManufacturedRecordInterface $record)
    {
        $this->record = $record;
    }

    public function findAll(ManufacturedRequestedAttributesInterface $vehicle)
    {
        return $this->record->findByAttributes($vehicle);
    }
}

