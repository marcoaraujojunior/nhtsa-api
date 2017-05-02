<?php

namespace App\Domain\Repositories;

use App\Domain\Contracts\ManufacturedRecordInterface;
use App\Domain\Contracts\ManufacturedAttributesInterface;
use App\Domain\Contracts\ManufacturedRepositoryInterface;

class VehicleRepository implements ManufacturedRepositoryInterface
{
    protected $record;

    public function __construct(ManufacturedRecordInterface $record)
    {
        $this->record = $record;
    }

    public function findAll(ManufacturedAttributesInterface $vehicle)
    {
        return $this->record->findByAttributes($vehicle);
    }
}

