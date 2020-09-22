<?php

class Framework
{
    public $data;
    public $errors = [];

    public function view($viewName, $myData = [], $body = [], $sess= [], $userId= '', $assigned= [])
    {
        if (file_exists("../application/views/" . $viewName . ".php")) {
            require_once "../application/views/$viewName.php";
        } else {
            echo "<span style='color: red'>Sorry method $viewName.php not found</span>";
        }
    }

    public function model($modelName)
    {
        if (file_exists("../application/models/" . $modelName . ".php")) {

            require_once "../application/models/$modelName.php";

            return new $modelName;
        } else {
            echo "<span style='color: red'>Sorry model $modelName.php not found</span>";

        }
    }

    public function input($inputName)
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST" || $_SERVER['REQUEST_METHOD'] == "post") {
            return trim($_POST[$inputName]);
        } elseif ($_SERVER['REQUEST_METHOD'] == "GET" || $_SERVER['REQUEST_METHOD'] == "get") {
            return trim($_GET[$inputName]);
        }
    }

    public function validate($data, $rules)
    {
        $this->data = $data;
        try {
            if (!empty($rules)) {
                foreach ($rules as $field_name => $field_rules) {
                    $rules_array = explode('|', $field_rules);
                    foreach ($rules_array as $rule) {
                        $current_rule = explode(':', $rule);

                        /** @var if $current_rule doesn't got any value */
                        if (!isset($current_rule[1])) {
                            $current_rule[1] = true;
                        }
                        if (!empty($current_rule[1])) {
                            $param = [$current_rule[1], $field_name, $data[$field_name]];
                            if (method_exists($this, $current_rule[0])) {
                                $func = $current_rule[0];
                                $this->$func(...$param);
                            } else {
                                throw new Exception('Method now found');
                            }
                        }
                    }
                }
            }
        } catch (PDOException $e) {
            return "Error : " . $e->getMessage();
        }
    }

    /**
     * check the required condition
     * @param $key
     * @return array|bool
     */
    public function required($data, $value, $field)
    {
        if ($field) {
            return true;
        } else {
            $this->errors[$value][] = " $value is required";
        }
//        $this->errors[$value][] = " $value is required";
//        return empty($field) ? false : true;
    }

    /**
     * email validation
     * @param $data
     * @return bool
     */
    protected function email($data, $value, $field)
    {
        if (filter_var($field, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            $this->errors[$value][] = "Enter a valid email";
        }

//        $this->errors[$value][] = "Enter a valid email";
//        return empty(filter_var($field, FILTER_VALIDATE_EMAIL)) ? false : true;
    }

    /**
     * max validation checck function
     * @param $length
     * @param $field_name
     * @param $data
     * @return bool
     */
    protected function max($length, $field_name, $data)
    {
        if (strlen($data) <= $length) {
            return true;
        } else {
            $this->errors[$field_name][] = "maximum {$length} char";
        }
//        $this->errors[$field_name][] = "maximum {$length} char";
//        return empty(strlen($data) <= $length) ? false : true;
    }

    /**
     * min validation check function
     * @param $length
     * @param $field_name
     * @param $data
     * @return bool
     */
    protected function min($length, $field_name, $data)
    {
        if (strlen($data) >= $length) {
            return true;
        } else {
            $this->errors[$field_name][] = "minimum {$length} char";
        }
//        $this->errors[$field_name][] = "minimum {$length} char";
//        return empty(strlen($data) >= $length) ? false : true;
    }

    /**
     * validation errors function
     * @param $item
     */
    public function print_errors($item)
    {
        foreach ($item as $value) {
            ?>
            <span class="alert alert-danger"><?= $value ?></span>
            <?php
        }
    }
}