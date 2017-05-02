<?php

namespace App\Domain\Contracts;

interface ManufacturedAttributesInterface
{
    /**
     * @return int
     */
    public function getModelYear();

    /**
     * @return string
     */
    public function getManufacturer();

    /**
     * @return string
     */
    public function getModel();

    /**
     * @return bool
     */
    public function withRating();

    /**
     * @return ManufacturedAttributesInterface
     */
    public function newInstance($modelYear, $manufacturer, $model, $withRating = false);
}

