<?php

namespace app\Contracts\DTO;

interface ArrayableContract
{
    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function toArray(): array;
}
