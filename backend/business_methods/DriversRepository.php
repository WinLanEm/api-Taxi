<?php

class DriversRepository
{
    private $connection;
    public function __construct(PDO $connection) {
        $this->connection = $connection;
    }
    public function getAllDrivers()
    {
        $sql = 'SELECT * FROM drivers';
        $stml = $this->connection->query($sql);
        return $stml->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDriverById($id)
    {
        $sql = 'SELECT * FROM drivers WHERE id = :id';
        $stml = $this->connection->prepare($sql);
        $stml->execute([':id' => $id]);
        return $stml->fetch(PDO::FETCH_ASSOC);
    }
    public function createDriver($data)
    {
        if(!isset($data['phone']) || !isset($data['name']) || !isset($data['password']) || !isset($data['model']) || !isset($data['brand'])){
            return 'Неверные данные';
        }
        $phone = $data['phone'];
        $postSql = 'SELECT * FROM drivers WHERE phone = :phone';
        $stml = $this->connection->prepare($postSql);
        $stml->execute([':phone' => $phone]);
        $uniquePhone = $stml->fetch(PDO::FETCH_ASSOC);
        if($uniquePhone){
            return 'Введите уникальный номер телефона';
        }
        $rating = 0;
        $name = $data['name'];
        $password = $data['password'];
        $status = 'inactive';
        $count_trips = 0;
        $model = $data['model'];
        $brand = $data['brand'];

        $sql = 'SELECT pricing_plan,id FROM car_extended WHERE model = :model AND brand = :brand';
        $stml = $this->connection->prepare($sql);
        $stml->execute([
           ':model' => $model,
           ':brand' => $brand,
        ]);
        $idAndPricing = $stml->fetch(PDO::FETCH_ASSOC);
        $id = $idAndPricing['id'];
        $newSQL = 'INSERT INTO drivers (name, phone,password, rating, status, count_trips, car) VALUES (:name, :phone,:password, :rating, :status, :count_trips, :car)';
        $stml = $this->connection->prepare($newSQL);
        $stml->execute([
           ':name' => $name,
            ':phone' => $phone,
            ':password' => $password,
            ':rating' => $rating,
            ':status' => $status,
            ':count_trips' => $count_trips,
            ':car' => $id,
        ]);
        return $this->connection->lastInsertId();
    }
    public function updateDriver($data,$id)
    {
        if(!isset($data['phone']) || !isset($data['name']) || !isset($data['password']) || !isset($data['model']) || !isset($data['brand'])){
            return 'Неверные данные';
        }
        $phone = $data['phone'];
        $postSql = 'SELECT * FROM drivers WHERE phone = :phone';
        $stml = $this->connection->prepare($postSql);
        $stml->execute([':phone' => $phone]);
        $stml->fetch(PDO::FETCH_ASSOC);
        if($stml->rowCount() > 0){
            return 'Введите уникальный номер телефона';
        }
        $rating = 0;
        $name = $data['name'];
        $password = $data['password'];
        $status = 'inactive';
        $count_trips = 0;
        $model = $data['model'];
        $brand = $data['brand'];

        $sql = 'SELECT pricing_plan,id FROM car_extended WHERE model = :model AND brand = :brand';
        $stml = $this->connection->prepare($sql);
        $stml->execute([
            ':model' => $model,
            ':brand' => $brand,
        ]);
        $idAndPricing = $stml->fetch(PDO::FETCH_ASSOC);
        $carId = $idAndPricing['id'];
        $newSQL = 'UPDATE drivers SET phone = :phone, rating = :rating, car = :car, name = :name, password = :password, status = :status, count_trips = :count_trips WHERE id = :id';
        $stml = $this->connection->prepare($newSQL);
        $stml->execute([
            ':id' => $id,
            ':name' => $name,
            ':phone' => $phone,
            ':password' => $password,
            ':rating' => $rating,
            ':status' => $status,
            ':count_trips' => $count_trips,
            ':car' => $carId,
        ]);
        return $id;
    }
    public function deleteDriver($id)
    {
        $sql = 'DELETE FROM drivers WHERE id = :id';
        $stml = $this->connection->prepare($sql);
        $model = $stml->execute([':id' => $id]);
        if ($stml->rowCount() > 0) {
            return $id;
        } else {
            return 'Водитель не найден';
        }
    }
}