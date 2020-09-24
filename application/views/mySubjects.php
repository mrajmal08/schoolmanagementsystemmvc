<?php
$sessionId = $this->getSession('id');
$sessionName = $this->getSession('name');
$subjects = $body;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include "../includes/head.php";
    ?>
</head>
<body>
<!--**********************************
    Main wrapper start
***********************************-->
<div id="main-wrapper">
    <!--**********************************
        Nav header start
    ***********************************-->
    <div class="nav-header">
        <div class="brand-logo">
            <a href="<?= urlPath('subjectController/mySubject') ?>">
                <b class="logo-abbr"><img src="images/logo.png" alt=""> </b>
                <span class="logo-compact"><img src="./images/logo-compact.png" alt=""></span>
                <span class="brand-title text-white">
                       School Management System
                    </span>
            </a>
        </div>
    </div>
    <?php include '../includes/header.php' ?>
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
                                    My Subjects</span>
                                </div>
                                <?php
                                $thead = ['Subject Name', 'Author Name'];
                                $tbody = $subjects;
                                echo datatable($thead, $tbody, '');
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