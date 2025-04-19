<?php
require_once ('./account.php');

class addMoney extends Bank {
    public $bank;
    public function __construct($onwer = '',$balace = '', $bank = ''){
        parent:: __construct($onwer,$balace);
        $this->bank = $bank;
    }
    public function depositss(){
        echo "Chủ Tài Khoản: ".$this->onwer. " Ngân Hàng: ". $this->bank;
    }
}
    $man = new addMoney('Thanh Ý Phan', 1000000000,'Ngân Hàng Công Thương');
    $man->depositss();