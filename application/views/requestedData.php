<?php
$tableBody = $body;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php

    include "../includes/head.php";

    ?>
</head>
<body>
<div id="main-wrapper">
    <div class="nav-header">
        <div class="brand-logo">
            <a href="home">
                <b class="logo-abbr"><img src="#" alt=""> </b>
                <span class="logo-compact"><img src="#" alt=""></span>
                <span class="brand-title text-white">
                       School Management System
                    </span>
            </a>
        </div>
    </div>
    <?php include '../includes/header.php'; ?>
    <?php include "../includes/sidebar.php"; ?>
    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4 text-left mt-2">
                                <span class="card-title text-black font-weight-semi-bold ">
                                    Requested Users</span>
                                </div>
                                <!--Table for approval request of users-->
                                <?php


                                $thead = ['Name', 'Email', 'Address', 'Contact', 'Gender', 'Action'];
                                $tbody = $tableBody;
                                $action = [
                                    'button1' => [
                                        'value' => 'approve',
                                        'url' => 'approveUser',
                                        'require' => ['id'],
                                        'class' => 'btn btn-danger btn-sm'
                                    ],
                                    'button2' => [
                                        'value' => 'un_approve',
                                        'url' => 'unApproveUser',
                                        'require' => ['id'],
                                        'class' => 'btn btn-warning btn-sm'
                                    ],

                                ];
                                echo datatable($thead, $tbody, $action);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #/ container -->
        </div>
        <?php include '../includes/footer.php'; ?>
    </div>
    <script src="<?= urlPath('plugins/tables/js/jquery.dataTables.min.js') ?>"></script>
    <script src=" <?= urlPath('plugins/tables/js/datatable/dataTables.bootstrap4.min.js') ?>"></script>
    <script src="<?= urlPath('plugins/tables/js/datatable-init/datatable-basic.min.js') ?>"></script>

</body>
</html>