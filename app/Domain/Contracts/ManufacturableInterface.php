<?php

namespace App\Domain\Contracts;

interface ManufacturableInterface extends ClassifierInterface, IdentifierInterface, DescriptiveInterface, ManufacturableAttributesInterface
{
    /**
     * @return ManufacturableInterface Instance
     */
    public function newInstance();
}

