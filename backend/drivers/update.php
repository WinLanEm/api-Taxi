<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PATCH, OPTIONS");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200); // Возвращаем статус 200 для preflight
    exit;
}
session_start();
include_once '../objects/Driver.php';
include_once '../config/dataBase/DB_connection.php';
include_once '../config/core/proxy/DriversProxy.php';

$db = PostgreSQLConnection::getInstance();
$connection = $db->getConnection();
$data = file_get_contents('php://input');
$data = json_decode($data,true);
$driverId = isset($_SESSION['driver']['id'])?$_SESSION['driver']['id']:0;
$headerToken = isset(getallheaders()['Authorization'])?getallheaders()['Authorization']:"";
$token = str_replace('Bearer ','',$headerToken);

function update($connection,$data,$token,$driverId){
    $proxy = new DriversProxy($connection,$token);
    $result = $proxy->update($data,$driverId);
    echo $result;
}
update($connection,$data,$token,$driverId);
