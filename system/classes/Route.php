<?php

class Route
{
    public $controller = 'welcomeController';
    public $method = 'index';
    public $param = [];

    /** set constructor to get the controllers */
    public function __construct()
    {
        $url = $this->url();
        if (!empty($url)) {
            if (file_exists("../application/controllers/" . $url[0] . ".php")) {
                $this->controller = $url[0];
                unset($url[0]);
            } else {
                return "Sorry " . $url[0] . ".php not found";
            }
        }
        /** includes controller **/
        require_once "../application/controllers/" . $this->controller . ".php";
        /** instantiate controller **/
        $this->controller = new $this->controller;

        if (isset($url[1]) && !empty($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            } else {
                echo "Sorry method " . $url[1] . ".php not found";
            }
        }
        if (isset($url)) {
            $this->param = $url;
        } else {
            $this->param = [];
        }
        call_user_func_array([$this->controller, $this->method], $this->param);
    }

    /** function for getting the clean url */
    public function url()
    {
        if (isset($_GET['url'])) {
            $url = $_GET['url'];
            $url = rtrim($url);
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;

        }
    }

}