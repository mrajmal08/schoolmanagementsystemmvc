<?php

class Framework
{

    public function view($viewName, $myData = [])
    {
        if (file_exists("../application/views/" . $viewName . ".php")) {
            require_once "../application/views/$viewName.php";
        } else {
            echo "<span style='color: red'>Sorry method $viewName.php not found</span>";
        }
    }

    public function model($modelName)
    {
        if (file_exists("../application/models/" . $modelName . ".php")) {

            require_once "../application/models/$modelName.php";

            return new $modelName;
        } else {
            echo "<span style='color: red'>Sorry model $modelName.php not found</span>";

        }
    }
}