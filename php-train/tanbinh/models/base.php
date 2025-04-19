<?php

class Base {

    public $filePath = '';
    public $rules = '';

    protected function openFile(string $mode) 
    {
        try {
            $file = fopen($this->filePath, $mode);
            if(!$file){
                throw new RuntimeException( "Không thể mở file: {$this->filePath}");
            }
            return $file;
        } catch (Exception $e){
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }

    protected function writeFile(array $line, $mode = 'a'):bool 
    {
        $file = $this->openFile($mode);
        if(!$file) return false ;

        $values = array_map(fn($field) => $line[$field] ?? '', $this->fields);
        fwrite($file,implode(',', $values) .PHP_EOL);
        fclose($file);
        return true;
    }

    public function store($data){
        return $this->writeFile($data);
    }
}