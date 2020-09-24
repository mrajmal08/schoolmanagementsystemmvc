<?php

class Framework
{

    /** view function to return the value from controller */
    public function view($viewName, $body = [], $errors = [], $userId = '', $assigned = [])
    {
        if (file_exists("../application/views/" . $viewName . ".php")) {
            require_once "../application/views/$viewName.php";
        } else {
            return "Sorry method $viewName.php not found";
        }
    }

    /** getting the model */
    public function model($modelName)
    {
        if (file_exists("../application/models/" . $modelName . ".php")) {

            require_once "../application/models/$modelName.php";

            return new $modelName;
        } else {
            return "Sorry model $modelName.php not found";
        }
    }

    /** function for getting the helper function values */
    public function helper($helperName)
    {
        if (file_exists("../application/helpers/" . $helperName . ".php")) {
            require_once "../application/helpers/$helperName.php";
        } else {
            return "Sorry model $helperName.php not found";
        }
    }

    /** set session function */
    public function setSession($sessionName, $sessionValue)
    {
        if (!empty($sessionName) && !empty($sessionValue)) {
            $_SESSION[$sessionName] = $sessionValue;
        }
    }

    /** get session function */
    public function getSession($sessionName)
    {
        if (!empty($sessionName)) {
            return $_SESSION[$sessionName];
        }
    }

    /** unset session */
    public function unsetSession($sessionName)
    {
        if (!empty($sessionName)) {
            unset($_SESSION[$sessionName]);
        }
    }

    /** session destroy */
    public function destroy()
    {
        session_destroy();
    }

    /** redirect view function */
    public function redirect($path){
        header("location: ". urlPath() ." $path");
    }
}