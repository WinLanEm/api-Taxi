<?php

include_once '../config/core/methods/fetch.php';
class Workload
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    private $table_consumers = "consumers";
    private $table_drivers = "drivers";

    public function index()
    {
        $sql = "SELECT * FROM $this->table_drivers WHERE status = 'active'";
        $stml = $this->connection->query($sql);
        $activeDrivers = fetchAll($stml);
        $countDrivers = count($activeDrivers);
        $sql = "SELECT * FROM $this->table_consumers WHERE status = 'active'";
        $stml = $this->connection->query($sql);
        $activeConsumers = fetchAll($stml);
        $countConsumers = count($activeConsumers);
        $result = [
            'status' => true,
            'consumers' => $countConsumers,
            "drivers" => $countDrivers,
        ];
        return json_encode($result);
    }
}