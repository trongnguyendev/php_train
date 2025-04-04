<?php

class Employee {
 
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

}