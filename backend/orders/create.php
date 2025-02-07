<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
session_start();
include_once '../objects/Order.php';
include_once '../config/dataBase/DB_connection.php';
include_once '../config/core/proxy/OrdersProxy.php';

$data = isset($_POST)?$_POST:"";

$db = PostgreSQLConnection::getInstance();
$connection = $db->getConnection();
$consumer = $_SESSION['consumer']['id'];

$headerToken = isset(getallheaders()['Authorization'])?getallheaders()['Authorization']:"";
$token = str_replace('Bearer ','',$headerToken);
$data['consumer_id'] = $consumer;

function create($connection,$data,$token)
{
    $order = new OrdersProxy($connection,$token);
    $result = $order->create($data);
    echo($result);
}
create($connection,$data,$token);

