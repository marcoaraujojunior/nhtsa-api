<?php

namespace App\Domain\Contracts;

interface ClassifierInterface
{
    /*
     * @param string $rating
     * @return $this
     */
    public function setRating($rating);

    /*
     * @return string
     */
    public function getRating();
}

