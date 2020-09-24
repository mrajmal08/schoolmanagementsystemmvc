<?php
  $sessionId = $this->getSession('id');
  $sessionName = $this->getSession('name');
  $sessionRole = $this->getSession('role');
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
    <?php include '../includes/header.php' ?>
    <?php include "../includes/sidebar.php"; ?>

    <div class="content-body">
        <div class="container-fluid bgimg">
            <div class="row ">
                <div class="col-12 ">
                    <div class="card ">
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!--**********************************
    Main wrapper end
***********************************-->
<?php include '../includes/footer.php'; ?>
<!--**********************************
    Scripts
***********************************-->


<script src="<?= urlPath('plugins/tables/js/jquery.dataTables.min.js') ?>"></script>
<script src=" <?= urlPath('plugins/tables/js/datatable/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?= urlPath('plugins/tables/js/datatable-init/datatable-basic.min.js') ?>"></script>

</body>

</html>