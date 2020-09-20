<?php

class userController extends Framework
{

    public function index()
    {
        $my = $this->model('userModel');
        $my->myData();
//        $myData = [
//            'title' => "this is the title",
//            'body' => 'this is the body'
//        ];
//
//        $this->view('userView', $myData);
    }

}