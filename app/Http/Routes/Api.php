<?php

namespace App\Http\Routes;

class Api extends AbstractRouter
{
    protected function routes()
    {
        $this->listVehicles();
        $this->createVehicle();
    }

    protected function listVehicles()
    {
        $this->getRouter()->get(
            '/vehicles/{modelYear}/{manufacturer}/{model}',
            'VehiclesController@allByAttributes'
        );
    }

    protected function createVehicle()
    {
        $this->getRouter()->post(
            'vehicles',
            'VehiclesController@create'
        );
    }
}

