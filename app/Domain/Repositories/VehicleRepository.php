<?php

namespace App\Domain\Repositories;

use App\Domain\Contracts\ManufacturableRecordInterface;
use App\Domain\Contracts\ManufacturableAttributesInterface;
use App\Domain\Contracts\ManufacturableRepositoryInterface;
use App\Domain\Contracts\ManufacturableServiceAdapterInterface;
use App\Domain\Contracts\ManufacturableInterface;

class VehicleRepository implements ManufacturableRepositoryInterface
{
    protected $record;
    protected $adapter;
    protected $vehicleEntity;

    public function __construct(
        ManufacturableRecordInterface $record,
        ManufacturableServiceAdapterInterface $adapter,
        ManufacturableInterface $vehicleEntity
    )
    {
        $this->record = $record;
        $this->adapter = $adapter;
        $this->vehicleEntity = $vehicleEntity;
    }

    public function findAll(ManufacturableAttributesInterface $vehicle)
    {
        $vehicles = $this->record->findByAttributes($vehicle);
        return $this->adapter->toAdapter($vehicles, $this->vehicleEntity);
    }
}

