<?php

class Basic {
    protected $fileName;
    public function __construct($fileName){
        $this->fileName = $fileName;
    }
    public function readFile($id = ''){
        $file = fopen($this->fileName, "r");
        $idUpdate = 1;
        $datas = []; 
        if ($file) {
            while (($line = fgets($file)) !== false) { // Đọc từng dòng 
                if($id!=''){
                    if($id == $idUpdate){
                        $datas = explode(',' ,$line);
                    }
                    $idUpdate++;
                }else{
                $datas[] = explode(',' , $line);
                }
            }
            fclose($file);
        } else {
            echo "Lỗi: Không thể mở file.";
        }
        return $datas;
    }
    public function writeFile($datas){
        $dataStr = $this->formatData($datas);
        // $dataStr = $datas['name'] . ',' . $datas['email'] . ',' . $datas['birthday'] . ',' . $datas['salary']."\n";
        $file = fopen($this->fileName, "a"); // Mở file để ghi tiếp
        $this->write($file,$dataStr);
    }

    public function readFileUpdate($id,$data){
        $file = fopen($this->fileName, "r");
        // Mới định nghĩa lại hàm chưa test, nhớ test nha vì khuya quá 
        // đã test, Ok;
        $dataStr = $this->formatData($data);
        // $dataStr = $data['name'].','.$data['email'].','.$data['birthday'].','.$data['salary'];
        $idUpdate =1;
        $datas = ''; 
        if ($file) {
            while (($line = fgets($file)) !== false) { // Đọc từng dòng
                if($id == $idUpdate){
                    $datas .= $dataStr;
                }else{
                    $datas .= $line;
                }$idUpdate++;
            }
        fclose($file);
        }else {
            echo "Lỗi: Không thể mở file.";
        }
        return $datas;
    }
    public function writeFileUpdate($datas){
        // $dataStr = $datas['name'] . ',' . $datas['email'] . ',' . $datas['birthday'] . ',' . $datas['salary'];
        $file = fopen($this->fileName, "w+"); // Mở file để ghi tiếp
        $this->write($file, $datas);
    }

    public function delete($id){
        $file = fopen($this->fileName, "r");
        $idUpdate = 1;
        $datas = ''; 
        if ($file) {
            while (($line = fgets($file)) !== false) { // Đọc từng dòng
                    if($id != $idUpdate){
                        $datas .= $line;
                    }$idUpdate++;
            }
            fclose($file);
        } else {
            echo "Lỗi: Không thể mở file.";
        }
        return $datas;
    }

    public function writeFileDetele($datas){
        $file = fopen($this->fileName, "w"); // Mở file để ghi tiếp
        $this->write($file,$datas);
    }

    public function write($file,$datas){
        fwrite($file,$datas);
        fclose($file);
    }
}