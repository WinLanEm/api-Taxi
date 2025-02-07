<?php

function logout()
{
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        unset($_SESSION['user']['id']);
        $res = [
            'status' => true,
            'message' => 'success'
        ];
        return json_encode($res);
    }else{
        http_response_code(400);
        $res = [
            'status' => false,
            'message' => 'Bad method'
        ];
        return json_encode($res);
    }
}
