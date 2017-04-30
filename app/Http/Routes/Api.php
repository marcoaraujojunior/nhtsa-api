<?php

namespace App\Http\Routes;

class Api extends AbstractRouter
{
    protected function routes()
    {
        $this->listVehicles();
    }

    protected function listVehicles()
    {
        $this->getRouter()->get(
            '/vehicles/{year}/{manufacturer}/{model}',
            'VehiclesController@allByAttributes'
        );
    }
}

