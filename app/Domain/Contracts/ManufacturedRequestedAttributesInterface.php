<?php

namespace App\Domain\Contracts;

interface ManufacturedRequestedAttributesInterface
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
     * @param bool $withRating
     * @return $this
     */
    public function setWithRating($withRating);

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
}
