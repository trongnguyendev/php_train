<?php

namespace Core;

class Validation {
    private $errors = [];
    private $data = [];
    private $rules = [];
    private $customMessages = [];

    public function __construct($data, $rules, $customMessages = []) {
        $this->data = $data;
        $this->rules = $rules;
        $this->customMessages = $customMessages;
    }

    public function validate() {
        foreach ($this->rules as $field => $fieldRules) {
            $rules = explode('|', $fieldRules);

            foreach ($rules as $rule) {
                if (strpos($rule, ':') !== false) {
                    list($ruleName, $parameter) = explode(':', $rule);
                } else {
                    $ruleName = $rule;
                    $parameter = null;
                }

                $method = 'validate' . ucfirst($ruleName);
                if (method_exists($this, $method)) {
                    $this->$method($field, $parameter);
                }
            }
        }

        return !$this->hasErrors();
    }

    private function validateRequired($field) {
        if (empty($this->data[$field])) {
            $this->addError($field, 'required', 'The ' . $field . ' field is required');
        }
    }

    private function validateEmail($field) {
        if (!empty($this->data[$field]) && !filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, 'email', 'The ' . $field . ' must be a valid email address');
        }
    }

    private function validateMin($field, $parameter) {
        if (!empty($this->data[$field]) && strlen($this->data[$field]) < $parameter) {
            $this->addError($field, 'min', 'The ' . $field . ' must be at least ' . $parameter . ' characters');
        }
    }

    private function validateMax($field, $parameter) {
        if (!empty($this->data[$field]) && strlen($this->data[$field]) > $parameter) {
            $this->addError($field, 'max', 'The ' . $field . ' may not be greater than ' . $parameter . ' characters');
        }
    }

    private function validateNumeric($field) {
        if (!empty($this->data[$field]) && !is_numeric($this->data[$field])) {
            $this->addError($field, 'numeric', 'The ' . $field . ' must be a number');
        }
    }

    private function addError($field, $rule, $defaultMessage) {
        $message = $this->customMessages[$field . '.' . $rule] ??
            $this->customMessages[$field] ??
            $defaultMessage;

        $this->errors[$field][] = $message;
    }

    public function hasErrors() {
        return !empty($this->errors);
    }

    public function getErrors() {
        return $this->errors;
    }
}