<?php

namespace App\Http\Routes;

use Laravel\Lumen\Application as LumenRouter;

abstract class AbstractRouter
{
    protected $options = [];

    abstract protected function routes();

    public function __construct(LumenRouter $router)
    {
        $this->router = $router;
    }

    public function register()
    {
        $this->router->group(
            $this->options,
            function () { $this->routes(); }
        );
    }

    public function setOptions(Array $options)
    {
        $this->options = $options;
        return $this;
    }

    public function getOptiosn()
    {
        return $this->options;
    }

    public function getRouter()
    {
        return $this->router;
    }
}

