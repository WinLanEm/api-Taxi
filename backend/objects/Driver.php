<?php
class Driver
{
    private $connnection;
    private $table_name = 'drivers';

    private $car_table_name = 'car_extended';

    public $id;
    public $phone;
    public $rating;
    public $car;
    public $name;
    public $password;
    public $status;
    public $count_trips;

    public $model;
    public $brand;

    public function __construct($connection)
    {
        $this->connnection = $connection;
    }
    public function index()
    {
        $sql = "SELECT * FROM $this->table_name";
        $stml = $this->connnection->query($sql);
        $result = $stml->fetchAll(PDO::FETCH_ASSOC);
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
        $stml = $this->connnection->prepare($sql);
        $stml->execute([
           ':id' => $this->id
        ]);
        $result = $stml->fetch(PDO::FETCH_ASSOC);
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
        $stml = $this->connnection->prepare($sql);
        $stml->execute([
           'phone' => $this->phone
        ]);
        $uniquePhone = $stml->fetch(PDO::FETCH_ASSOC);
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
        $stml = $this->connnection->prepare($sql);
        $stml->execute([
           ':model' => $this->model,
           ':brand' => $this->brand,
        ]);
        $car = $stml->fetch(PDO::FETCH_ASSOC);
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
        $sql = "INSERT INTO $this->table_name (phone, rating, car, name, password, status, count_trips) VALUES (:phone,:rating,:car,:name,:password,:status,:count_trips)";
        $stml = $this->connnection->prepare($sql);
        $stml->execute([
            ':phone' => $this->phone,
            ':rating' => $this->rating,
            ':car' => $this->car,
            ':name' => $this->name,
            'password' => $this->password,
            'status' => $this->status,
            'count_trips' => $this->count_trips
        ]);
        $result = $this->connnection->lastInsertId();
        http_response_code(201);
        $res = [
            'status' => true,
            'message' => "Водитель $result успешно создан"
        ];
        return json_encode($res);
    }
    public function update()
    {
        $sql = "SELECT * FROM $this->table_name WHERE id = :id";
        $stml = $this->connnection->prepare($sql);
        $stml->execute([
           ':id' => $this->id
        ]);
        $id = $stml->fetch(PDO::FETCH_ASSOC);
        if(empty($id)){
            http_response_code(404);
            $res = [
                'status' => false,
                'message' => 'Driver not found'
            ];
            return json_encode($res);
        }
        $sql = "SELECT * FROM $this->table_name WHERE phone = :phone AND id <> :id";
        $stml = $this->connnection->prepare($sql);
        $stml->execute([
            ':phone' => $this->phone,
            ':id' => $this->id,
        ]);
        $phone = $stml->fetch(PDO::FETCH_ASSOC);
        if(!empty($phone)){
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'Enter unique phone'
            ];
            return json_encode($res);
        }
        $this->status = 'inactive';
        $sql = "SELECT id FROM $this->car_table_name WHERE model = :model AND brand = :brand";
        $stml = $this->connnection->prepare($sql);
        $stml->execute([
           ':model' => $this->model,
           ':brand' => $this->brand,
        ]);
        $car = $stml->fetch(PDO::FETCH_ASSOC);
        if(empty($car)){
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'Car not found'
            ];
            return json_encode($res);
        }
        $carId = $car['id'];
        $this->car = $carId;
        $sql = "UPDATE $this->table_name SET phone = :phone, rating = :rating, car = :car, name = :name, password = :password, status = :status, count_trips = :count_trips WHERE id = :id";
        $stml = $this->connnection->prepare($sql);
        $stml->execute([
           ':phone' => $this->phone,
            ':rating' => $this->rating,
            ':car' => $this->car,
            ':name' => $this->name,
            ':password' => $this->password,
            ':status' => $this->status,
            ':count_trips' => $this->count_trips,
            ':id' => $this->id
        ]);
        $res = [
            'status' => true,
            'message' => "Водитель $this->id успешно обновлен"
        ];
        return json_encode($res);
    }
    public function delete()
    {
        $sql = "SELECT * FROM $this->table_name WHERE id = :id";
        $stml = $this->connnection->prepare($sql);
        $stml->execute([
           ':id' => $this->id
        ]);
        $id = $stml->fetch(PDO::FETCH_ASSOC);
        if(empty($id)){
            http_response_code(404);
            $res = [
                'status' => false,
                'message' => 'Driver not found'
            ];
            return json_encode($res);
        }
        $sql = "DELETE FROM $this->table_name WHERE id = :id";
        $stml = $this->connnection->prepare($sql);
        $stml->execute([
           ':id' => $this->id
        ]);
        $res = [
            'status' => true,
            'message' => "Пользователь $this->id успешно удален"
        ];
        return json_encode($res);
    }
}