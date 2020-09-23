<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once "../includes/head.php";
    ?>
</head>
<body>
<div id="main-wrapper">
    <div class="content-body body-height bg-home">
        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <div class="breadcrumb">
                    <li class="mr-3"><a href="<?= urlPath('userController/register') ?>">Register</a></li>
                    <li class=" active"><a href="<?= urlPath('userController/login') ?>">Login</a></li>
                </div>
            </div>
        </div>
        <div class="mt-5">
            <span class="font-weight-bold school">
            School Management System
            </span>
        </div>
    </div>
</div>



</body>
</html>