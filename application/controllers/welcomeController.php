<?php

class welcomeController extends Framework {

    public function index(){
        $this->helper('functions');
        $this->view('welcome');
    }
}