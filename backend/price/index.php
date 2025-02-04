<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

include_once '../config/core/checkers/CarClassChecker.php';
include_once '../config/core/checkers/WeatherChecker.php';
include_once '../config/core/checkers/WorkloadChecker.php';
include_once '../config/core/checkers/DistanceChecker.php';
include_once '../config/core/checkers/HasKidsChecker.php';
include_once '../config/core/proxy/CalculatePriceProxy.php';
include_once '../config/dataBase/DB_connection.php';

$data = isset($_GET)? $_GET: "";
$headerToken = isset(getallheaders()['Authorization'])?getallheaders()['Authorization']:"";
$token = str_replace('Bearer ','',$headerToken);
$db = PostgreSQLConnection::getInstance();
$connection = $db->getConnection();

function calculatePrice($data,$token,$connection){
    $weather = isset($data['weather'])? (string)$data['weather']: "";
    $carClass = isset($data['car_class'])? (string)$data['car_class']: "";
    $activeDriver = isset($data['active_drivers'])? (int)$data['active_drivers']: 0;
    $activeConsumer = isset($data['active_consumers'])? (int)$data['active_consumers']: 0;
    $kilometers = isset($data['kilometers'])? (float)$data['kilometers']: 0;
    $hasKids = isset($data['has_kids'])? $data['has_kids']: null;
    $proxy = new CalculatePriceProxy($weather,$carClass,$activeDriver,$activeConsumer,$kilometers,$hasKids,$connection);
    $validate = $proxy->validate($token);
    if($validate === true){
        $result = round($proxy->calculate());
        echo($result);
    }else{
        echo($validate);
    }

}
calculatePrice($data,$token,$connection);


