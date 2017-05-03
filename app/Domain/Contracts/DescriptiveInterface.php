<?php

namespace App\Domain\Contracts;

interface DescriptiveInterface
{
    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description);

    /**
     * @return string
     */
    public function getDescription();
}
