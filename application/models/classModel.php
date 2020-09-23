<?php

class classModel extends Database
{
    use Student;

    /** initialize class constructor */
    public function __construct()
    {
        parent::__construct('class');
    }
}
