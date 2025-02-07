<?php

include_once 'proxyMethods/validation.php';


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
    private $hasKids;
    private $hasKidsChecker;
    private $token;
    private $connection;
    public function __construct($weather,$carClass,$activeDrivers,$activeConsumers,$kilometers,$hasKids,$connection)
    {
        $this->carClass = $carClass;
        $this->weather = $weather;
        $this->activeDrivers = $activeDrivers;
        $this->activeConsumers = $activeConsumers;
        $this->kilometers = $kilometers;
        $this->hasKids = stringToBool($hasKids);
        $this->connection = $connection;
        $this->hasKidsChecker = new HasKidsChecker();
        $this->weatherChecker = new WeatherChecker();
        $this->carClassChecker = new CarClassChecker();
        $this->workloadChecker = new WorkloadChecker();
        $this->lengthChecker = new DistanceChecker();
    }
    public function validate($token)
    {
        $sql = "SELECT * FROM admin WHERE token = :token";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
           ':token' => $token
        ]);
        $result = $stml->fetch(PDO::FETCH_ASSOC);
        if(empty($result)){
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'invalid token'
            ];
            return json_encode($res);
        }
        if($this->weather !== "warm" && $this->weather !== "cold" && $this->weather !== "rainy"  && $this->weather !== "snowy"){
            http_response_code(400);
            $res = [
              'status' => false,
              'message' => "The weather can be either warm, cold, rainy, snowy"
            ];
            return json_encode($res);
        }
        if($this->carClass !== "comfort" && $this->carClass !== "economy" && $this->carClass !== "business"){
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => "The car_class can be either comfort, economy, business"
            ];
            return json_encode($res);
        }

        if(!$this->activeDrivers || !$this->activeConsumers || !$this->kilometers || $this->hasKids === null){
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'Bad request',
            ];
            return json_encode($res);
        }
        return true;
    }
    public function calculate()
    {
        $this->carClassChecker->setCarClass($this->carClass);
        $this->weatherChecker->setWeather($this->weather);
        $this->workloadChecker->setActiveDrivers($this->activeDrivers);
        $this->workloadChecker->setActiveConsumers($this->activeConsumers);
        $this->lengthChecker->setKilometers($this->kilometers);
        $this->hasKidsChecker->setHasKids($this->hasKids);

        $result = $this->weatherChecker->calculate
        ($this->carClassChecker->calculate($this->workloadChecker->calculate(
            $this->lengthChecker->calculate($this->hasKidsChecker->calculate(100))
        )));

        return json_encode($result);
    }
}