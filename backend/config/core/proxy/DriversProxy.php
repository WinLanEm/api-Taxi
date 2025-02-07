<?php

class DriversProxy
{
    private $connection;
    private $driver;
    private $token;
    public function __construct($connection,$token)
    {
        $this->connection = $connection;
        $this->driver = new Driver($this->connection);
        $this->token = $token;
    }

    public function index()
    {
        //выполняю проверки
        $this->driver->setToken($this->token);
        return $this->driver->index();
    }
    public function show($id)
    {
        if(!$id){
            $res = [
                'status' => false,
                'message' => 'Enter id'
            ];
            http_response_code(404);
            return json_encode($res);
        }
        $this->driver->setToken($this->token);
        $this->driver->setId($id);
        return $this->driver->show();
    }
    public function create($data)
    {
        if(!isset($data['phone']) || !isset($data['model']) || !isset($data['brand']) || !isset($data['name']) || !isset($data['password'])){
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'Bad request'
            ];
            return json_encode($res);
        }
        $phone = $data['phone'];
        if (!preg_match('/^(\+7|8|7)/', $phone)) {
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'the phone number must start with +7, 8 or 7'
            ];
            return json_encode($res);
        }
        if (strpos($phone, '+7') === 0) {
            $phone = '8' . substr($phone, 2);
        }
        if (strlen($phone) !== 11) {
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'invalid phone'
            ];
            return json_encode($res);
        }
        if(strlen($data['password'])<8){
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'The password is too short'
            ];
            return json_encode($res);
        }
        if($data['password'] === strtolower($data['password'])){
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'The password must contain at least one uppercase letter'
            ];
            return json_encode($res);
        }
        $this->driver->setToken($this->token);
        $this->driver->setPhone($phone);
        $this->driver->setModel($data['model']);
        $this->driver->setBrand($data['brand']);
        $this->driver->setName($data['name']);
        $this->driver->setPassword($data['password']);
        return $this->driver->create();
    }

    public function update($data,$driverId)
    {
        if(!isset($data['location'])){
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'Bad request'
            ];
            return json_encode($res);
        }
        $this->driver->setId($driverId);
        $this->driver->setLocation($data['location']);
        $this->driver->setToken($this->token);
        return $this->driver->update();
    }
    public function delete($id)
    {
        if(!$id){
            http_response_code('400');
            $res = [
                'status' => false,
                'message' => 'Enter id',
            ];
            return json_encode($res);
        }
        $this->driver->setToken($this->token);
        $this->driver->setId($id);
        return $this->driver->delete();
    }
    public function driverLogin($data)
    {
        $phone = isset($data['phone'])? $data['phone'] : "";
        $password = isset($data['password'])? $data['password'] : "";
        if(!$password || !$phone){
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'Bad request'
            ];
            return json_encode($res);
        }
        if (!preg_match('/^(\+7|8|7)/', $phone)) {
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'the phone number must start with +7, 8 or 7'
            ];
            return json_encode($res);
        }
        if (strpos($phone, '+7') === 0) {
            $phone = '8' . substr($phone, 2);
        }
        if (strlen($phone) !== 11) {
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'invalid phone'
            ];
            return json_encode($res);
        }
        $this->driver->setToken($this->token);
        $this->driver->setPassword($password);
        $this->driver->setPhone($phone);
        return $this->driver->driverLogin();
    }
    public function statusChange($data,$driverId)
    {
        if(!$data['status']){
            $res = [
                'status' => false,
                'message' => 'Bad request'
            ];
            return json_encode($res);
        }
        if($data['status'] != 'active' && $data['status'] != 'inactive'){
            $res = [
                'status' => false,
                'message' => 'Bad request'
            ];
            return json_encode($res);
        }
        $this->driver->setStatus($data['status']);
        $this->driver->setToken($this->token);
        $this->driver->setId($driverId);
        return $this->driver->statusChange();
    }
    public function getOrder($id)
    {
        if(!$id){
            $res = [
                'status' => false,
                'message' => 'Enter id'
            ];
            http_response_code(404);
            return json_encode($res);
        }
        $this->driver->setToken($this->token);
        $this->driver->setId($id);
        return $this->driver->getOrder();
    }
    public function cancelOrder($id)
    {
        if(!$id){
            $res = [
                'status' => false,
                'message' => 'Enter id'
            ];
            http_response_code(404);
            return json_encode($res);
        }
        $this->driver->setToken($this->token);
        $this->driver->setId($id);
        return $this->driver->cancelOrder();
    }
}