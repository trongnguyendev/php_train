<?php
class Car {

    public $color;
    public $nameCar;
    public $madin;

    public function __construct($color ='',$nameCar='',$madin=''){
        $this->color = $color;
        $this->nameCar = $nameCar;
        $this->madin = $madin;
    }
    public function callCar(){
        echo $this->color ." " .$this->nameCar;
    }
}

