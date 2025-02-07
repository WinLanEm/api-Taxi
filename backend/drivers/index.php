<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

include_once '../objects/Driver.php';
include_once '../config/dataBase/DB_connection.php';
include_once '../config/core/proxy/DriversProxy.php';

$db = PostgreSQLConnection::getInstance();
$connection = $db->getConnection();
$headerToken = isset(getallheaders()['Authorization'])?getallheaders()['Authorization']:"";
$token = str_replace('Bearer ','',$headerToken);


function index($connection,$token)
{
    $proxy = new DriversProxy($connection,$token);
    $result = $proxy->index();
    echo($result);
}
index($connection,$token);


