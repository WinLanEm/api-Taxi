<?php

include_once '../config/core/methods/fetch.php';

class Order
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;

    }
    private $table_name = 'orders';
    private $table_consumers = 'consumers';
    private $table_drivers = 'drivers';
    private $id;

    private $token;

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token): void
    {
        $this->token = $token;
    }

    public function getId()
    {
        return $this->id;
    }
    public function setId($id): void
    {
        $this->id = $id;
    }
    private $consumer_id;
    public function getConsumerId()
    {
        return $this->consumer_id;
    }
    public function setConsumerId($consumer_id): void
    {
        $this->consumer_id = $consumer_id;
    }
    private $driver_id;
    public function getDriverId()
    {
        return $this->driver_id;
    }
    public function setDriverId($driver_id): void
    {
        $this->driver_id = $driver_id;
    }
    private $trip_price;
    public function getTripPrice()
    {
        return $this->trip_price;
    }
    public function setTripPrice($trip_price): void
    {
        $this->trip_price = $trip_price;
    }
    private $payment_method;
    public function getPaymentMethod()
    {
        return $this->payment_method;
    }
    public function setPaymentMethod($payment_method): void
    {
        $this->payment_method = $payment_method;
    }
    private $payment;
    public function getPayment()
    {
        return $this->payment;
    }
    public function setPayment($payment): void
    {
        $this->payment = $payment;
    }
    private $is_completed;
    public function getIsCompleted()
    {
        return $this->is_completed;
    }
    public function setIsCompleted($is_completed): void
    {
        $this->is_completed = $is_completed;
    }
    private $city;
    public function getCity()
    {
        return $this->city;
    }
    public function setCity($city): void
    {
        $this->city = $city;
    }
    private $final_street;
    public function getFinalStreet()
    {
        return $this->final_street;
    }
    public function setFinalStreet($final_street): void
    {
        $this->final_street = $final_street;
    }
    private $final_house;
    public function getFinalHouse()
    {
        return $this->final_house;
    }
    public function setFinalHouse($final_house): void
    {
        $this->final_house = $final_house;
    }
    private $source_house;
    public function getSourceHouse()
    {
        return $this->source_house;
    }
    public function setSourceHouse($source_house): void
    {
        $this->source_house = $source_house;
    }
    private $source_street;
    public function getSourceStreet()
    {
        return $this->source_street;
    }
    public function setSourceStreet($source_street): void
    {
        $this->source_street = $source_street;
    }
    private $waiting_price;
    public function getWaitingPrice()
    {
        return $this->waiting_price;
    }
    public function setWaitingPrice($waiting_price): void
    {
        $this->waiting_price = $waiting_price;
    }

    public function index()
    {
        $sql = "SELECT * FROM admin WHERE token = :token";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
            ':token' => $this->token
        ]);
        $result = $stml->fetch(PDO::FETCH_ASSOC);
        if(empty($result)){
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'invalid token'
            ];
            return json_encode($res);
        }
        $sql = "SELECT * FROM $this->table_name";
        $stml = $this->connection->query($sql);
        $result = fetchAll($stml);
        if(empty($result)){
            http_response_code(404);
            $res = [
              'status' => false,
              'message' => 'orders not found'
            ];
            return json_encode($res);
        }
        return json_encode($result);
    }
    public function read()
    {
        $sql = "SELECT * FROM admin WHERE token = :token";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
            ':token' => $this->token
        ]);
        $result = $stml->fetch(PDO::FETCH_ASSOC);
        if(empty($result)){
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'invalid token'
            ];
            return json_encode($res);
        }

        $sql = "SELECT * FROM $this->table_name WHERE id = :id";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
            ':id' => $this->id
        ]);
        $result = fetch($stml);
        if(empty($result)){
            http_response_code(404);
            $res = [
              'status' => false,
              'message' => 'order not found'
            ];
            return json_encode($res);
        }
        return json_encode($result);
    }
    public function create()
    {
        $sql = "SELECT * FROM admin WHERE token = :token";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
            ':token' => $this->token
        ]);
        $result = $stml->fetch(PDO::FETCH_ASSOC);
        if(empty($result)){
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'invalid token'
            ];
            return json_encode($res);
        }

        $sql = "SELECT * FROM $this->table_consumers WHERE id = :id";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
            ':id' => $this->consumer_id
        ]);
        $result = fetch($stml);
        if(empty($result)){
            http_response_code(404);
            $res = [
                'status' => false,
                'message' => 'consumer not found'
            ];
            return json_encode($res);
        }
        $sql = "SELECT * FROM $this->table_drivers WHERE id = :id";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
            ':id' => $this->driver_id
        ]);
        $result = fetch($stml);
        if(empty($result)){
            http_response_code(404);
            $res = [
                'status' => false,
                'message' => 'driver not found'
            ];
            return json_encode($res);
        }
        $sql = "INSERT INTO $this->table_name (consumer_id,driver_id,trip_price,payment_method,payment,is_completed,waiting_price,source_street,source_house,final_street,final_house,city) VALUES (:consumer_id,:driver_id,:trip_price,:payment_method,:payment,:is_completed,:waiting_price,:source_street,:source_house,:final_street,:final_house,:city)";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
           'consumer_id' => $this->consumer_id,
           'driver_id' => $this->driver_id,
           'trip_price' => $this->trip_price,
           'payment_method' => $this->payment_method,
           'payment' => $this->payment,
           'is_completed' => $this->is_completed,
           'waiting_price' => $this->waiting_price,
           'source_street' => $this->source_street,
            'source_house' => $this->source_house,
            'final_street' => $this->final_street,
            'final_house' => $this->final_house,
            'city' => $this->city,
        ]);
        $result = $this->connection->lastInsertID();
        http_response_code(201);
        $res = [
            'status' => true,
            'message' => "Заказ $result создан"
        ];
        return json_encode($res);
    }
    public function update()
    {
        $sql = "SELECT * FROM admin WHERE token = :token";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
            ':token' => $this->token
        ]);
        $result = $stml->fetch(PDO::FETCH_ASSOC);
        if(empty($result)) {
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'invalid token'
            ];
            return json_encode($res);
        }

        $sql = "SELECT * FROM $this->table_name WHERE id = :id";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
            ':id' => $this->id
        ]);
        $result = fetch($stml);
        if(empty($result)){
            http_response_code(404);
            $res = [
                'status' => false,
                'message' => 'order not found'
            ];
            return json_encode($res);
        }
        $sql = "SELECT * FROM $this->table_consumers WHERE id = :id";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
            ':id' => $this->consumer_id
        ]);
        $result = fetch($stml);
        if(empty($result)){
            http_response_code(404);
            $res = [
                'status' => false,
                'message' => 'consumer not found'
            ];
            return json_encode($res);
        }
        $sql = "SELECT * FROM $this->table_drivers WHERE id = :id";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
            ':id' => $this->driver_id
        ]);
        $result = fetch($stml);
        if(empty($result)){
            http_response_code(404);
            $res = [
                'status' => false,
                'message' => 'driver not found'
            ];
            return json_encode($res);
        }

        $sql = "UPDATE $this->table_name SET consumer_id = :consumer_id, driver_id = :driver_id,
    trip_price = :trip_price, payment_method = :payment_method, payment = :payment, is_completed = :is_completed,
    waiting_price = :waiting_price, source_street = :source_street, source_house = :source_house,
    final_street = :final_street, final_house = :final_house, city = :city WHERE id = :id";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
            ':id' => $this->id,
            'consumer_id' => $this->consumer_id,
            'driver_id' => $this->driver_id,
            'trip_price' => $this->trip_price,
            'payment_method' => $this->payment_method,
            'payment' => $this->payment,
            'is_completed' => $this->is_completed,
            'waiting_price' => $this->waiting_price,
            'source_street' => $this->source_street,
            'source_house' => $this->source_house,
            'final_street' => $this->final_street,
            'final_house' => $this->final_house,
            'city' => $this->city,
        ]);
        $res = [
            'status' => true,
            'message' => "order $this->id updated"
        ];
        return json_encode($res);
    }
    public function delete()
    {
        $sql = "SELECT * FROM admin WHERE token = :token";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
            ':token' => $this->token
        ]);
        $result = $stml->fetch(PDO::FETCH_ASSOC);
        if(empty($result)){
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'invalid token'
            ];
            return json_encode($res);
        }

        $sql = "SELECT * FROM $this->table_name WHERE id = :id";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
           ':id' => $this->id
        ]);
        $result = fetch($stml);
        if(empty($result)){
            http_response_code(404);
            $res = [
                'status' => false,
                'message' => 'order not found'
            ];
            return json_encode($res);
        }
        $sql = "DELETE FROM $this->table_name WHERE id = :id";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
            ':id' => $this->id
        ]);
        $res = [
            'status' => true,
            'message' => "order $this->id deleted"
        ];
        return json_encode($res);
    }
    public function getConsumer()
    {
        $sql = "SELECT * FROM admin WHERE token = :token";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
            ':token' => $this->token
        ]);
        $result = $stml->fetch(PDO::FETCH_ASSOC);
        if(empty($result)){
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'invalid token'
            ];
            return json_encode($res);
        }

        $sql = "SELECT * FROM $this->table_name WHERE id = :id";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
           ':id' => $this->id
        ]);
        $result = fetch($stml);
        if(empty($result)){
            http_response_code(404);
            $res = [
                'status' => false,
                'message' => 'order not found'
            ];
            return json_encode($res);
        }
        ;
        $sql = "SELECT * FROM $this->table_name WHERE consumer_id = :consumer_id";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
            ':consumer_id' => $this->consumer_id
        ]);
        $result = fetch($stml);
        if(empty($result)){
            http_response_code(404);
            $res = [
                'status' => false,
                'message' => 'order witch this consumer not found'
            ];
            return json_encode($res);
        }
        $sql = "SELECT phone,rating,name,count_trips,status FROM orders 
        JOIN consumers ON orders.consumer_id = consumers.id
        WHERE orders.id = :id";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
            ':id' => $this->id
        ]);
        $result = fetch($stml);
        return json_encode($result);
    }
    public function getDriver()
    {
        $sql = "SELECT * FROM admin WHERE token = :token";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
            ':token' => $this->token
        ]);
        $result = $stml->fetch(PDO::FETCH_ASSOC);
        if(empty($result)){
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'invalid token'
            ];
            return json_encode($res);
        }

        $sql = "SELECT * FROM $this->table_name WHERE id = :id";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
            ':id' => $this->id
        ]);
        $result = fetch($stml);
        if(empty($result)){
            http_response_code(404);
            $res = [
                'status' => false,
                'message' => 'order not found'
            ];
            return json_encode($res);
        }
        ;
        $sql = "SELECT * FROM $this->table_name WHERE driver_id = :driver_id";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
            ':driver_id' => $this->driver_id
        ]);
        $result = fetch($stml);
        if(empty($result)){
            http_response_code(404);
            $res = [
                'status' => false,
                'message' => 'order witch this driver not found'
            ];
            return json_encode($res);
        }
        $sql = "SELECT phone,rating,car,name,count_trips,status FROM orders 
        JOIN drivers ON orders.driver_id = drivers.id
        WHERE orders.id = :id";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
            ':id' => $this->id
        ]);
        $driverData = fetch($stml);
        $car = $driverData['car'];
        $sql = "SELECT model,brand FROM car_extended WHERE id = :id";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
            ':id' => $car
        ]);
        $modelAndBrand = fetch($stml);
        $result = [
          'phone' => $driverData['phone'],
          'rating' => $driverData['rating'],
          'model' => $modelAndBrand['model'],
          'brand' => $modelAndBrand['brand'],
          'name' => $driverData['name'],
          'status' => $driverData['status'],
          'count_trips' => $driverData['count_trips'],
        ];
        return json_encode($result);
    }
}