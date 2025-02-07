<?php

class TokenProxy
{
    private $token;
    private $connection;
    public function __construct($connection)
    {
        $this->connection = $connection;
        $this->token = new Token($connection);
    }



    public function getToken($data)
    {
        if(!$data['login'] || !$data['password']){
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'Bad request',
            ];
            return json_encode($res);
        }
        $this->token->setLogin($data['login']);
        $this->token->setPassword($data['password']);
        return $this->token->getToken();
    }
}