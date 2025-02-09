<?php

namespace FinalProject\Model;

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
}
