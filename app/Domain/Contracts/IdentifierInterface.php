<?php

namespace App\Domain\Contracts;

interface IdentifierInterface
{
    /**
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /*
     * @return int
     */
    public function getId();
}
