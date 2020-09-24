<?php

/** getting the base url */
function urlPath($url = '')
{
    if (!empty($url)) {
        return "/schoolmanagementsystemmvc/" . $url;
    } else {
        return "/schoolmanagementsystemmvc/";
    }
}

/** get input value function */
function input($inputName)
{
    if ($_SERVER['REQUEST_METHOD'] == "POST" || $_SERVER['REQUEST_METHOD'] == "post") {
        return trim(strip_tags($_POST[$inputName]));
    } elseif ($_SERVER['REQUEST_METHOD'] == "GET" || $_SERVER['REQUEST_METHOD'] == "get") {
        return trim(strip_tags($_GET[$inputName]));
    }
}

/** datatable function */
function datatable($thead, $tbody, $action)
{
    $dataTable = '';

    $dataTable .= "<div class='table-responsive'>";
    $dataTable .= "<table class='table table-striped table-bordered zero-configuration'>";
    $dataTable .= '<thead>';
    $dataTable .= '<tr>';

    /** getting table head */
    for ($i = 0; $i < count($thead); $i++) {
        $dataTable .= '<th>' . $thead[$i] . '</th>';
    }

    $dataTable .= '</tr>';
    $dataTable .= '</thead>';
    $dataTable .= '<tbody>';
    foreach ($tbody as $row) {
        $dataTable .= '<tr>';
        /** getting table body  */
        foreach ($row as $key => $body) {
            if ($key != 'id') {
                if ($key != 'status') {
                    if ($key != 'role_id') {
                        $dataTable .= '<td>' . $body . '</td>';
                    }
                }
            }
        }

        $dataTable .= '<td>';
        /** getting the actions(buttons)  */
        if (!empty($action)) {
            foreach ($action as $key => $button) {
                $url = $button['url'] . '?type=' . $button['value'];
                foreach ($button['require'] as $btn => $value) {
                    $url .= "&{$value}=" . $row[$value];
                }
                if (!empty($button['default'])) {
                    foreach ($button['default'] as $btns => $value) {
                        $url .= "&{$btns}=" . $value;
                    }
                }
                /** make the buttons url and type */
                $dataTable .= "<a class=' " . $button['class'] . " ' href=' " . $url . " '>
                                 " . $button['value'] . "</a>";
            }
        }

        $dataTable .= '</td>';
        $dataTable .= '</tr>';
    }
    $dataTable .= '</tbody>';
    $dataTable .= '</table>';
    $dataTable .= '</div>';
    return $dataTable;
}

