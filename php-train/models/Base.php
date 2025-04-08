<?php

class Base {

    /**
     * Đường dẫn tới file dữ liệu.
     * @var string
     */
    public $filePath = '';

    public $rules = [
        'name' => 'required',
        'email' => 'required',
        'age' => 'required|max:100'
    ];

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
     * Xác thực dữ liệu đầu vào theo các quy tắc.
     *
     * @param array $data Dữ liệu cần xác thực.
     * @return array Mảng chứa lỗi nếu có, mảng rỗng nếu không có lỗi.
     */
    protected function validate(array $data): array
    {
        $errors = [];
        
        foreach ($this->rules as $field => $rule) {
            if (isset($data[$field])) {
                $_SESSION['old_input'][$field] = $data[$field];

                if (strpos($rule, 'required') !== false && empty($data[$field])) {
                    $errors["error_{$field}"] = "{$field} là bắt buộc.";
                }
                if (strpos($rule, 'max:') !== false && $field == 'age' && (int)$data[$field] > 100) {
                    $errors["error_{$field}"] = "{$field} không được lớn hơn 100.";
                }
            } else {
                if (strpos($rule, 'required') !== false) {
                    $errors["error_{$field}"] = "{$field} là bắt buộc.";
                }
            }
        }

        // Lưu lỗi vào SESSION để hiển thị ở frontend
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
        } else {
            $_SESSION['errors'] = [];  // Xóa lỗi nếu không còn lỗi
        }

        return $errors;
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
        $errors = $this->validate($data);
        if (!empty($errors)) return false;
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
        $errors = $this->validate($newData);
        if (!empty($errors)) return false;
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
}

?>