<?php

namespace Core;

class Validation {
    // Biến chứa các lỗi
    // Lỗi sẽ được lưu dưới dạng mảng
    private $errors = [];
    // Biến chứa dữ liệu
    // Dữ liệu sẽ được truyền vào từ controller
    // Dữ liệu sẽ được kiểm tra theo các quy tắc đã định nghĩa
    private $data = [];
    // Quy tắc sẽ được truyền vào từ controller
    // Quy tắc sẽ được định nghĩa dưới dạng mảng
    // Quy tắc sẽ được kiểm tra theo các quy tắc đã định nghĩa
    private $rules = [];
    // Biến chứa các thông báo lỗi tùy chỉnh
    // Thông báo lỗi sẽ được truyền vào từ controller
    private $customMessages = [];

    // Constructor
    // Hàm khởi tạo sẽ nhận vào 3 tham số
    // $data: dữ liệu sẽ được kiểm tra
    // $rules: quy tắc sẽ được kiểm tra
    // $customMessages: thông báo lỗi tùy chỉnh
    // Nếu không có thông báo lỗi tùy chỉnh thì sẽ sử dụng thông báo lỗi mặc định
    // Nếu có thông báo lỗi tùy chỉnh thì sẽ sử dụng thông báo lỗi tùy chỉnh
    public function __construct($data, $rules, $customMessages = []) {
        $this->data = $data;
        $this->rules = $rules;
        $this->customMessages = $customMessages;
    }

    // Hàm kiểm tra dữ liệu
    // Hàm này sẽ kiểm tra dữ liệu theo các quy tắc đã định nghĩa
    // Hàm này sẽ trả về true nếu dữ liệu hợp lệ
    // Hàm này sẽ trả về false nếu dữ liệu không hợp lệ
    public function validate() {
        foreach ($this->rules as $field => $fieldRules) {
            $rules = explode('|', $fieldRules);

            foreach ($rules as $rule) {
                $method = 'validate' . ucfirst($rule);
                if (method_exists($this, $method)) {
                    $this->$method($field);
                }
            }
        }

        return !$this->hasErrors();
    }

    // Hàm kiểm tra lỗi required
    // Hàm này sẽ kiểm tra xem input có giá trị hay không
    // Nếu không có giá trị thì sẽ thêm lỗi vào mảng errors
    // Nếu có giá trị thì sẽ không làm gì cả
    private function validateRequired($field) {
        if (empty($this->data[$field])) {
            $defaultMessage = 'The ' . $field . ' field is required';
            $this->addError($field, 'required', $defaultMessage);
        }
    }

    // Hàm kiểm tra lỗi email
    // Hàm này sẽ kiểm tra xem input có phải là email hay không
    // Nếu không phải là email thì sẽ thêm lỗi vào mảng errors
    // Nếu là email thì sẽ không làm gì cả
    private function validateEmail($field) {
        if (!empty($this->data[$field]) && !filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            $defaultMessage = 'The ' . $field . ' must be a valid email address';
            $this->addError($field, 'email', $defaultMessage);
        }
    }

    // Hàm thêm lỗi vào mảng errors
    // Hàm này sẽ nhận vào 3 tham số
    // $field: tên của input
    // $rule: tên của quy tắc
    // $defaultMessage: thông báo lỗi mặc định
    // Nếu không có thông báo lỗi tùy chỉnh thì sẽ sử dụng thông báo lỗi mặc định
    // Nếu có thông báo lỗi tùy chỉnh thì sẽ sử dụng thông báo lỗi tùy chỉnh
    private function addError($field, $rule, $defaultMessage) {
        $message = $this->customMessages[$field . '.' . $rule] ??
            $this->customMessages[$field] ??
            $defaultMessage;

        $this->errors[$field][] = $message;
    }

    // Hàm kiểm tra có lỗi hay không
    // Hàm này sẽ trả về true nếu có lỗi
    // Hàm này sẽ trả về false nếu không có lỗi
    public function hasErrors() {
        return !empty($this->errors);
    }

    // Hàm lấy lỗi
    // Hàm này sẽ trả về mảng lỗi
    public function getErrors() {
        return $this->errors;
    }
}