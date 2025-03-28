<?php

require_once ('../Animal.php');

// class Cat extends Animal {
//     public $favorite;
//     public function __construct ($name = 'con heo' , $age = '10', $favorite = ''){
//         parent::__construct ($name, $age);
//         // xét giá trị
    
//         $this->favorite = $favorite;
//     }
// // cập nhập giá trị favorite 
//     public function set($favorite) {
//         $this->favorite = $favorite;
//     }
//     public function get(){
//         echo parent:: getinfor();
//        echo $this->favorite;
//     }
// }
//     // $Cat = new Cat();
// // echo $Cat->name;

// // echo $Cat->getinfor();
// $Cat = new Cat();

// $Cat->set('ăn cá1');
// echo $Cat->get();


// lamlai
// hiển thị name, age , favorite
class Cat extends Animal {
    public $favorite;
    public function __construct ($name = '1' , $age = '2', $favorite = '3'){
        parent::__construct ( $name, $age);
        $this->favorite = $favorite;
    }
    public function favorite($favorite){
        $this->favorite = $favorite;
    }
    public function showCat(){
        $info = parent::getinfor();
        return $info . $this->favorite;
    }
}
    // $Cat = new Cat('Con Mèo', 5 , 'ăn cá');
    // echo $Cat->showCat();
    $Cat = new Cat();
    $Cat->favorite ('ăn cơm');
    echo $Cat->showCat();
   
