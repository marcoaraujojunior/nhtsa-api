<?php

namespace App\Test\Repositories;

use \Mockery;

use App\Domain\Repositories\VehicleRepository;
use App\Domain\Contracts\ManufacturedRecordInterface;
use App\Domain\Contracts\ManufacturedRequestedAttributesInterface;

class VehicleRepositoryTest extends \TestCase
{
    public function testFindAllShouldReturnTheSameResultOfFindByAttributesResults()
    {

        $record = Mockery::mock('App\Domain\Contracts\ManufacturedRecordInterface');
        $record->shouldReceive('findByAttributes')->andReturn(['the' => 'same'])->mock();

        $vehicle = Mockery::mock('App\Domain\Contracts\ManufacturedRequestedAttributesInterface');

        $repostory = new VehicleRepository($record);
        $this->assertEquals(
            ['the' => 'same'], $repostory->findAll($vehicle)
        );
    }
}

