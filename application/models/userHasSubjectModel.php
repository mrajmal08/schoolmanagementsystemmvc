<?php

class userHasSubjectModel extends Database
{
    use Student;

    public function __construct()
    {
        parent::__construct('user_has_subject');
    }
}