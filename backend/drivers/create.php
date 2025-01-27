<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// получаем соединение с базой данных
include_once '../objects/Driver.php';
include_once '../config/dataBase/DB_connection.php';
include_once '../config/core/proxy/DriversProxy.php';

$db = PostgreSQLConnection::getInstance();
$connection = $db->getConnection();

function create($connection)
{
    $data = isset($_POST)? $_POST: "";
    $proxy = new DriversProxy($connection);
    $result = $proxy->create($data);
    echo($result);
}
create($connection);