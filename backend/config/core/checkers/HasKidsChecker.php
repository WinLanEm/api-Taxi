<?php

class HasKidsChecker
{
    private $hasKids;

    /**
     * @return mixed
     */
    public function getHasKids()
    {
        return $this->hasKids;
    }

    /**
     * @param mixed $hasKids
     */
    public function setHasKids($hasKids): void
    {
        $this->hasKids = $hasKids;
    }
    public function calculate($currentPrice)
    {
        if($this->hasKids){
            return $currentPrice * 1.3;
        }
        return $currentPrice;
    }
}