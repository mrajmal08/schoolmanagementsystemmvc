<?php

class userModel extends Database
{

    public function getData()
    {
        parent::__construct('role');
        return $this->show();
    }

    public function insertData($columns, $values, $data)
    {
        parent::__construct('user');
        return $this->insert($columns, $values, $data);
    }

    public function login($email, $password)
    {
        parent::__construct('user');
        return $this->login_user($email, $password);
    }

}
