<?php

namespace FinalProject\Model;

require_once(__DIR__ . '/Environment.php');

use FinalProject\Model\Environment;

class Map
{
    private $env;

    public function __construct()
    {
        $this->env = new Environment();
    }

    public function getMapApiKey()
    {
        return $this->env->getMapApiKey();
    }

    public function getLocationByLatLon($lat, $lon)
    {
        $url = "https://api.longdo.com/map/services/address?lon=$lon&lat=$lat&noelevation=1&key={$this->getMapApiKey()}";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        // print_r($response);

        return [$response];
    }
}
