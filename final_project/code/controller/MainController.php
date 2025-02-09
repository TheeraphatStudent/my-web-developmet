<?php

namespace FinalProject\Controller;

use FinalProject\Model\MapModel;

class MainController
{
    private $model;
    private $title = 'Act Gate';

    public function __construct()
    {
        $this->model = new MapModel();
    }

    public function getTitle() {
        return $this->title;

    }

    public function index()
    {
        $mapApiKey = $this->model->getMapApiKey();
        $this->title = "Home / Act Gate";

        require_once('./view/QrReaderView.php');
        require_once('./view/MapView.php');
    }
}
