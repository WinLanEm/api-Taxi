<?php

require_once "proxyMethods/validation.php";
class OrdersProxy
{
    private $connection;
    private $order;
    private $token;

    public function __construct($connection,$token)
    {
        $this->connection = $connection;
        $this->order = new Order($connection);
        $this->token = $token;
    }

    public function index()
    {
        $this->order->setToken($this->token);
        return $this->order->index();
    }
    public function read($id)
    {
        if($id === 0){
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'Bad request',
            ];
            return json_encode($res);
        }
        $this->order->setToken($this->token);
        $this->order->setId($id);
        return $this->order->read();
    }
    public function create($data)
    {
        if(!isset($data['consumer_id']) || !isset($data['driver_id']) || !isset($data['trip_price'])
            || !isset($data['payment_method']) || !isset($data['payment']) || !isset($data['is_completed'])
            || !isset($data['waiting_price']) || !isset($data['source_street']) || !isset($data['source_house'])
            || !isset($data['final_street']) || !isset($data['final_house']) || !isset($data['city'])){
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'Bad request',
            ];
            return json_encode($res);
        }
        $payment = stringToBool($data['payment']);
        $is_completed = stringToBool($data['is_completed']);
        $consumer_id = (int)$data['consumer_id'] ? : "";
        $driver_id = (int)$data['driver_id'] ? : "";
        $trip_price = (int)$data['trip_price'] ? : "";
        $waiting_price = (int)$data['waiting_price'] ? : "";
        $source_house = (int)$data['source_house'] ? : "";
        $final_house = (int)$data['final_house'] ? : "";
        $consumer_id_type = gettype($consumer_id);
        $driver_id_type = gettype($driver_id);
        $trip_price_type = gettype($trip_price);
        $payment_method_type = gettype($data['payment_method']);
        $payment_type = gettype($payment);
        $is_completed_type = gettype($is_completed);
        $waiting_price_type = gettype($waiting_price);
        $source_house_type = gettype($source_house);
        $source_street_type = gettype($data['source_street']);
        $final_house_type = gettype($final_house);
        $final_street_type = gettype($data['final_street']);
        $city_type = gettype($data['city']);
        if($consumer_id_type !== 'integer' || $driver_id_type !== 'integer' || $trip_price_type !== "integer" ||
        $payment_method_type !== 'string' || $payment_type !== 'boolean' || $is_completed_type !== 'boolean' ||
        $waiting_price_type !== 'integer' || $source_house_type !== 'integer' || $source_street_type !== 'string' ||
        $final_house_type !== 'integer' || $final_street_type !== 'string' || $city_type !== 'string'){
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'Bad request'
            ];
            return json_encode($res);
        }
        $source_street = strtolower($data['source_street']);
        $final_street = strtolower($data['final_street']);
        $city = strtolower($data['city']);
        $this->order->setConsumerId($data['consumer_id']);
        $this->order->setDriverId($data['driver_id']);
        $this->order->setTripPrice($data['trip_price']);
        $this->order->setPaymentMethod($data['payment_method']);
        $this->order->setPayment(boolToString($payment));
        $this->order->setIsCompleted(boolToString($is_completed));
        $this->order->setWaitingPrice($data['waiting_price']);
        $this->order->setSourceStreet($source_street);
        $this->order->setSourceHouse($source_house);
        $this->order->setFinalStreet($final_street);
        $this->order->setFinalHouse($final_house);
        $this->order->setCity($city);
        $this->order->setToken($this->token);
        return $this->order->create();
    }
    public function update($data)
    {
        if(!isset($data['id']) || !isset($data['consumer_id']) ||
            !isset($data['driver_id']) || !isset($data['trip_price']) ||
            !isset($data['payment_method']) || !isset($data['payment']) ||
            !isset($data['is_completed']) || !isset($data['waiting_price']) ||
            !isset($data['source_street']) || !isset($data['source_house']) ||
            !isset($data['final_street']) || !isset($data['final_house']) || !isset($data['city'])){
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'Bad request',
            ];
            return json_encode($res);
        }

        $payment = stringToBool($data['payment']);
        $is_completed = stringToBool($data['is_completed']);
        $id = (int)$data['id'] ? : "";
        $consumer_id = (int)$data['consumer_id'] ? : "";
        $driver_id = (int)$data['driver_id'] ? : "";
        $trip_price = (int)$data['trip_price'] ? : "";
        $waiting_price = (int)$data['waiting_price'] ? : "";
        $source_house = (int)$data['source_house'] ? : "";
        $final_house = (int)$data['final_house'] ? : "";
        $id_type = gettype($id);
        $consumer_id_type = gettype($consumer_id);
        $driver_id_type = gettype($driver_id);
        $trip_price_type = gettype($trip_price);
        $payment_method_type = gettype($data['payment_method']);
        $payment_type = gettype($payment);
        $is_completed_type = gettype($is_completed);
        $waiting_price_type = gettype($waiting_price);
        $source_house_type = gettype($source_house);
        $source_street_type = gettype($data['source_street']);
        $final_house_type = gettype($final_house);
        $final_street_type = gettype($data['final_street']);
        $city_type = gettype($data['city']);
        if($id_type !== 'integer' || $consumer_id_type !== 'integer' || $driver_id_type !== 'integer' ||
            $trip_price_type !== "integer" ||
            $payment_method_type !== 'string' || $payment_type !== 'boolean' || $is_completed_type !== 'boolean' ||
            $waiting_price_type !== 'integer' || $source_house_type !== 'integer' || $source_street_type !== 'string' ||
            $final_house_type !== 'integer' || $final_street_type !== 'string' || $city_type !== 'string'){
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'Bad request'
            ];
            return json_encode($res);
        }
        $stringPayment = boolToString($payment);
        $stringIsCompleted = boolToString($is_completed);
        $source_street = strtolower($data['source_street']);
        $final_street = strtolower($data['final_street']);
        $city = strtolower($data['city']);
        $this->order->setId($data['id']);
        $this->order->setConsumerId($data['consumer_id']);
        $this->order->setDriverId($data['driver_id']);
        $this->order->setTripPrice($data['trip_price']);
        $this->order->setPaymentMethod($data['payment_method']);
        $this->order->setPayment($stringPayment);
        $this->order->setIsCompleted($stringIsCompleted);
        $this->order->setWaitingPrice($data['waiting_price']);
        $this->order->setSourceStreet($source_street);
        $this->order->setSourceHouse($source_house);
        $this->order->setFinalStreet($final_street);
        $this->order->setFinalHouse($final_house);
        $this->order->setCity($city);
        $this->order->setToken($this->token);
        return $this->order->update();
    }
    public function delete($id)
    {
        if($id === 0){
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'Bad request'
            ];
            return json_encode($res);
        }
        $this->order->setId($id);
        $this->order->setToken($this->token);
        return $this->order->delete();
    }
    public function getConsumer($id,$consumer_id)
    {
        if($id === 0 || $consumer_id === 0){
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'Bad request'
            ];
            return json_encode($res);
        }
        $this->order->setToken($this->token);
        $this->order->setId($id);
        $this->order->setConsumerId($consumer_id);
        return $this->order->getConsumer();
    }
    public function getDriver($id,$driver_id)
    {
        if($id === 0 || $driver_id === 0){
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'Bad request'
            ];
            return json_encode($res);
        }
        $this->order->setToken($this->token);
        $this->order->setId($id);
        $this->order->setDriverId($driver_id);
        return $this->order->getDriver();
    }
}