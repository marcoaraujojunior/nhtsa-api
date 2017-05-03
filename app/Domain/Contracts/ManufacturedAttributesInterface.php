<?php

namespace App\Domain\Contracts;

interface ManufacturedAttributesInterface
{
    /**
     * @param int $year
     * @return $this
     */
    public function setModelYear($modelYear);

    /**
     * @param string $manufacturer
     * @return $this
     */
    public function setManufacturer($manufacturer);

    /**
     * @param string $model
     * @return $this
     */
    public function setModel($model);

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
}

