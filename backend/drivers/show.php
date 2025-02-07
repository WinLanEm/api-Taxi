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
$id = isset($_GET['id']) ? $_GET['id'] : '';
$headerToken = isset(getallheaders()['Authorization'])?getallheaders()['Authorization']:"";
$token = str_replace('Bearer ','',$headerToken);
function show($connection, $id, $token)
{

    $proxy = new DriversProxy($connection, $token);
    $result = $proxy->show($id);
    echo($result);
}
show($connection,$id, $token);