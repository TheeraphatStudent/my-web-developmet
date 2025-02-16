<?php
namespace FinalProject\Components;

interface ComponentProps {
    public function render();

}
abstract class Component implements ComponentProps {
    protected $data;

    public function __construct($data = []) {
        $this->data = $data;
    }

    // ใช้สำหรับ Render component ที่สร้าง
    abstract public function render();
}