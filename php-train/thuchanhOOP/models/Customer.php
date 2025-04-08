<?php
require_once('Basic.php');
class Customer extends Basic {
    protected $fileName = 'customer.txt';

    public function __construct() {
        $file = $this->fileName;
        // Truyền tên file 'employee.txt' khi khởi tạo đối tượng
        parent::__construct($file);
    }

    public function store($datas){
        // $dataStr = $datas['name'] . ',' . $datas['email'] . ',' . $datas['birthday'] . ',' . $datas['address']. '.' . $datas['typecustomer']."\n";
        // Cái này có thể thay đổi thành 
        $dataEmployee = $this->writeFile($datas);
        return $dataEmployee;
    }
    protected function formatData($data){
        // Tuỳ biến format cho dữ liệu riêng của employee
        $dataStr = $data['name'] . ',' . $data['email'] . ',' . $data['birthday'] . ',' . $data['address']. ',' . $data['typecustomer']."\n";
        return $dataStr;
    }

    public function readFileList(){
        $datas = $this->readFile();
        return $datas;
    }

    public function readFileUpdateCustomer($id){
        $datas = $this->readFile($id);
        return $datas;
    }

    public function updateFile($id,$datas){
        $upFile = $this->readFileUpdate($id,$datas);
        $writeUpFile = $this->writeFileUpdate($upFile);
        return $writeUpFile;
    }

    public function deleteCustomer($id){
        $readDelete = $this->delete($id);
        $writeDelete = $this->writeFileDetele($readDelete);
        return $writeDelete;
    }
}