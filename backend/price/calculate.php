<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../config/core/checkers/CarClassChecker.php';
include_once '../config/core/checkers/WeatherChecker.php';
include_once '../config/core/checkers/WorkloadChecker.php';
include_once '../config/core/checkers/DistanceChecker.php';
include_once '../config/core/proxy/CalculatePriceProxy.php';

$data = isset($_POST)? $_POST: "";


function calculatePrice($data){
    $weather = isset($data['weather'])? $data['weather']: "";
    $carClass = isset($data['car_class'])? $data['car_class']: "";
    $activeDriver = isset($data['active_driver'])? (int)$data['active_driver']: 0;
    $activeConsumer = isset($data['active_consumer'])? (int)$data['active_consumer']: 0;
    $kilometers = isset($data['kilometers'])? (float)$data['kilometers']: 0;
    $proxy = new CalculatePriceProxy($weather,$carClass,$activeDriver,$activeConsumer,$kilometers);
    $result = round($proxy->calculate());
    echo($result);
}
calculatePrice($data);


