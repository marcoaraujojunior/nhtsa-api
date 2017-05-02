<?php

namespace App\Test\Shared;

use App\Domain\Shared\Vehicle;

class VehicleTest extends \TestCase
{
    public function testNewInstanceShouldReturneDifferentInstance()
    {
        $vehicle = new Vehicle(1, 'A', 'B');
        $newVehicle = $vehicle->newInstance(2, 'C', 'D', true);

        $this->assertNotEquals($vehicle, $newVehicle);
    }

    public function testGetsMethodsShouldReturnConstructorValues()
    {
        $vehicle = new Vehicle(1, 'A', 'B', true);

        $this->assertEquals(
            1, $vehicle->getModelYear()
        );
        $this->assertEquals(
            'A', $vehicle->getManufacturer()
        );
        $this->assertEquals(
            'B', $vehicle->getModel()
        );
        $this->assertTrue($vehicle->withRating());
    }
}


