<?php

include_once '../config/core/methods/fetch.php';
include_once 'Distance.php';

class SearchDrivers
{
    private $order_table = 'orders';
    private $driver_table = 'drivers';
    private $connection;
    private $orderId;
    private $sourceAddress;
    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->orderId;
    }/**
     * @param mixed $orderId
     */
    public function setOrderId($orderId): void
    {
        $this->orderId = $orderId;
    }/**
     * @return mixed
     */
    public function getSourceAddress()
    {
        return $this->sourceAddress;
    }/**
     * @param mixed $sourceAddress
     */
    public function setSourceAddress($sourceAddress): void
    {
        $this->sourceAddress = $sourceAddress;
    }
    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function searchDrivers()
    {
        $sql = "SELECT * FROM $this->driver_table WHERE status = :status";
        $stml = $this->connection->prepare($sql);
        $stml->execute([
           ':status' => 'active'
        ]);

        $drivers = fetchAll($stml);
        $results = [];
        if (empty($drivers)) {
            return json_encode([
                'status' => false,
                'message' => 'No drivers available'
            ]);
        }

        foreach ($drivers as $driver) {
            $distance = new Distance();
            $parts = explode(', ', $driver['location']);
            if (count($parts) < 3) {
                continue;
            }
            $city = $parts[0];
            $address = $parts[1] . ', ' . $parts[2];
            $distance->setCity($city);
            $distance->setFinalAddress($address);
            $distance->setSouceAddress($this->sourceAddress);
            $result = $distance->calculateDistance();
            if ($result < 1) {
                $sql = "UPDATE $this->driver_table SET location = :location, phone = :phone, rating = :rating, car = :car,
               name = :name, password = :password, status = :status, count_trips = :count_trips, order_id = :order_id WHERE id = :id";
                $stmt = $this->connection->prepare($sql);
                $stmt->execute([
                    ':phone' => $driver['phone'],
                    ':rating' => $driver['rating'],
                    ':car' => $driver['car'],
                    ':name' => $driver['name'],
                    ':password' => $driver['password'],
                    ':status' => $driver['status'],
                    ':count_trips' => $driver['count_trips'],
                    ':id' => $driver['id'],
                    ':location' => $driver['location'],
                    ':order_id' => (int)$this->orderId,
                ]);
                $results[] = [
                    'status' => true,
                    'message' => $driver,
                    'distance' => $result
                ];
                return json_encode($results);
            } else if($result < 5){
                $sql = "UPDATE $this->driver_table SET location = :location, phone = :phone, rating = :rating, car = :car,
               name = :name, password = :password, status = :status, count_trips = :count_trips, order_id = :order_id WHERE id = :id";
                $stmt = $this->connection->prepare($sql);
                $stmt->execute([
                    ':phone' => $driver['phone'],
                    ':rating' => $driver['rating'],
                    ':car' => $driver['car'],
                    ':name' => $driver['name'],
                    ':password' => $driver['password'],
                    ':status' => $driver['status'],
                    ':count_trips' => $driver['count_trips'],
                    ':id' => $driver['id'],
                    ':location' => $driver['location'],
                    ':order_id' => (int)$this->orderId,
                ]);
                $results[] = [
                    'status' => true,
                    'message' => $driver,
                    'distance' => $result,
                ];
                return json_encode($results);
            }else if($result < 15){
                $sql = "UPDATE $this->driver_table SET location = :location, phone = :phone, rating = :rating, car = :car,
               name = :name, password = :password, status = :status, count_trips = :count_trips, order_id = :order_id WHERE id = :id";
                $stmt = $this->connection->prepare($sql);
                $stmt->execute([
                    ':phone' => $driver['phone'],
                    ':rating' => $driver['rating'],
                    ':car' => $driver['car'],
                    ':name' => $driver['name'],
                    ':password' => $driver['password'],
                    ':status' => $driver['status'],
                    ':count_trips' => $driver['count_trips'],
                    ':id' => $driver['id'],
                    ':location' => $driver['location'],
                    ':order_id' => (int)$this->orderId,
                ]);
                $results[] = [
                    'status' => true,
                    'message' => $driver,
                    'distance' => $result
                ];
                return json_encode($results);
            }else{
                $res = [
                    'status' => false,
                    'message' => 'driver not found',
                ];
                return json_encode($res);
            }
        }
        return 111;
    }
}