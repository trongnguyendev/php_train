<?php
class Animal { 
    public $name;
    public $age;

    public function __construct ($name = 'con heo' , $age = '10'){
        $this->name = $name;
        $this->age = $age;
    }
    public function getinfor(){
        return $this->name . $this->age;
    }

}