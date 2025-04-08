<?php

class Employee  {
 
    public function __construct() {
    
    }

    public function getOneOrMany($idUpdate = '') {
        $id = 1;
        $file = fopen("dulieu.txt", "r");
        $datas = null;

        if ($file) {
            while (($line = fgets($file)) !== false) { // Đọc từng dòng
                if ($idUpdate != '') {
                    if($id == $idUpdate){
                        $datas = explode(",",$line);
                    }
                } else { 
                    $datas [] = explode(",",$line);
                }
                $id++;
            }
        

        fclose($file);
        }
        else {
          echo "Lỗi: Không thể mở file.";
        }
        return $datas;
    }

    public function getEmployees() {
        $datas = $this->getOneOrMany();
        return $datas;
        // return $datas;  thì không cần dùng $this->
    }

    public function getEmployee($id) {
        $datas = $this->getOneOrMany($id);
        return $datas;
    }

    public function store($data) {

        $hasProcess = true;
        if($data['birthday'] == ''){
            $_SESSION['errer_brithday'] = "Chưa điền ngày sinh";
        }
        if($data['salary'] == ''){
            $_SESSION['errer_salary'] = "Chưa điền tiền lương";
        }
        if($data['salary'] === '' || $data['salary'] === ''){
            $hasProcess = false;
            header("Location: index.php");
        }
        if($hasProcess){
            // print_r($data);
            $this->writeFile($data);
            
        }

    }

    public function update($id, $data) {
                // session_start();
        // require_once ('./class.php');
        // // $session = new Show_Error;
        // $brithday = $_SESSION['errer_brithday'] ?? '';
        // unset($_SESSION['errer_brithday']);
        // $salary = $_SESSION['errer_salary'] ?? '';
        // unset($_SESSION['errer_salary']);

        $idUpdate = $_GET['index'];
        $id = 1;
        $data = [];
        $file = fopen("dulieu.txt", "r");

        if ($file) {
            while (($line = fgets($file)) !== false) { // Đọc từng dòng
                if($id == $idUpdate){
                    $data = explode(",",$line);
                }
                $id++;
            }
            fclose($file);
        } else {
            echo "Lỗi: Không thể mở file.";
        }
    }

    public function delete($id) {

    }

    public function writeFile($dataparam) {
        $file = fopen("dulieu.txt", "a"); // Mở file để ghi tiếp
        // echo $dataparam['name'];
        // echo $dataparam['email'];
        // echo $dataparam['birthday'];
        // echo $dataparam['salary'];
        $dataStr = $dataparam['name'] . ',' . $dataparam['email'] . ',' . $dataparam['birthday'] . ',' . $dataparam['salary'];
        fwrite($file, $dataStr);
        fclose($file);
        header("Location: show.php");
    }

    public function updateFile() {

    }
    public function readFile($idUpdate){
        $file = fopen("dulieu.txt", "r");
        $id = 1;
        $data = [];
        if ($file) {
            while (($line = fgets($file)) !== false) { // Đọc từng dòng
                if($id == $idUpdate){
                    $data = explode(",",$line);
                }
                $id++;
            }
            fclose($file);
        } else {
            echo "Lỗi: Không thể mở file.";
        
        }
        return $data;
    }

    public function customer($data) {

        $hasProcess = true;
        if($data['birthday'] == ''){
            $_SESSION['errer_brithday'] = "Chưa điền ngày sinh";
        }
        if($data['customer'] == ''){
            $_SESSION['errer_customer'] = "Chưa điền tiền lương";
        }
        if($data['customer'] === '' || $data['customer'] === ''){
            $hasProcess = false;
            header("Location: index.php");
        }
        if($hasProcess){
            // print_r($data);
            $this->writeFileCustomer($data);
            
        }

    }
    public function writeFileCustomer($dataparam) {
        $file = fopen("customer.txt", "a"); // Mở file để ghi tiếp
        $dataStr = $dataparam['name'] . ',' . $dataparam['email'] . ',' . $dataparam['birthday'] . ',' . $dataparam['customer']."\n";
        fwrite($file, $dataStr);
        fclose($file);
        header("Location: list.php");
    }
    public function getCustomer(){
        $file = fopen("customer.txt", "r");
        $datas = [];
        if ($file) {
            while (($line = fgets($file)) !== false) { // Đọc từng dòng
                $datas[]= explode (',' , $line);
            }
            fclose($file);
        } else {
            echo "Lỗi: Không thể mở file.";
        }
        return $datas;
    }

