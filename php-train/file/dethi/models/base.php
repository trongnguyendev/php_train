<?php
class Base { 
    public $filePath = '';
    public $fields =[];

    protected function openFile($mode){
        try{
            $file = fopen($this->filePath, $mode);
            if(!$file){
                throw new RuntimeException("Không thể mở file:{$this->filePath}");
            }
            return $file;
        }catch (Exception $e){
            echo 'Caught exception:' ,$e->getMessage(), "\n";
        }
    }
    public function writeFile($line , $mode = 'a'){
        $file = $this->openFile($mode);
        if(!$file) return false;

        $values = array_map(fn($field) => $line[$field] ?? '',$this->fields);
        fwrite($file, implode (',' ,$values) . PHP_EOL);
        fclose($file);
        return $values;
    }
    public function readFile($mode = 'r'){
        $file = $this->openFile($mode);
        if(!$file) return [];

        $lines = [];
        while (($line = fgets($file)) !== false){
            $lines[] = explode (',',$line);
        }
        fclose($file);
        return $lines;
    }

    public function store($data){
        return $this->writeFile($data);
    }
    public function all(){
        return $this->readFile();
    }
}