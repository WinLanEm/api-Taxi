<?php

header('Content-type: application/json');
require_once '../business_methods/Drivers_methods/driversMethods.php';
require_once '../business_methods/DB_connection.php';
require_once '../business_methods/Consumers_methods/consumersMethods.php';


$db = PostgreSQLConnection::getInstance();
$connection = $db->getConnection();
$method = $_SERVER['REQUEST_METHOD'];
$q = $_GET['q'];
$params = explode('/',$q);

$type = $params[0];
$id = isset($params[1]) ? $params[1] : false;

//1
switch ($method){
    case 'GET':{
        if($type === 'consumers' && $id){
            getConsumersById($connection,$id);
            return;
        }else if($type === 'consumers'){
            getAllConsumers($connection);
            return;
        }
        if($type === 'drivers' && $id){
            getDriverById($connection,$id);
            return;
        }else if($type === 'drivers'){
            getAllDrivers($connection);
            return;
        }
        break;
    }
    case 'POST':{
        if($type === 'drivers'){
            createDriver($connection, $_POST);
            return;
        }
        break;
    }
    case 'PATCH':{
        if($type === 'drivers' && $id){
            $data = file_get_contents('php://input');
            $data = json_decode($data,true);
            updateDriver($connection,$data,$id);
            return;
        }
        break;
    }
    case 'DELETE':{
        if($type === 'drivers' && $id){
            deleteDriver($connection,$id);
            return;
        }
        break;
    }
}


























//
//header('Content-type: application/json');
//global $connect;
//require '../DB_connections/DB_connection.php';
//require '../business_methods/driversMethods.php';
//
//$method = $_SERVER['REQUEST_METHOD'];
//
//if (!$connect) {
//    die("Ошибка подключения к базе данных: " . pg_last_error());
//}
//
//$q = $_GET['q'];
//$params = explode('/',$q);
//
//$type = $params[0];
//if(isset($params[1])){
//    $id = $params[1];
//}
//
//switch ($method){
//    case 'GET':
//        if($type === 'posts'){
//            if(isset($id)){
//                getPost($connect,$id);
//                return;
//            }
//            getPosts($connect);
//        }
//        break;
//    case 'POST':
//        if($type === 'posts'){
//            addPosts($connect,$_POST);
//        }
//        break;
//    case 'PATCH':
//        if($type === 'posts'){
//            if(isset($id)){
//                $data = file_get_contents('php://input');
//                $data = json_decode($data,true);
//                updatePosts($connect,$data,$id);
//            }
//        }
//        break;
//    case 'DELETE':
//        if($type === 'posts'){
//            if(isset($id)){
//                deletePost($connect,$id);
//            }
//        }
//        break;
//}





