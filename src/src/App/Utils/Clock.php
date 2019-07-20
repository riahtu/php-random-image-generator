<?php

namespace App\Utils;

class Clock
{
    /**
     * @return \DateTime
     * @throws \Exception
     */
    public function getDateTime(): \DateTime
    {
        return new \DateTime();
    }
}