    public function getUpdateCus($idUpdate = '') {
        $id = 1;
        $file = fopen("customer.txt", "r");
        $datas = [];

        if ($file) {
            while (($line = fgets($file)) !== false) { // Đọc từng dòng
                if ($idUpdate != '') {
                    if($id == $idUpdate){
                        $datas = explode(",",$line);
                    }
                }
                $id++;
            }
        

        fclose($file);
        }
        else {
          echo "Lỗi: Không thể mở file.";
        }
        return $datas;
    }

    public function getUpdateCus1($idUpdate = '') {
        $id = 1;
        $file = fopen("customer.txt", "r");
        $datas = [];

        if ($file) {
            while (($line = fgets($file)) !== false) { // Đọc từng dòng
               
                    if($id == $idUpdate){
                        $datas = explode(",",$line);
                    }
                
                $id++;
            }
        

        fclose($file);
        }
        else {
          echo "Lỗi: Không thể mở file.";
        }
        return $datas;
    }

    public function readUpdateCus1($idUpdate,$datas) {
        $id = 1;
        $file = fopen("customer.txt", "r");
        $dataCus = $datas['name'].','.$datas['email'].','.$datas['birthday'].','.$datas['customer'].','.
        $datas = '';
        if ($file) {
            while (($line = fgets($file)) !== false) { // Đọc từng dòng
               
                    if($id == $idUpdate){
                        $datas .= $dataCus;
                    }else{
                        $datas .= $line;
                    }
                
                $id++;
            }
        

        fclose($file);
        }
        else {
          echo "Lỗi: Không thể mở file.";
        }
        $this->writeCus($datas);
        return $datas;
    }

    public $fileName = 'customer.txt';
    // public tên file, viết function mở file truyền vào cách mở, đặt 1 biến dể thức hiện mở file, tiếp tục viết 1 function đọc file thì
    // truyền vòa biến đó biến file , và function vào cái data (data thì thùy vào file như index, updte ) thay đổi cạc đọc file thì dùng $this->openFile ( thay đỏi kiểu trong ngoặc)
    public function openFile($mode = 'r') {
        $file = fopen($this->fileName, $mode);
        return $file;
    }

    public function writeFile1($datas) {
        $file = $this->openFile('a');
        fwrite($file, $datas);
        fclose($file);
    }

    // public function updateEmployee() {
    //     $datas = [...];

    //     $this->writeFile1($datas);
    // }

    // public function deleteData1($id, $datas) {
    //     $file = $this->openFile('w+');


    // }

    // public function deleteData($id) {

    // }

    // public function writeCus($datas){
    //     // $file = fopen("customer.txt", "w+"); // Mở file với chế độ ghi (xóa dữ liệu cũ)
    //     // fwrite($file, $datas);
    //     // fclose($file);

    //     $this->writeFile1($datas, "a");
    //         // Hiệu quả khi đọc file lớn vì đọc từng dòng.

    //     header("Location: list.php");
    // }

    public function readDeleteCus($idUpdate = '') {
        $id = 1;
        $file = fopen("customer.txt", "r");
        $datas = '';

        if ($file) {
            while (($line = fgets($file)) !== false) { // Đọc từng dòng
                    if($id != $idUpdate){
                        $datas .= $line;
                    }
                $id++;
            }
        fclose($file);
        }
        else {
          echo "Lỗi: Không thể mở file.";
        }
        $this->writeFileDelete($datas);
        return $datas;
    }
    public function writeFileDelete($datas) {
        $file = fopen("customer.txt", "w+"); // Mở file để ghi tiếp
        fwrite($file, $datas);
        fclose($file);
        header("Location: list.php");
    }


}