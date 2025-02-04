<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../objects/Consumer.php';
include_once '../config/dataBase/DB_connection.php';
include_once '../config/core/proxy/ConsumersProxy.php';

$db = PostgreSQLConnection::getInstance();
$connection = $db->getConnection();
$headerToken = isset(getallheaders()['Authorization'])?getallheaders()['Authorization']:"";
$token = str_replace('Bearer ','',$headerToken);
function index($connection,$token){
    $proxy = new ConsumersProxy($connection,$token);
    $result = $proxy->index();
    echo $result;
}
index($connection,$token);
