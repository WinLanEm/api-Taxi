<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:3000"); // Укажите ваш фронтенд
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST");
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '', // Укажите ваш домен
    'secure' => true, // true, если используете HTTPS
    'httponly' => true,
    'sameSite' => 'None' // или 'None'
]);

include_once '../objects/Consumer.php';
include_once '../config/dataBase/DB_connection.php';
include_once '../config/core/proxy/ConsumersProxy.php';



$data = isset($_POST)? $_POST:"";

$db = PostgreSQLConnection::getInstance();
$connection = $db->getConnection();
$headerToken = isset(getallheaders()['Authorization']) ? getallheaders()['Authorization'] : "";
$token = str_replace('Bearer ','',$headerToken);

function consumerLogin($data,$connection,$token)
{
    $proxy = new ConsumersProxy($connection,$token);
    $result = $proxy->consumerLogin($data);
    echo($result);

}
consumerLogin($data,$connection,$token);
