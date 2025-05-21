<?php

namespace Models;

class Base {

    /**
     * Đường dẫn tới file dữ liệu.
     * @var string
     */
    public $filePath = '';

    /**
     * Mở file với chế độ đọc/ghi.
     *
     * @param string $mode Chế độ mở file (ví dụ: 'r', 'a', 'w+').
     * @return resource|false Trả về tài nguyên file nếu thành công, hoặc false nếu không thể mở file.
     */
    protected function openFile(string $mode)
    {
        try {
            $file = fopen($this->filePath, $mode);
            if (!$file) {
                throw new RuntimeException("Không thể mở file: {$this->filePath}");
            }
            return $file;
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
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

    /**
     * Tìm một dòng dữ liệu theo chỉ số.
     *
     * @param int $indexData Chỉ số dòng cần tìm.
     * @return array Mảng chứa dữ liệu của dòng đó hoặc mảng rỗng nếu không tìm thấy.
     */
    public function findRowByIndex($indexData) 
    {
        $file = $this->openFile('r');
        if (!$file) return [];

        $index = 1;
        $result = [];
        while (($line = fgets($file)) !== false) {
            if ($indexData == $index) {
                $result = explode(",", $line);
                break;
            }

            $index++;
        }

        fclose($file);
        
        return $result;
    }

    /**
     * Lấy tất cả dữ liệu từ file.
     *
     * @return array Mảng chứa tất cả dữ liệu trong file.
     */
    public function all(): array {
        return $this->readFile();
    }

    /**
     * Lưu một dòng dữ liệu vào file.
     *
     * @param array $data Dữ liệu cần lưu vào file.
     * @return bool Trả về true nếu lưu thành công, false nếu thất bại.
     */
    public function store($data) {
        return $this->writeFile($data);
    }

    /**
     * Cập nhật dữ liệu tại dòng cụ thể trong file.
     *
     * @param int $targetLine Chỉ số dòng cần cập nhật.
     * @param array $newData Dữ liệu mới cần cập nhật.
     * @return bool Trả về true nếu cập nhật thành công, false nếu thất bại.
     */
    public function update(int $targetLine, array $newData): bool
    {
        $file = $this->openFile('r');
        if (!$file) return false;

        $updatedContent = '';
        $lineNumber = 1;

        if ($file) {
            while (($line = fgets($file)) !== false) {
                if ($lineNumber === $targetLine) {
                    $values = array_map(fn($field) => $newData[$field] ?? '', $this->fields);
                    $updatedContent .= implode(',', $values) . PHP_EOL;
                } else {
                    $updatedContent .= $line;
                }
                $lineNumber++;
            }
            fclose($file);
        }

        $file = fopen($this->filePath, "w+");
        if (!$file) return false;

        fwrite($file, $updatedContent);
        fclose($file);
        
        return true;
    }

    public function delete(int $targetLine): bool
    {
        $file = $this->openFile('r');
        if (!$file) return false;

        $changeContent = '';
        $lineNumber = 1;

        if ($file) {
            while (($line = fgets($file)) !== false) {
                if ($lineNumber !== $targetLine) {
                    $changeContent .= $line;
                }
                $lineNumber++;
            }
            fclose($file);
        }

        $file = fopen($this->filePath, "w+");
        if (!$file) return false;

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
            'email' => 1,
            'age' => 2,
        ];

        if (!isset($columnMap[$searchType])) {
            fclose($file);
            return [];
        }

        $searchItems = array_map('trim', explode(',', $searchContent));
        $columnIndex = $columnMap[$searchType];
        $result = [];

        while (($line = fgets($file)) !== false) {
            $row = array_map('trim', explode(',', $line));
            $valueToCheck = $row[$columnIndex] ?? '';

            foreach ($searchItems as $item) {
                if (str_contains($valueToCheck, $item)) {
                    $result[] = $row;
                    break;
                }
            }
        }

        fclose($file);
        return $result;
    }
}

?>