<?php
class Consumer
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    private $table_name = "consumers";

    public $id;
    public $phone;
    public $rating;
    public $name;
    public $password;
    public $count_trips;
    public $status;

    public function index()
    {
        $sql = "SELECT * FROM $this->table_name";
        $stml = $this->connection->query($sql);
        $result = $stml->fetchAll(PDO::FETCH_ASSOC);
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
        $result = $stml->fetch(PDO::FETCH_ASSOC);
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
        $result = $stml->fetch(PDO::FETCH_ASSOC);
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
        $id = $stml->fetch(PDO::FETCH_ASSOC);
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
        $result = $stml->fetch(PDO::FETCH_ASSOC);
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
        $id = $stml->fetch(PDO::FETCH_ASSOC);
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