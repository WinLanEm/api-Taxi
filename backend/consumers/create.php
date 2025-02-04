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

$data = isset($_POST)? $_POST: "";
$headerToken = isset(getallheaders()['Authorization'])?getallheaders()['Authorization']:"";
$token = str_replace('Bearer ','',$headerToken);

function create($connection,$data,$token){
    $proxy = new ConsumersProxy($connection,$token);
    $result = $proxy->create($data);
    echo($result);
}
create($connection,$data,$token);