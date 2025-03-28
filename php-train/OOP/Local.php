<?php
require_once ('./Car.php');

class add extends Car {
    public $local;

    public function __construct($color ='',$nameCar='',$madin='', $local = ''){
        parent::__construct($color,$nameCar,$madin);
        $this->local = $local;
    }
    public function prover(){
        $info = parent::callCar();
            echo $info ." " .$this->local;
    }
}
 $carpr = new add ('vàng cam', 'Mec','VietNam','GiaLai');
 $carpr->prover();