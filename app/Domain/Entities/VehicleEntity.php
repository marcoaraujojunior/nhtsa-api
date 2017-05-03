<?php

namespace App\Domain\Entities;

use App\Domain\Contracts\ManufacturableInterface;

class VehicleEntity implements ManufacturableInterface
{
    protected $modelYear = 0;
    protected $manufacturer = '';
    protected $model = '';
    protected $isClassifiable = false;
    protected $rating;
    protected $id;
    protected $description;

    /*
     * @return VehicleEntity
     */
    public function newInstance()
    {
        return new self;
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
     * @param bool $isClassifiable
     * @return $this
     */
    public function setClassifiable($isClassifiable)
    {
        $this->isClassifiable = $isClassifiable;
        return $this;
    }

    /*
     * @param string $rating
     * @return $this
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
        return $this;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /*
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /*
     * @return string
     */
    public function getRating()
    {
        return $this->rating;
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

