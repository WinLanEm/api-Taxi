<?php

include_once '../config/core/methods/fetch.php';

class Token
{
    private $connection;

    private $login;
    private $password;

    private $table_name = 'admin';

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
    public function setLogin($login)
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
    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getToken()
    {
        $sql = "SELECT token FROM $this->table_name WHERE login = :login AND password = :password";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
            ":login" => $this->login,
            ":password" => $this->password
        ]);
        $result = fetch($stml);
        if(empty($result)){
            http_response_code(404);
            $res = [
                'status' => false,
                'message' => "Token not found"
            ];
            return json_encode($res);
        }
        return json_encode($result);
    }
}