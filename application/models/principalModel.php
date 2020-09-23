<?php

class principalModel extends Database
{
    /** initialize principal constructor  */
    public function __construct()
    {
        parent::__construct('user');
    }

}
