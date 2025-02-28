<?php

namespace FinalProject\Model;

class Environment
{
    private String $mapApiKey;

    public function __construct()
    {
        $this->mapApiKey = '55072ff6dc986c8484ea0615c17bf149';
    }

    public function getMapApiKey(): string
    {
        return $this->mapApiKey;
    }
}
