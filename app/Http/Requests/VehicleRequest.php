<?php

namespace App\Http\Requests;

use App\Domain\Contracts\ManufacturedAttributesInterface;

class VehicleRequest implements ManufacturedAttributesInterface
{
    protected $modelYear = 0;
    protected $manufacturer = '';
    protected $model = '';
    protected $isClassifiable = false;

    /**
     * @param int $year
     * @return $this
     */
    public function setModelYear($modelYear)
    {
        $this->modelYear = $modelYear;
        return $this;
    }

    /**
     * @param string $manufacturer
     * @return $this
     */
    public function setManufacturer($manufacturer)
    {
        $this->manufacturer = $manufacturer;
        return $this;
    }

    /**
     * @param string $model
     * @return $this
     */
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @param bool $isClassifiable
     * @return $this
     */
    public function setClassifiable($isClassifiable)
    {
        $this->isClassifiable = $isClassifiable;
        return $this;
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
    public function isClassifiable()
    {
        return $this->isClassifiable;
    }
}

