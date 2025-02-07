<?php

include_once '../config/core/methods/fetch.php';

class Driver
{
    private $connection;
    private $table_name = 'drivers';

    private $car_table_name = 'car_extended';

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
    private $location;

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location): void
    {
        $this->location = $location;
    }

    private $id;
    private $phone;
    private $rating;
    private $car;
    private $name;
    private $password;
    private $status;
    private $count_trips;

    private $model;

    /**
     * @return mixed
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param mixed $brand
     */
    public function setBrand($brand): void
    {
        $this->brand = $brand;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param mixed $model
     */
    public function setModel($model): void
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function getCountTrips()
    {
        return $this->count_trips;
    }

    /**
     * @param mixed $count_trips
     */
    public function setCountTrips($count_trips): void
    {
        $this->count_trips = $count_trips;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getCar()
    {
        return $this->car;
    }

    /**
     * @param mixed $car
     */
    public function setCar($car): void
    {
        $this->car = $car;
    }

    /**
     * @return mixed
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param mixed $rating
     */
    public function setRating($rating): void
    {
        $this->rating = $rating;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }
    private $brand;

    public function __construct($connection)
    {
        $this->connection = $connection;
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
            $res = [
                'status' => false,
                'message' => 'Drivers not found'
            ];
            http_response_code(404);
            return json_encode($res);
        }else{
            return json_encode($result);
        }
    }
    public function show()
    {
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
                'message' => 'Driver not found'
            ];
            return json_encode($res);
        }
        return json_encode($result);
    }
    public function create()
    {
        $sql = "SELECT * FROM $this->table_name WHERE phone = :phone";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
           'phone' => $this->phone
        ]);
        $uniquePhone = fetch($stml);
        if(!empty($uniquePhone)){
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'Enter unique phone'
            ];
            return json_encode($res);
        }
        $this->rating = 0;
        $this->count_trips = 0;
        $this->status = 'inactive';
        $sql = "SELECT id FROM $this->car_table_name WHERE model = :model AND brand = :brand";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
           ':model' => $this->model,
           ':brand' => $this->brand,
        ]);
        $car = fetch($stml);
        if(empty($car)){
            http_response_code(404);
            $res = [
                'status' => false,
                'message' => 'This car not found'
            ];
            return json_encode($res);
        }
        $carId = $car['id'];
        $this->car = $carId;
        $hashPassword = password_hash($this->password,PASSWORD_DEFAULT);
        $sql = "INSERT INTO $this->table_name (phone, rating, car, name, password, status, count_trips) VALUES (:phone,:rating,:car,:name,:password,:status,:count_trips)";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
            ':phone' => $this->phone,
            ':rating' => $this->rating,
            ':car' => $this->car,
            ':name' => $this->name,
            'password' => $hashPassword,
            'status' => $this->status,
            'count_trips' => $this->count_trips
        ]);
        $result = $this->connection->lastInsertId();
        http_response_code(201);
        $res = [
            'status' => true,
            'message' => "Driver $result created"
        ];
        return json_encode($res);
    }
    public function update()
    {
        $sql = "SELECT * FROM $this->table_name WHERE id = :id";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
           ':id' => $this->id
        ]);
        $driver = fetch($stml);
        if(empty($driver)){
            http_response_code(404);
            $res = [
                'status' => false,
                'message' => 'Driver not found'
            ];
            return json_encode($res);
        }
        $sql = "UPDATE $this->table_name SET location = :location, phone = :phone, rating = :rating, car = :car, name = :name, password = :password, status = :status, count_trips = :count_trips WHERE id = :id";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
           ':phone' => $driver['phone'],
            ':rating' => $driver['rating'],
            ':car' => $driver['car'],
            ':name' => $driver['name'],
            ':password' => $driver['password'],
            ':status' => $driver['status'],
            ':count_trips' => $driver['count_trips'],
            ':id' => $driver['id'],
            ':location' => $this->location
        ]);
        $res = [
            'status' => true,
            'message' => "Driver $this->id updated"
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
        $id = fetch($stml);
        if(empty($id)){
            http_response_code(404);
            $res = [
                'status' => false,
                'message' => 'Driver not found'
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
            'message' => "Driver $this->id deleted"
        ];
        return json_encode($res);
    }
    public function driverLogin()
    {
        $sql = "SELECT * FROM $this->table_name WHERE phone = :phone";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
           ':phone' => $this->phone
        ]);
        $user = fetch($stml);
        if(empty($user)){
            http_response_code(404);
            $res = [
                'status' => false,
                'message' => 'Driver with this phone not found'
            ];
            return json_encode($res);
        }
        if(!password_verify($this->password,$user['password'])){
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'invalid password'
            ];
            return json_encode($res);
        }
        $_SESSION['driver']['id'] = $user['id'];
        // позже переписать на запись не в сессию, а в jwt токен
        $res = [
            'status' => true,
            'message' => 'success'
        ];
        return json_encode($res);
    }
    public function statusChange()
    {
        $sql = "SELECT * FROM $this->table_name WHERE id = :id";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
            ':id' => $this->id
        ]);
        $driver = fetch($stml);
        if(empty($driver)){
            http_response_code(404);
            $res = [
                'status' => false,
                'message' => 'Driver not found'
            ];
            return json_encode($res);
        }
        $sql = "UPDATE $this->table_name SET location = :location, phone = :phone, rating = :rating, car = :car, name = :name, 
                 password = :password, status = :status, count_trips = :count_trips WHERE id = :id";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
            ':phone' => $driver['phone'],
            ':rating' => $driver['rating'],
            ':car' => $driver['car'],
            ':name' => $driver['name'],
            ':password' => $driver['password'],
            ':status' => $this->status,
            ':count_trips' => $driver['count_trips'],
            ':id' => $driver['id'],
            ':location' => $driver['location']
        ]);
        $res = [
            'status' => true,
            'message' => $this->status,
        ];
        return json_encode($res);
    }
    public function getOrder()
    {
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
                'message' => 'Driver not found'
            ];
            return json_encode($res);
        }
        $orderId = $result['order_id'];
        $sql = "SELECT * FROM orders WHERE id = :order_id";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
           ':order_id' => $orderId
        ]);
        $orderData = fetch($stml);
        $sql = "UPDATE orders SET consumer_id = :consumer_id, driver_id = :driver_id, trip_price = :trip_price,
                  payment_method = :payment_method
                  ,payment = :payment,is_completed = :is_completed,
                   waiting_price = :waiting_price,source_address = :source_address,final_address = :final_address
                ,city = :city,status = :status WHERE id = :order_id";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
            'order_id' => $orderData['id'],
            'consumer_id' => $orderData['consumer_id'],
            'driver_id' => $this->id,
            'trip_price' => $orderData['trip_price'],
            'payment_method' => $orderData['payment_method'],
            'payment' => 'false',
            'is_completed' => 'false',
            'waiting_price' => $orderData['waiting_price'],
            'source_address' => $orderData['source_address'],
            'final_address' => $orderData['final_address'],
            'city' => $orderData['city'],
            'status' => 'active',
        ]);
        return json_encode($orderData);
    }
    public function cancelOrder()
    {

        $sql = 'SELECT * FROM orders WHERE driver_id = :driver_id AND status = :status';
        $stml = $this->connection->prepare($sql);
        $stml->execute([
           ':driver_id' => $this->id,
           ':status' => 'active',
        ]);
        $result = fetch($stml);
        $sql = "UPDATE orders SET consumer_id = :consumer_id, driver_id = :driver_id, trip_price = :trip_price,
                  payment_method = :payment_method
                  ,payment = :payment,is_completed = :is_completed,
                   waiting_price = :waiting_price,source_address = :source_address,final_address = :final_address
                ,city = :city,status = :status WHERE id = :order_id";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
            'order_id' => $result['id'],
            'consumer_id' => $result['consumer_id'],
            'driver_id' => null,
            'trip_price' => $result['trip_price'],
            'payment_method' => $result['payment_method'],
            'payment' => 'false',
            'is_completed' => 'false',
            'waiting_price' => $result['waiting_price'],
            'source_address' => $result['source_address'],
            'final_address' => $result['final_address'],
            'city' => $result['city'],
            'status' => 'active',
        ]);
        $sql = "SELECT * FROM $this->table_name WHERE id = :id";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
            ':id' => $this->id
        ]);
        $driver = fetch($stml);
        if(empty($driver)){
            http_response_code(404);
            $res = [
                'status' => false,
                'message' => 'Driver not found'
            ];
            return json_encode($res);
        }
        return json_encode($driver);
        $sql = "SELECT * FROM $this->table_name WHERE id = :id";
        $stml = $this->connection->prepare($sql);
        $stml->execite([
           ':id' => $result['driver_id']
        ]);
        $res = [
            'status' => true,
            'message' => 'order canceled'
        ];
        $sql = "UPDATE $this->table_name SET location = :location, phone = :phone, rating = :rating, car = :car, name = :name, 
                 password = :password, status = :status, count_trips = :count_trips, order_id = :order_id WHERE id = :id";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
            ':phone' => $driver['phone'],
            ':rating' => $driver['rating'],
            ':car' => $driver['car'],
            ':name' => $driver['name'],
            ':password' => $driver['password'],
            ':status' => $driver['status'],
            ':count_trips' => $driver['count_trips'],
            ':id' => $driver['id'],
            ':location' => $driver['location'],
            ':order_id' => null,
        ]);
        return json_encode($res);
    }
}