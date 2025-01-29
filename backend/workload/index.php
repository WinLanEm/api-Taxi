<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../objects/Workload.php';
include_once '../config/dataBase/DB_connection.php';


$db = PostgreSQLConnection::getInstance();
$connection = $db->getConnection();

function index($connection)
{
    $workload = new Workload($connection);
    $result = $workload->index();
    echo($result);
}
index($connection);