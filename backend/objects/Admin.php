<?php

include_once '../config/core/methods/fetch.php';
class Admin
{
    private $login;
    private $password;
    private $token;
    private $connection;
    private $table_name = "admin";
    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return mixed
     */

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login): void
    {
        $this->login = $login;
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

    public function createAdmin()
    {
        $sql = "SELECT * FROM $this->table_name WHERE login = :login";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
            ":login" => $this->login,
        ]);
        $result = fetch($stml);
        if(!empty($result)){
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'Enter unique login'
            ];
            return json_encode($res);
        }
        $token = hash("sha256",$this->login) . time();
        $sql = "INSERT INTO $this->table_name (login, password, token) VALUES (:login, :password, :token)";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
           ':login' => $this->login,
           ':password' => $this->password,
            "token" => $token
        ]);
        $result = $this->connection->lastInsertId();
        http_response_code(201);
        $res = [
            'status' => true,
            'message' => "Admin $result created"
        ];
        return json_encode($res);
    }

}