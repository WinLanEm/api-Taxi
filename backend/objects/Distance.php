<?php

include_once '../config/core/methods/calculatedDistance.php';
class Distance
{
    private $souce_address;
    private $final_address;
    private $city;

    /**
     * @return mixed
     */
    public function getSouceAddress()
    {
        return $this->souce_address;
    }

    /**
     * @param mixed $souce_address
     */
    public function setSouceAddress($souce_address): void
    {
        $this->souce_address = $souce_address;
    }

    /**
     * @return mixed
     */
    public function getFinalAddress()
    {
        return $this->final_address;
    }

    /**
     * @param mixed $final_address
     */
    public function setFinalAddress($final_address): void
    {
        $this->final_address = $final_address;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city): void
    {
        $this->city = $city;
    }
    public function calculateDistance()
    {
        if(!$this->final_address || !$this->souce_address || !$this->city){
            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'Bad request',
            ];
            return json_encode($res);
        }
        $sourceQuery = "$this->city $this->souce_address";

        $sourceQuery = mb_convert_encoding($sourceQuery, 'UTF-8');
        $sourceQuery = urlencode($sourceQuery);
        $finalQuery = "$this->city $this->final_address";
        $finalQuery = mb_convert_encoding($finalQuery, 'UTF-8');
        $finalQuery = urlencode($finalQuery);
        $options = [
            'http' => [
                'header' => "User-Agent: MyApp/1.0 (contact: myemail@example.com)\r\n"
            ]
        ];
        $context = stream_context_create($options);
        $sourceUrl = "https://nominatim.openstreetmap.org/search?q=$sourceQuery&format=json";
        $finalUrl = "https://nominatim.openstreetmap.org/search?q=$finalQuery&format=json";

        $sourceRes = file_get_contents($sourceUrl,false,$context);
        $finalRes = file_get_contents($finalUrl,false,$context);
        $sourceData = json_decode($sourceRes);
        $finalData = json_decode($finalRes);

        $sourceLat = $sourceData[0]->lat;
        $sourceLon = $sourceData[0]->lon;
        $finalLat = $finalData[0]->lat;
        $finalLon = $finalData[0]->lon;

        $distance = calculatedDistance($sourceLat,$sourceLon,$finalLat,$finalLon);
        return json_encode(round($distance,2));
    }
}