<?php

namespace App\Domain\Shared;

use App\Domain\Contracts\ManufacturedAttributesInterface;

class Vehicle implements ManufacturedAttributesInterface
{
    protected $modelYear;
    protected $manufacturer;
    protected $model;
    protected $withRating;

    public function __construct($modelYear = 0, $manufacturer = '', $model = '', $withRating = false)
    {
        $this->modelYear = $modelYear;
        $this->manufacturer = $manufacturer;
        $this->model = $model;
        $this->withRating = $withRating;
    }

    /**
     * @return App\Domain\Shared\Vehicle
     */
    public function newInstance($modelYear, $manufacturer, $model, $withRating = false)
    {
        return new self($modelYear, $manufacturer, $model, $withRating);
    }

    /**
     * @return int
     */
    public function getModelYear()
    {
        return $this->modelYear;
    }

    /**
     * @return string
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return bool
     */
    public function withRating()
    {
        return $this->withRating;
    }
}


