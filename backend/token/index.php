<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

include_once '../objects/Token.php';
include_once '../config/dataBase/DB_connection.php';
include_once '../config/core/proxy/TokenProxy.php';

$db = PostgreSQLConnection::getInstance();
$connection = $db->getConnection();

$data = isset($_GET)? $_GET: "";

function getToken($connection,$data){
    $proxy = new TokenProxy($connection);
    $result = $proxy->getToken($data);
    echo($result);
}
getToken($connection,$data);


