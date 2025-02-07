<?php

class DistanceChecker
{
    private $kilometers;

    /**
     * @return mixed
     */
    public function getKilometers()
    {
        return $this->kilometers;
    }

    /**
     * @param mixed $kilometers
     */
    public function setKilometers($kilometers): void
    {
        $this->kilometers = $kilometers;
    }

    public function calculate($currentPrice)
    {
        $kilometersPrice = $this->kilometers * 20;
        return $currentPrice + $kilometersPrice;
    }
}