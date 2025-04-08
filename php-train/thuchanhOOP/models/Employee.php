<?php
require_once('Basic.php');
class Employee extends Basic {
    protected $fileName = 'employee.txt';
    public $model = 'r';

    public function __construct() {
        $file = $this->fileName;
        // Truyền tên file 'employee.txt' khi khởi tạo đối tượng
        parent::__construct($file);
    }

    public function store($datas){
        $dataEmployee = $this->writeFile($datas);
        return $dataEmployee;
    }
    public function updateFile($id){
        $file = $this->fileName;
        $model = $this->model;
        $dataRead = $this->readFile($id);
        return $dataRead;
    }

    public function deleteEmployee($id){
        $readDelete = $this->delete($id);
        $writeDelete = $this->writeFileDetele($readDelete);
        return $writeDelete;
    }

    public function readFileEmployeeUp($id,$datas){
        $file = $this->fileName;
        $data = $this->readFileUpdate($id,$datas);
        $dataUp = $this->writeFileUpdate($data);
        return $dataUp;
    }

    public function readFileEm(){
        return $this->readFile();
    }

    protected function formatData($data){
        // Tuỳ biến format cho dữ liệu riêng của employee
        $dataStr = $data['name'] . ',' . $data['email'] . ',' . $data['birthday'] . ',' . $data['salary']."\n";
        return $dataStr;
    }
}