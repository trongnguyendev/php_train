<?php

class Base {

    public $filePath = '';

    public $rules = [];

    public $fields = [];


    protected function validate(array $data)
    {
        $errors = [];

        foreach($this->rules as $field => $rule) {
            if(isset($data[$field])) {
                $_SESSION['old_input'][$field] = $data[$field];
    
                if(strpos($rule, 'required') !== false && empty($data[$field])){
                    $errors["error_{$field}"] = "{$field} là bắt Buộc.";
                }
            }else {
                if(strpos($rule, 'required') !== false){
                    $errors["error_{$field}"] = "{$field} là bắt Buộc.";
                }
            }
        }
        if(!empty($errors)){
            $_SESSION['errors'] = $errors;
        }else {
            $_SESSION['errors'] = [];
        }
        return $errors;

    }
    

    public function openFile($mode)
    {
        try{
            $file = fopen($this->filePath, $mode);
            if(!$file) {
                throw new RuntimeException("Không thể mở file: {$this->filePath}");
            }
            return $file;
        }catch (Exception $e){
            echo 'Caught exception:',$e->getMessage(), "\n";
        }
    }

    public function writeFile($line , $mode='a')
    {
        $file = $this->openFile($mode);
        if(!$file) return false;

        $values = array_map(fn($field) =>$line[$field] ?? '', $this->fields);
        fwrite($file, implode(',' , $values) . PHP_EOL);
        fclose($file);
        return $values;
    }

    public function store($data){
        $errors = $this->validate($data);
        if(!empty($errors)) return false;
        return $this->writeFile($data);
    }

    public function readFile($mode = 'r')
    {
        $file = $this->openFile($mode);
        if(!$file) return [];

        $lines = [];
        while (($line = fgets($file)) !== false){
            $lines[] = explode(',', $line);
        }
        fclose($file);
        return $lines;
    }

    public function findRowByIndex($indexData){
        $file = $this->openFile('r');
        if (!$file) return [];

        $index = 1;
        $result = [];

        while (($line = fgets($file)) !== false) { 
            if($indexData == $index) {
                $result = explode(',' , $line);
                break;
            }
            $index++;
        }
        fclose($file);
        return $result;
    }

    public function update (int $index, array $data):bool
    { 
        $errors =$this->validate($data);
        if(!empty($errors)) return false;
        $file = $this->openFile('r');
        if(!$file) return false;

        $updatedContent = '';
        $lineNumber = 1;

        if($file){
            while(($line = fgets($file)) !== false){
                if($lineNumber === $index) {
                    $values = array_map(fn($field) => $data[$field] ?? '', $this->fields);
                    $updatedContent .= implode(',', $values) . PHP_EOL;
                
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

    public function delete(int $index)
    {
        $file = $this->openFile('r');
        if(!$file) return false;

        $changeContent = '';
        $lineNumber = 1;

        if($file){
            while (($line = fgets($file)) !== false){
    
                if($lineNumber !== $index){
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

    public function all(){
        return $this->readFile();
    }

    public function findRowByType($searchContent , $searchType)
    {

        if(!$file = $this->openFile('r')){
            return [];
        }

        $_SESSION['old_search'] = [
            'search_content' => $searchContent,
            'search_type' => $searchType,
        ];

        $columnMap = [
            'name' => 0,
            'email' => 2,
            'phone' => 3,
        ];

        if(!isset($columnMap[$searchType])) {
            fclose($file);
            return [];
        }

        $searchItems = array_map('trim', explode(',', $searchContent));
        $columnIndex = $columnMap[$searchType];
        $result = [];

        while (($line = fgets($file)) !== false){
            $row = array_map('trim', explode(',' , $line));
            $valueToCheck =$row[$columnIndex] ?? '';

            foreach($searchItems as $item){
                if(str_contains($this->vn_to_str($valueToCheck), $this->vn_to_str($item))){
                    $result[] = $row;
                    break;
                }
            }
        }
        fclose($file);
        return $result;
    }


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
