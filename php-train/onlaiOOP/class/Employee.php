<?php
class Employee {
    public function store($datas){
        if($datas['birthday'] == ''){
            $_SESSION['error_birthday'] = "Chưa Điền Ngày Sinh";
        }
        if($datas['salary'] == ''){
            $_SESSION['error_salary'] = "Chưa Điền Lương";
        }
        if($datas['birthday'] == '' || $datas['salary'] == ''){
            header ("Location:index.php");
        }else {
            $this->writeFile($datas);
        
            header ("Location:list.php");
        }
    }
    public function writeFile($datas){
                $dataStr = $datas['name'] . ',' . $datas['email'] .','. $datas['birthday'] .','.$datas['salary']. "\n";
                $file = fopen("data.txt", "a"); // Mở file để ghi tiếp
                fwrite($file,$dataStr);
                fclose($file);
    }


    public function readFile(){
        $datas = $this->getOneOrMore();
        return $datas;
    // $file = fopen("data.txt", "r");
    // $datas = [];
    // if ($file) {
    //     while (($line = fgets($file)) !== false) { // Đọc từng dòng
    //         $datas [] = explode (',' , $line);
    //     }
    //     fclose($file);
    // } else {
    //     echo "Lỗi: Không thể mở file.";
    // }
    //     return $datas;
    }
   



    public function readFileUp($idUpdate){
        $datas = $this->getOneOrMore($idUpdate);
        return $datas;
        // $file = fopen("data.txt", "r");
        // $id = 1;
        // $datas = [];
        // if ($file) {
        //     while (($line = fgets($file)) !== false) { // Đọc từng dòng
        //         if($idUpdate == $id){
        //             $datas = explode(',' , $line);
        //         }
        //         $id++;
        //     }
        //     fclose($file);
        // } else {
        //     echo "Lỗi: Không thể mở file.";
        // }
        //     return $datas;
    }

    public function getOneOrMore($idUpdate = ''){
        $file = fopen("data.txt", "r");
        $id = 1;
        $datas = [];
        if ($file) {
            while (($line = fgets($file)) !== false) { // Đọc từng dòng
                if($idUpdate !=''){
                    if($idUpdate == $id){
                        $datas = explode(',' , $line);
                    }
                } else{
                    $datas[] = explode (',' , $line);
                }
                $id++;
            }
            fclose($file);
        } else {
            echo "Lỗi: Không thể mở file.";
        }
            return $datas;
    }
    // public function getOneOrMany($idUpdate = '') {
    //     $id = 1;
    //     $file = fopen("dulieu.txt", "r");
    //     $datas = null;

    //     if ($file) {
    //         while (($line = fgets($file)) !== false) { // Đọc từng dòng
    //             if ($idUpdate != '') {
    //                 if($id == $idUpdate){
    //                     $datas = explode(",",$line);
    //                 }
    //             } else { 
    //                 $datas [] = explode(",",$line);
    //             }
    //             $id++;
    //         }
        

    //     fclose($file);
    //     }
    //     else {
    //       echo "Lỗi: Không thể mở file.";
    //     }
    //     return $datas;
    // }



    public function update($idUpdate,$datas){
        $file = fopen("data.txt", "r");
        $id = 1;
        $dataUp = '';
        $updataStr = $datas['name'] . ',' .$datas['email']. ',' .$datas['birthday']. ',' .$datas['salary']."\n";
        if ($file) {
            while (($line = fgets($file)) !== false) { // Đọc từng dòng
               if($idUpdate == $id){
                $dataUp  .= $updataStr;
               }else{
                $dataUp .= $line;
               }
                $id++;
            }
            fclose($file);
        } else {
            echo "Lỗi: Không thể mở file.";
        }
        $this->writeUpdate($dataUp);
        header("Location: list.php");
    }

    public function writeUpdate($dataUp){
        $file = fopen("data.txt", "w+"); // Mở file với chế độ ghi (xóa dữ liệu cũ)
        fwrite($file, $dataUp);
        fclose($file);
    }

    public function readDelete($idUpdate){
        $file = fopen("data.txt", "r");
        $id =1;
        $datas = '';
        if ($file) {
            while (($line = fgets($file)) !== false) { // Đọc từng dòng
                if($idUpdate != $id){
                    $datas .= $line;
                }$id++;
            }
            fclose($file);
        } else {
            echo "Lỗi: Không thể mở file.";
    }
    $this->writeDelete($datas);
    header("Location: list.php");
}
    
    public function writeDelete($datas){
        $file = fopen("data.txt", "w"); // Mở file với chế độ ghi (xóa dữ liệu cũ)
        fwrite($file, $datas);
        fclose($file);
    }
    public function error(){
        session_start();
        $birthday = $_SESSION['error_birthday'] ?? '';
        unset($_SESSION['error_birthday']);
        $salary = $_SESSION['error_salary'] ?? '';
        unset($_SESSION['error_salary']);
    }
}