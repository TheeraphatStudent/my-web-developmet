<?php

namespace FinalProject\Model;

require_once(__DIR__ . '/Environment.php');
use Environment;

class MapModel
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

    public function getMapByLocation($lat, $lng) {
        // https://api.longdo.com/map/services/address?lon=100.53726&lat=13.72427&noelevation=1&key=55072ff6dc986c8484ea0615c17bf149

    }
}
