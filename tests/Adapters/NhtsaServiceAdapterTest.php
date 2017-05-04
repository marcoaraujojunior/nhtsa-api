<?php

namespace App\Test\Controller;

use App\Domain\Entities\VehicleEntity;
use App\Infrastructure\Adapters\NhtsaServiceAdapter;


class NhtsaServiceAdapterTest extends \TestCase
{
    public function testToAdapterShouldReturnArrayOfVehicleEntityWhenSourceIsAValidArray()
    {
        $adapter = new NhtsaServiceAdapter;
        $entity = new VehicleEntity;

        $source = [
            [
                'modelYear' => 2015,
                'manufacturer' => 'Audi',
                'model' => 'A3',
                'isClassifiable' => false,
                'CrashRating' => 'Not Rated',
                'VehicleDescription' => '2015 Audi A3 4 DR AWD',
                'VehicleId' => 9403,
            ],
        ];

        $entities = $adapter->toAdapter($source, $entity);

        $this->assertEquals(
            2015, $entities[0]->getModelYear()
        );
        $this->assertEquals(
            'Audi', $entities[0]->getManufacturer()
        );
        $this->assertEquals(
            'A3', $entities[0]->getModel()
        );
        $this->assertFalse($entities[0]->isClassifiable());
        $this->assertEquals(
            'Not Rated', $entities[0]->getRating()
        );
        $this->assertEquals(
            '2015 Audi A3 4 DR AWD', $entities[0]->getDescription()
        );
        $this->assertEquals(
            9403, $entities[0]->getId()
        );
    }
}
