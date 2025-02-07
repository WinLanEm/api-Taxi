<?php



class WeatherChecker
{
    private $weather;

    public function getWeather()
    {
        return $this->weather;
    }
    public function setWeather($weather): void
    {
        $this->weather = $weather;
    }
    public function calculate($currentPrice)
    {
        switch ($this->weather){
            case "rainy":
                return $currentPrice * 1.5;
                break;
            case "warm":
                return $currentPrice;
                break;
            case "snowy":
                return $currentPrice * 1.3;
                break;
            case "cold":
                return $currentPrice * 1.7;
                break;
        }

    }


}