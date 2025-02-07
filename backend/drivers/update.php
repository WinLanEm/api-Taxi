<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../objects/Driver.php';
include_once '../config/dataBase/DB_connection.php';
include_once '../config/core/proxy/DriversProxy.php';

$db = PostgreSQLConnection::getInstance();
$connection = $db->getConnection();
$data = file_get_contents('php://input');
$data = json_decode($data,true);
$id = isset($data['id'])? $data['id']: "";
$headerToken = isset(getallheaders()['Authorization'])?getallheaders()['Authorization']:"";
$token = str_replace('Bearer ','',$headerToken);
function update($connection,$data,$token){
    $proxy = new DriversProxy($connection,$token);
    $result = $proxy->update($data);
    echo $result;
}
update($connection,$data,$token);
