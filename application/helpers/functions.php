<?php
session_start();

function urlPath($url)
{
    return "/schoolmanagementsystemmvc/" . $url;
}

function getSessionData()
{
    $session = [
        $_SESSION['sess_user_id'],
        $_SESSION['sess_name'],
        $_SESSION['role']
    ];
    return $session;
}

function input($inputName)
{
    if ($_SERVER['REQUEST_METHOD'] == "POST" || $_SERVER['REQUEST_METHOD'] == "post") {
        return trim($_POST[$inputName]);
    } elseif ($_SERVER['REQUEST_METHOD'] == "GET" || $_SERVER['REQUEST_METHOD'] == "get") {
        return trim($_GET[$inputName]);
    }
}

function getTableHead($thead = [])
{
    $head = '';
    if (!empty($thead)) {
        foreach ($thead as $key => $item) {
            $head .= '<th>' . $item . '</th>';
        }
        return $head;
    }
}

function datatable($thead, $tbody, $action)
{
    $dataTable = '';

    $dataTable .= "<div class='table-responsive'>";
    $dataTable .= "<table class='table table-striped table-bordered zero-configuration'>";
    $dataTable .= '<thead>';
    $dataTable .= '<tr>';

    for ($i = 0; $i < count($thead); $i++) {
        $dataTable .= '<th>' . $thead[$i] . '</th>';
    }

    $dataTable .= '</tr>';
    $dataTable .= '</thead>';
    $dataTable .= '<tbody>';
    foreach ($tbody as $row) {
        $dataTable .= '<tr>';
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

