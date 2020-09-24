<?php

class userModel extends Database
{
    use Admin;
    /** initialize constructor */
    public function __construct()
    {
        parent::__construct('user');
    }
}
