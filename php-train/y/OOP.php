<?php
// class dongvat { 
//     public $name;
//     public $age;

//     public function __construct ($name = 'con heo' , $age = '10'){
//         $this->name = $name;
//         $this->age = $age;
//     }
//     public function getinfor(){
//         return $this->name . $this->age;
//     }

// }
    require_once('../Animal.php');
    $dv1 = new Animal("con bò", 20);
    $dv2 = new Animal();
    // echo $dv->name; 
    // echo $dv->age; 
// return trả về giá trị, thì fai có echo
    // $dv->getinfor();
    echo $dv2->getinfor();