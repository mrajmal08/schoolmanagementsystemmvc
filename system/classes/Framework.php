<?php

class Framework
{

    public function view($viewName, $myData = [], $body = [], $sess= [], $userId= '', $assigned= [])
    {
        if (file_exists("../application/views/" . $viewName . ".php")) {
            require_once "../application/views/$viewName.php";
        } else {
            return "Sorry method $viewName.php not found";
        }
    }

    public function model($modelName)
    {
        if (file_exists("../application/models/" . $modelName . ".php")) {

            require_once "../application/models/$modelName.php";

            return new $modelName;
        } else {
            return "Sorry model $modelName.php not found";

        }
    }
}