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
        $response = file_get_contents($url);

        return json_decode($response);
    }
}
