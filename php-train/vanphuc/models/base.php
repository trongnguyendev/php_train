<?php
class Base {
    /**
     * Đường dẫn tới file dữ liệu
     */
    public $filePath = '';
    public $rules = '';
    public $columnMap = [];

    /**
     * Xác thực dữ liệu đầu vào theo quy tắc
     */

    protected function validate(array $data): array
    {
        $errors = [];

        foreach ($this->rules as $field => $rule) {
            if(isset($data[$field])){
                $_SESSION['old_input'][$field] = $data[$field];

                if(strpos($rule, 'required') !== false && empty($data[$field])){
                    $errors["error_{$field}"] = "{$field} là bắt buộc.";
                }
            }else {
                if(strpos($rule, 'required') !== false) {
                    $errors["error_{$field}"] = "{$field} là bắt buộc.";
                }
            }
        }
        // lưu lỗi vào session
        if(!empty($errors)){
            $_SESSION['errors'] = $errors;
        }else {
            $_SESSION['errors'] = [];
        }
        return $errors;
    }
    /**
     * Mở file với chế độ đọc/ghi
     */
    protected function openFile(string $mode)
    {
        try{
            $file = fopen($this->filePath, $mode);
            if(!$file){
                throw new RuntimeException("Không thể mở file: {$this->filePath}");
            }
            return $file;

        }catch (Exception $e){
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }
    /**
     * Ghi một dòng dữ liệu vào file
     */
    protected function writeFile(array $line, $mode = 'a'): bool{
        $file = $this->openFile($mode);
        if(!$file) return false;

        $values = array_map(fn($field) => $line[$field] ?? '', $this->fields);
        fwrite($file, implode(',', $values) . PHP_EOL);
        fclose($file);
        return true;
    }

    /**
     * Lấy tất cả dữ liệu từ file
     */
    public function all():array {
        return $this->readFile();
    }

    /**
     * Đọc dữ liệu fila và trả về mảng
     */

     protected function readFile(string $mode = 'r'):array
     {
        $file = $this->openFile($mode);
        if(!$file) return [];

        $lines = [];
        while (($line = fgets($file)) !== false){
            $lines[] = explode(",", $line);
        }
        fclose($file);
        return $lines;
     }

     /**
      * Lưu một dòng dữ liệu vào file
      */
      public function store ($data){
        $errors = $this->validate($data);
        if(!empty($errors)) return false;
        return $this->writeFile($data);
      }
      /**
       * Tìm một dòng dữ liệu theo chỉ số
       */
      public function findRowByIndex($indexData)
      {
        $file = $this->openFile('r');
        if(!$file) return [];

        $index = 1;
        $result = [];
        while (($line = fgets($file)) !== false){
            if($indexData == $index){
                $result  = explode(",", $line);
                break;
            }
            $index++;
        }
        fclose($file);
        return $result;
    }

    /**
     * Update dòng cần chỉnh sửa
     */

     public function update(int $targetLine, $newData):bool
     {
        $errors = $this->validate($newData);
        if(!empty($errors)) return false;
        $file = $this->openFile('r');
        if(!$file) return false;

        $updatedContent = '';
        $lineNumber = 1;

        if($file){
            while(($line = fgets($file)) !== false){
                if($lineNumber === $targetLine){
                    $values = array_map(fn($field) => $newData[$field] ?? '',$this->fields);
                    $updatedContent .= implode(',', $values) .PHP_EOL;
                }else {
                    $updatedContent .= $line;
                }             
                $lineNumber++;

            }
            fclose($file);
        }
        $file = fopen($this->filePath, "w+");
        if(!$file) return false;
        fwrite($file, $updatedContent);
        fclose($file);

        return true;
     } 

     /**
      * Xóa dữ liệu theo ID dòng
      */
    public function delete(int $targetLine):bool 
    {
        $file = $this->openFile('r');
        if(!$file) return false;

        $changeContent = '';
        $lineNumber = 1;

        if($file){
            while(($line = fgets($file)) !== false){
                if($lineNumber !== $targetLine){
                    $changeContent .= $line;
                }
                $lineNumber++;
            }
            fclose($file);
        }
        $file = fopen($this->filePath, "w+");
        if(!$file) return false;

        fwrite($file, $changeContent);
        fclose($file);

        return true;

    }

    /**
     * Tìm một dòng dữ liệu theo chỉ số.
     *
     * @param int $indexData Chỉ số dòng cần tìm.
     * @return array Mảng chứa dữ liệu của dòng đó hoặc mảng rỗng nếu không tìm thấy.
     */
    public function findRowByType($searchContent, $searchType)
    {
        if (!$file = $this->openFile('r')) {
            return [];
        }
        

        $_SESSION['old_search'] = [
            'search_content' => $searchContent,
            'search_type' => $searchType,
        ];


        if (!isset($this->columnMap[$searchType])) {
            fclose($file);
            return [];
        }
        // tách từ khóa tìm kiếm bằng dấu phẩy
        $searchItems = array_map('trim', explode(',', $searchContent));
        //  loại cột mà tìm kiếm
        $columnIndex = $this->columnMap[$searchType];
        //  biến để chứa mảng
        $result = [];

        while (($line = fgets($file)) !== false) {
            // tách từng mảng dữ liệu bằng dấu phẩy
            $row = array_map('trim', explode(',', $line));
            // Lấy giá trị ở cột mà đang tìm kiếm
            $valueToCheck = $row[$columnIndex] ?? '';
            foreach ($searchItems as $item) {

                // kiểm tra lỗi
                // echo str_replace(' ','',strtolower($valueToCheck));
                // echo strtolower($valueToCheck);
                // echo str_replace(' ','',strtolower($item));
                // echo $this->vn_to_str($valueToCheck);
                if (str_contains($this->vn_to_str($valueToCheck), $this->vn_to_str($item))) {
                    // check giá trị valueToCheck để coi trùng thì lưu không thì thôi,
                    $result[] = $row;
                    break;
                }
            }
        }

        fclose($file);
        return $result;
    }
        // function bỏ dấu để thực hiện tìm giá trị gần đúng ví dụ Thanh Ý mà search thanh y

    function vn_to_str ($str){
        
        $unicode = array(
        
        'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
        
        'd'=>'đ',
        
        'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
        
        'i'=>'í|ì|ỉ|ĩ|ị',
        
        'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
        
        'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
        
        'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
        
        'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
        
        'D'=>'Đ',
        
        'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
        
        'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
        
        'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
        
        'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
        
        'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        
        );
        
        foreach($unicode as $nonUnicode=>$uni){
        
        $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        
        }
        $str = str_replace(' ','',$str);

        $str = mb_strtolower($str, 'UTF-8');
        
        return $str;
 
    }
}
