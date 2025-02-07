<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");
session_start();
include_once '../objects/Order.php';
include_once '../config/dataBase/DB_connection.php';
include_once '../config/core/proxy/OrdersProxy.php';
$consumer_id = $_SESSION['consumer']['id'];

$db = PostgreSQLConnection::getInstance();
$connection = $db->getConnection();
$headerToken = isset(getallheaders()['Authorization'])?getallheaders()['Authorization']:"";
$token = str_replace('Bearer ','',$headerToken);

function getConsumer($connection,$consumer_id,$token)
{
    $order = new OrdersProxy($connection,$token);
    $result = $order->getConsumer($consumer_id);
    echo($result);
}
getConsumer($connection,$consumer_id,$token);