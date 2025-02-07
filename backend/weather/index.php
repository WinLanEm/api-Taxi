<?php
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Access-Control-Allow-Credentials: true');



include_once '../config/core/loadEnv.php';
include_once '../objects/Weather.php';


loadEnv($_SERVER['DOCUMENT_ROOT'] . '/test_rest_api/api/backend/.env');

$data = isset($_GET)? $_GET : "";
$city = isset($data['city'])? $data['city'] : "";
$key = $_ENV['API_WEATHER_KEY'];

function getWeather($city,$key)
{
    $weather = new Weather();
    $weather->setCity($city);
    $weather->setKey($key);
    $result = $weather->getWeather();
    echo($result);
}
getWeather($city,$key);
