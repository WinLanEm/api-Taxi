<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../objects/Driver.php';
include_once '../config/dataBase/DB_connection.php';
include_once '../config/core/proxy/DriversProxy.php';

$db = PostgreSQLConnection::getInstance();
$connection = $db->getConnection();

function index($connection)
{
    $proxy = new DriversProxy($connection);
    $result = $proxy->index();
    echo($result);
}
index($connection);


