<?php



class WorkloadChecker
{
    private $activeConsumers;
    private $activeDrivers;

    /**
     * @return mixed
     */
    public function getActiveConsumers()
    {
        return $this->activeConsumers;
    }

    /**
     * @param mixed $activeConsumers
     */
    public function setActiveConsumers($activeConsumers): void
    {
        $this->activeConsumers = $activeConsumers;
    }

    /**
     * @return mixed
     */
    public function getActiveDrivers()
    {
        return $this->activeDrivers;
    }

    /**
     * @param mixed $activeDrivers
     */
    public function setActiveDrivers($activeDrivers): void
    {
        $this->activeDrivers = $activeDrivers;
    }

    function calculate($currentPrice)
    {
        if($this->activeConsumers > $this->activeDrivers * 2){
            return $currentPrice * 1.5;
        }elseif ($this->activeConsumers > $this->activeDrivers * 1.5){
            return $currentPrice * 1.3;
        }elseif ($this->activeConsumers > $this->activeDrivers * 1.2){
            return $currentPrice * 1.1;
        }else{
            return $currentPrice;
        }
    }
}