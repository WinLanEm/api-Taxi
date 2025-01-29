<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../objects/Distance.php';

$data = isset($_GET)? $_GET: "";
$source_address = isset($data['source_address'])?$data['source_address']:"";
$final_address = isset($data['final_address'])?$data['final_address']:"";
$city = isset($data['city'])?$data['city']:"";

function calculateDistance($source_address, $final_address, $city)
{
    $distance = new Distance();
    $distance->setCity($city);
    $distance->setFinalAddress($final_address);
    $distance->setSouceAddress($source_address);
    $result = $distance->calculateDistance();
    echo($result);
}
calculateDistance($source_address, $final_address, $city);