<?php

namespace App\Domain\Model\Vehicle;

use App\Domain\Contracts\ManufacturedRecordInterface;
use App\Domain\Contracts\ManufacturedAttributesInterface;

class Vehicle implements ManufacturedAttributesInterface
{
    protected $modelYear = 0;
    protected $manufacturer = '';
    protected $model = '';
    protected $withRating = false;
    protected $record;

    public function __construct(ManufacturedRecordInterface $record)
    {
        $this->record = $record;
    }

    public function findAll()
    {
        return $this->record->findByAttributes($this);
    }

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
     * @param bool $withRating
     * @return $this
     */
    public function setWithRating($withRating)
    {
        $this->withRating = $withRating;
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
    public function withRating()
    {
        return $this->withRating;
    }
}

