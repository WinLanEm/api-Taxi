<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// получаем соединение с базой данных
include_once '../objects/Admin.php';
include_once '../config/dataBase/DB_connection.php';
include_once '../config/core/proxy/AdminProxy.php';
include_once '../config/core/loadEnv.php';

$db = PostgreSQLConnection::getInstance();
$connection = $db->getConnection();

$data = isset($_POST)? $_POST:"";
$adminToken = $_ENV['ADMIN_TOKEN'];
function createAdmin($connection,$data,$adminToken)
{
    $proxy = new AdminProxy($connection);
    $result = $proxy->createAdmin($adminToken,$data);
    echo($result);
}
createAdmin($connection,$data,$adminToken);