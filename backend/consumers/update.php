<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// получаем соединение с базой данных
include_once '../objects/Consumer.php';
include_once '../config/dataBase/DB_connection.php';
include_once '../config/core/proxy/ConsumersProxy.php';

$db = PostgreSQLConnection::getInstance();
$connection = $db->getConnection();
$data = file_get_contents('php://input');
$data = json_decode($data,true);


function update($data,$connection)
{
    $proxy = new ConsumersProxy($connection);
    $result = $proxy->update($data);
    echo($result);
}
update($data,$connection);
