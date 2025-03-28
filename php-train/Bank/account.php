<?php
class Bank {
    protected $onwer;
    protected $balace;

    public function __construct ($onwer = 'thanh ý phan', $balace = '1000000000'){
        $this->onwer = $onwer;
        $this->balace = $balace;
    }
    public function deposit ($amount){
        if($amount > 0 ){
            echo " Số dư sau nạp của ".$this->onwer." là ".$this->balace += $amount;
        }else echo " Số dư hiện tại của ".$this->onwer." là ".$this->balace;
    }
} 
    // $onwerdeposit = new Bank('Thanh Ý Phan',1000000000);
    // $onwerdeposit->deposit(2000);