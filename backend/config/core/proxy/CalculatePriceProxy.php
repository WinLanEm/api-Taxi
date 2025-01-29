<?php

class CalculatePriceProxy
{
    private $weather;
    private $carClass;
    private $carClassChecker;
    private $weatherChecker;
    private $activeDrivers;
    private $activeConsumers;
    private $workloadChecker;

    private $kilometers;
    private $lengthChecker;
    public function __construct($weather,$carClass,$activeDrivers,$activeConsumers,$kilometers)
    {
        $this->carClass = $carClass;
        $this->weather = $weather;
        $this->activeDrivers = $activeDrivers;
        $this->activeConsumers = $activeConsumers;
        $this->kilometers = $kilometers;
        $this->weatherChecker = new WeatherChecker();
        $this->carClassChecker = new CarClassChecker();
        $this->workloadChecker = new WorkloadChecker();
        $this->lengthChecker = new DistanceChecker();
    }

    public function calculate()
    {
        $this->carClassChecker->setCarClass($this->carClass);
        $this->weatherChecker->setWeather($this->weather);
        $this->workloadChecker->setActiveDrivers($this->activeDrivers);
        $this->workloadChecker->setActiveConsumers($this->activeConsumers);
        $this->lengthChecker->setKilometers($this->kilometers);

        $result = $this->weatherChecker->calculate
        ($this->carClassChecker->calculate($this->workloadChecker->calculate(
            $this->lengthChecker->calculate(100)
        )));

        return json_encode($result);
    }
}