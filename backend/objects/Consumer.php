<?php

include_once '../config/core/methods/fetch.php';

class Consumer
{
    private $connection;
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
        $hashPassword = password_hash($this->password,PASSWORD_DEFAULT);
        $sql = "INSERT INTO $this->table_name (phone,rating,name,password,count_trips,status) VALUES (:phone,:rating,:name,:password,:count_trips,:status)";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
           ':phone' => $this->phone,
            ':rating' => $this->rating,
            ':name' => $this->name,
            ':password' => $hashPassword,
            ':count_trips' => $this->count_trips,
            ':status' => $this->status,
        ]);
        $result = $this->connection->lastInsertId();
        http_response_code(201);
        $res = [
            'status' => true,
            'message' => "Consumer $result created"
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
        $hashPassword = password_hash($this->password,PASSWORD_DEFAULT);
        $sql = "UPDATE $this->table_name SET phone = :phone, rating = :rating,name = :name, password = :password, status = :status, count_trips = :count_trips WHERE id = :id";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
            ':phone' => $this->phone,
            ':rating' => $this->rating,
            ':name' => $this->name,
            ':password' => $hashPassword,
            ':status' => $this->status,
            ':count_trips' => $this->count_trips,
            ':id' => $this->id
        ]);
        $res = [
            'status' => true,
            'message' => "Consumer $this->id updated"
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
            'message' => "Consumer $this->id deleted"
        ];
        return json_encode($res);
    }
    public function consumerLogin()
    {
        session_start();
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
                'message' => 'Consumer with this phone not found'
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
        $_SESSION['consumer']['id'] = $user['id'];
        // позже переписать на запись не в сессию, а в jwt токен
        $res = [
            'status' => true,
            'message' => 'success',
            'session' => 'Session name: ' . session_name(),
        ];
        return json_encode($res);
    }
    public function checkRole()
    {
        return json_encode($_SESSION);
    }
}