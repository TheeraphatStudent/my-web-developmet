<?php

class Phone
{
    public $id;
    public $model;
    public $cpu;
    public $ram;
    public $camera;
    public $screen;
    public $size;
    public $battery;
    public $image_video;
    public $image;
    public $price;

    public function __construct($id, $model, $cpu, $ram, $camera, $screen, $size, $battery, $image_video, $image, $price)
    {
        $this->id = $id;
        $this->model = $model;
        $this->cpu = $cpu;
        $this->ram = $ram;
        $this->camera = $camera;
        $this->screen = $screen;
        $this->size = $size;
        $this->battery = $battery;
        $this->image_video = $image_video;
        $this->image = $image;
        $this->price = $price;
    }
}
