<?php

class ConsumersRepository
{
    private $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getAllConsumers()
    {
        $sql = 'SELECT * FROM consumers';
        $stml = $this->connection->query($sql);
        return $stml->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getConsumerById($id)
    {
        $sql = 'SELECT * FROM consumers WHERE id = :id';
        $stml = $this->connection->prepare($sql);
        $stml->execute([':id' => $id]);
        return $stml->fetch(PDO::FETCH_ASSOC);
    }
}