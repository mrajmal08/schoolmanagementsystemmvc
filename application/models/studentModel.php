<?php

class studentModel extends Database
{
    use Student;
    public function __construct()
    {
        parent::__construct('user');
    }

}
