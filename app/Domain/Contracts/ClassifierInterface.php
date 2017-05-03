<?php

namespace App\Domain\Contracts;

interface ClassifierInterface
{

    /**
     * @param bool $withRating
     * @return $this
     */
    public function setWithRating($withRating);

    /**
     * @return bool
     */
    public function withRating();
}

