<?php

namespace FinalProject\Controller;

use FinalProject\Model\MapModel;

class MainController
{
    private $model;

    public function __construct()
    {
        $this->model = new MapModel();
    }

    public function index()
    {
        $mapApiKey = $this->model->getMapApiKey();

        // require_once('./view/QrReaderView.php');
        // require_once('./view/MapView.php');
        require_once('./view/LandingView.php');
    }
}
