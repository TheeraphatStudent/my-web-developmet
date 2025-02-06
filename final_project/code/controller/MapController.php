<?php

namespace FinalProject\Controller;

use FinalProject\Model\MapModel;

class MapController
{
    private $model;

    public function __construct()
    {
        $this->model = new MapModel();
    }

    public function index()
    {
        $mapApiKey = $this->model->getMapApiKey();
        require_once('./view/mapView.php');
    }
}
