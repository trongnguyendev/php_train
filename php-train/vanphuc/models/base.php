<?php
class Base {
    /**
     * Đường dẫn tới file dữ liệu
     */
    public $filePath = '';
    public $rules = '';

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

        $columnMap = [
            'name' => 0,
            'age' => 1,
            'email' => 2,
            'phone' => 3,
        ];

        if (!isset($columnMap[$searchType])) {
            fclose($file);
            return [];
        }
        // tách từ khóa tìm kiếm bằng dấu phẩy
        $searchItems = array_map('trim', explode(',', $searchContent));
        //  loại cột mà tìm kiếm
        $columnIndex = $columnMap[$searchType];
        //  biến để chứa mảng
        $result = [];

        while (($line = fgets($file)) !== false) {
            // tách từng mảng dữ liệu bằng dấu phẩy
            $row = array_map('trim', explode(',', $line));
            // Lấy giá trị ở cột mà đang tìm kiếm
            $valueToCheck = $row[$columnIndex] ?? '';

            foreach ($searchItems as $item) {
                if (str_contains($valueToCheck, $item)) {
                    // check giá trị valueToCheck để coi trùng thì lưu không thì thôi,
                    $result[] = $row;
                    break;
                }
            }
        }

        fclose($file);
        return $result;
    }
}
