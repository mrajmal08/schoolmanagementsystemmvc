<?php

class roleModel extends Database
{
    use Admin;
    /** initialize constructor */
    public function __construct()
    {
        parent::__construct('role');
    }

}