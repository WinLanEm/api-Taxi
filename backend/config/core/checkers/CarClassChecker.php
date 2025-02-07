<?php



class CarClassChecker
{
    private $carClass;

    public function getCarClass()
    {
        return $this->carClass;
    }
    public function setCarClass($carClass): void
    {
        $this->carClass = $carClass;
    }

    //логика
    public function calculate($currentPrice)
    {
        switch ($this->carClass){
            case "comfort":
                return $currentPrice * 2;
                break;
            case "business":
                return $currentPrice * 2.5;
                break;
            case "economy":
                return $currentPrice * 1.5;
                break;
        }
    }

}