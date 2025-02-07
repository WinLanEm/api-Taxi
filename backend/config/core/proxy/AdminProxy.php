<?php

class AdminProxy
{
    private $connection;
    private $admin;
    public function __construct($connection)
    {
        $this->connection = $connection;
        $this->admin = new Admin($connection);
    }

    public function createAdmin($adminToken,$data)
    {
        if(!$data['admin_token'] || !$data['login'] || !$data['password']){
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'Bad request',
            ];
            return json_encode($res);
        }
        if($data['admin_token'] !== $adminToken){
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'incorrect admin token'
            ];
            return json_encode($res);
        }
        $this->admin->setLogin($data['login']);
        $this->admin->setPassword($data['password']);
        return $this->admin->createAdmin();
    }
}