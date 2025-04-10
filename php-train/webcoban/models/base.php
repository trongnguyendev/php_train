<?php
class base {
    public $filePath = '';


    /**
     * Mở file ra để kiểm ra trong file có gì, nếu lỗi sẽ hiển thị lỗi ra view
     * Mở file với chế độ đọc/ghi.
     *
     * @param string $mode Chế độ mở file (ví dụ: 'r', 'a', 'w+').
     * @return resource|false Trả về tài nguyên file nếu thành công, hoặc false nếu không thể mở file.
     */
    public function openFile(string $mode){
        try{
            $file = fopen($this->filePath,$mode); // Mở file với chế độ ghi (xóa dữ liệu cũ)
            if(!$file){
                throw new RuntimeException("Không thể mở file:{$this->filePath}");
            }
            return $file;
        } catch(Exception $e){
            echo 'Caught exceptione: ', $e->getMessage(), "/n";
        }
    }

       /**
     * Đọc dữ liệu từ file và trả về mảng.
     *
     * @param string $mode Chế độ đọc file (mặc định là 'r').
     * @return array Mảng chứa các dòng dữ liệu từ file, mỗi dòng là một mảng các trường.
     */
    protected function readFile(string $mode = 'r'): array
    {
        $file = $this->openFile($mode);
        if (!$file) return [];

        $lines = [];
        while (($line = fgets($file)) !== false) {
            $lines[] = explode(",", $line);
        }

        fclose($file);
        return $lines;
    }

    /**
     * Ghi một dòng dữ liệu vào file.
     *
     * @param array $line Dữ liệu cần ghi vào file (dưới dạng mảng với các trường 'name', 'email', 'age').
     * @param string $mode Chế độ ghi file (mặc định là 'a').
     * @return bool Trả về true nếu ghi thành công, false nếu thất bại.
     */
    protected function writeFile(array $line, $mode = 'a'): bool
    {
        $file = $this->openFile($mode);
        if (!$file) return false;

        $values = array_map(fn($field) => $line[$field] ?? '', $this->fields);
        fwrite($file, implode(',', $values) . PHP_EOL);
        fclose($file);
        return true;
    }



}