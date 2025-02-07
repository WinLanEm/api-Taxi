<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

include_once '../objects/Order.php';
include_once '../config/dataBase/DB_connection.php';
include_once '../config/core/proxy/OrdersProxy.php';

$db = PostgreSQLConnection::getInstance();
$connection = $db->getConnection();
$headerToken = isset(getallheaders()['Authorization'])?getallheaders()['Authorization']:"";
$token = str_replace('Bearer ','',$headerToken);


$id = isset($_GET['id'])? (int)$_GET['id']: 0;

function show($connection,$id,$token)
{
    $order = new OrdersProxy($connection,$token);
    $result = $order->read($id);
    echo($result);
}
show($connection,$id,$token);
