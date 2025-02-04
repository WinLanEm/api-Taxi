<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
session_start();


$session = isset($_SESSION['consumer'])? $_SESSION['consumer']: "";

if($session){
    $res = [
        'status' => false,
        'message' => 'consumer authorized'
    ];
    echo(json_encode($res));
}else{
    $res = [
        'status' => true,
        'message' => 'consumer not authorize'
    ];
    echo(json_encode($res));
}
