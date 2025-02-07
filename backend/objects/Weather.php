<?php

class Weather
{
    private $city;
    private $key;

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

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param mixed $key
     */
    public function setKey($key): void
    {
        $this->key = $key;
    }
    public function getWeather()
    {
        $url = "http://api.weatherapi.com/v1/current.json?key={$this->key}&q={$this->city}";
        $response =  file_get_contents($url);
        if(!$response){
            http_response_code(500);
            $res = [
                'status' => false,
                'message' => 'Internal Server Error'
            ];
            return json_encode($res);
        }
        $data = json_decode($response,true);
        $currentData = $data['current'];
        $temp = $currentData['temp_c'];
        $wind = $currentData['wind_kph'];
        $precip_mm = $currentData['precip_mm'];

        if($temp < 0){
            $newTemp = (str_replace("-", '', $temp));
            $coldTemp = (int)($newTemp);
            if($coldTemp > 5 && $precip_mm > 10){
                $result = ['status' => true ,'weather' => 'snowy'];
                return json_encode($result);
            }elseif ($coldTemp > 10 && $wind > 13 && $precip_mm < 2){
                $result = ['status' => true ,'weather' => 'cold'];;
                return json_encode($result);
            }
        }
        if($precip_mm > 8 && $temp > 0){
            $result = ['status' => true ,'weather' => 'rainy'];;
            return json_encode($result);
        } else{
            $result = ['status' => true ,'weather' => 'warm'];;
            return json_encode($result);
        }
    }
}