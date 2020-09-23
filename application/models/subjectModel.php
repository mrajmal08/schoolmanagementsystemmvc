<?php

class subjectModel extends Database
{
    use Student;

    /** initialize subject constructor */
    public function __construct()
    {
        parent::__construct('subject');
    }

}
