<?php

namespace App\Test\Repositories;

use \Mockery;

use App\Domain\Repositories\VehicleRepository;
use App\Domain\Contracts\ManufacturableInterface;
use App\Domain\Contracts\ManufacturableRecordInterface;
use App\Domain\Contracts\ManufacturableAttributesInterface;
use App\Domain\Contracts\ManufacturableServiceAdapterInterface;

class VehicleRepositoryTest extends \TestCase
{
    public function testFindAllShouldReturnTheSameResultOfFindByAttributesResults()
    {

        $record = Mockery::mock('App\Domain\Contracts\ManufacturableRecordInterface');
        $record->shouldReceive('findByAttributes')->andReturn(['the' => 'same'])->mock();

        $vehicle = Mockery::mock('App\Domain\Contracts\ManufacturableAttributesInterface');

        $adapter = Mockery::mock('App\Domain\Contracts\ManufacturableServiceAdapterInterface');
        $adapter->shouldReceive('toAdapter')->andReturn(['the' => 'same'])->mock();

        $vehicleEntity = Mockery::mock('App\Domain\Contracts\ManufacturableInterface');

        $repostory = new VehicleRepository($record, $adapter, $vehicleEntity);
        $this->assertEquals(
            ['the' => 'same'], $repostory->findAll($vehicle)
        );
    }
}

