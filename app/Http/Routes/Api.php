<?php

namespace App\Http\Routes;

class Api extends AbstractRouter
{
    protected function routes()
    {
        $this->getRouter()->get('/', function () use ($app) {
            var_dump(123456);
            return $app->version();
        });
    }
}

