<?php

include_once '../config/core/methods/fetch.php';

class Consumer
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    private $table_name = "consumers";

    private $id;
    private $phone;
    private $rating;
    private $name;
    private $password;

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
    private $count_trips;
    private $status;

    public function index()
    {
        $sql = "SELECT * FROM $this->table_name";
        $stml = $this->connection->query($sql);
        $result = fetchAll($stml);
        if(empty($result)){
            http_response_code(404);
            $res = [
                'status' => false,
                'message' => "Consumers not found"
            ];
            return json_encode($res);
        }
        return json_encode($result);
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
                'message' => 'Consumer not found'
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
           ':phone' => $this->phone
        ]);
        $result = fetch($stml);
        if(!empty($result)){
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'Enter unique phone'
            ];
            return json_encode($res);
        }
        $sql = "INSERT INTO $this->table_name (phone,rating,name,password,count_trips,status) VALUES (:phone,:rating,:name,:password,:count_trips,:status)";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
           ':phone' => $this->phone,
            ':rating' => $this->rating,
            ':name' => $this->name,
            ':password' => $this->password,
            ':count_trips' => $this->count_trips,
            ':status' => $this->status,
        ]);
        $result = $this->connection->lastInsertId();
        http_response_code(201);
        $res = [
            'status' => true,
            'message' => "Пользователь $result добавлен"
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
        $id = fetch($stml);
        if(empty($id)){
            http_response_code(404);
            $res = [
                'status' => false,
                'message' => 'Consumer not found'
            ];
            return json_encode($res);
        }
        $sql = "SELECT * FROM $this->table_name WHERE phone = :phone AND id <> :id";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
            ':phone' => $this->phone,
            ':id' => $this->id
        ]);
        $result = fetch($stml);
        if(!empty($result)){
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'Enter unique phone'
            ];
            return json_encode($res);
        }
        $sql = "UPDATE $this->table_name SET phone = :phone, rating = :rating,name = :name, password = :password, status = :status, count_trips = :count_trips WHERE id = :id";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
            ':phone' => $this->phone,
            ':rating' => $this->rating,
            ':name' => $this->name,
            ':password' => $this->password,
            ':status' => $this->status,
            ':count_trips' => $this->count_trips,
            ':id' => $this->id
        ]);
        $res = [
            'status' => true,
            'message' => "Пользователь $this->id успешно обновлен"
        ];
        return json_encode($res);
    }
    public function delete()
    {
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
                'message' => 'Consumer not found',
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
            'message' => "Пользователь $this->id удален"
        ];
        return json_encode($res);
    }
}