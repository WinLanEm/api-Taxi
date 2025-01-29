<?php
class ConsumersProxy
{
    private $connection;
    private $consumer;

    public function __construct($connection)
    {
        $this->connection = $connection;
        $this->consumer = new Consumer($connection);
    }

    public function index()
    {
        return $this->consumer->index();
    }
    public function show($id)
    {
        if(!$id){
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'Enter id'
            ];
            return json_encode($res);
        }
        $this->consumer->setId($id);
        return $this->consumer->show();
    }
    public function create($data)
    {
        if(!isset($data['phone']) || !isset($data['name']) || !isset($data['password'])){
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
        if(strlen($data['password'])<9){
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
        $this->consumer->setPhone($phone);
        $this->consumer->setStatus('active');
        $this->consumer->setPassword($data['password']);
        $this->consumer->setRating(0);
        $this->consumer->setName($data['name']);
        $this->consumer->setCountTrips(0);
        return $this->consumer->create();
    }
    public function update($data)
    {
        if(!isset($data['phone']) || !isset($data['name']) || !isset($data['password']) || !isset($data['rating']) || !isset($data['status']) || !isset($data['count_trips']) || !isset($data['id'])){
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
        if(strlen($data['password'])<9){
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
        $this->consumer->setPhone($phone);
        $this->consumer->setStatus($data['status']);
        $this->consumer->setPassword($data['password']);
        $this->consumer->setRating($data['rating']);
        $this->consumer->setName($data['name']);
        $this->consumer->setCountTrips($data['count_trips']);
        $this->consumer->setId($data['id']);
        return $this->consumer->update();
    }
    public function delete($id)
    {
        if(!$id){
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'Enter id'
            ];
            return json_encode($res);
        }
        $this->consumer->setId($id);
        return $this->consumer->delete();
    }
}