<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

include_once '../objects/Workload.php';
include_once '../config/dataBase/DB_connection.php';


$db = PostgreSQLConnection::getInstance();
$connection = $db->getConnection();

$headerToken = isset(getallheaders()['Authorization'])?getallheaders()['Authorization']:"";
$token = str_replace('Bearer ','',$headerToken);


function index($connection,$token)
{
    $workload = new Workload($connection,$token);
    $result = $workload->index();
    echo($result);
}
index($connection,$token);