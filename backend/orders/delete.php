<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../objects/Order.php';
include_once '../config/dataBase/DB_connection.php';
include_once '../config/core/proxy/OrdersProxy.php';

$db = PostgreSQLConnection::getInstance();
$connection = $db->getConnection();

$data = file_get_contents('php://input');
$data = json_decode($data,true);
$id = isset($data['id'])? $data['id']: 0;
$headerToken = isset(getallheaders()['Authorization'])?getallheaders()['Authorization']:"";
$token = str_replace('Bearer ','',$headerToken);

function delete($connection,$id,$token)
{
    $order = new OrdersProxy($connection,$token);
    $result = $order->delete($id);
    echo($result);
}
delete($connection,$id,$token);