<?php
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Access-Control-Allow-Credentials: true');

include_once '../objects/Workload.php';
include_once '../config/dataBase/DB_connection.php';


$db = PostgreSQLConnection::getInstance();
$connection = $db->getConnection();

$headerToken = isset(getallheaders()['Authorization'])?getallheaders()['Authorization']:"";
$token = str_replace('Bearer ','',$headerToken);


function index($connection,$token)
{
    $workload = new Workload($connection,$token);
    $result = $workload->index();
    echo($result);
}
index($connection,$token);