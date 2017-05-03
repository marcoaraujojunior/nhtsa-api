<?php

namespace App\Domain\Contracts;

interface ClassifiableInterface
{
    /**
     * @return bool
     */
    public function isClassifiable();

    /**
     * @param bool $isClassifiable
     * @return $this
     */
    public function setClassifiable($isClassifiable);
}

