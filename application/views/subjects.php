<?php
$error = $sess;
$user = $userId;
$session = $myData;
$tableBody = $body;
if ($user) {
    $actionPath = urlPath('subjectController/updateSubject');
} else {
    $actionPath = urlPath('subjectController/createSubject');
}
include '../includes/include.php'; ?>

<div class="content-body">
    <div class="login-form-bg mt-3 mb-3 ">
        <div class="row ml-3 mr-3">
            <div class="form-input-content col-12">
                <div class="card login-form mb-0">
                    <div class="card-body pt-5">
                        <a class="text-center" href="home.php"><h4>Edit
                                <?php echo isset($user['name']) ?
                                    $user['name'] : ""; ?> Detail</h4></a>
                        <!-- subject adding and editing code with validation error code -->
                        <form method="post" action="<?= $actionPath ?>" class="mt-5 mb-5 login-input">
                            <div class="row">
                                <div class="col-6">
                                    <input type="hidden" name="subject_id"
                                           value="<?php echo isset($user['id']) ?
                                               $user['id'] : ""; ?>"/>
                                    <div class="form-group">
                                        <label class="card-title">Subject Name</label>
                                        <input type="text" class="form-control" name="name"
                                               placeholder="Enter Name"
                                               value="<?php echo isset($user['name']) ?
                                                   $user['name'] : ""; ?>"
                                               required>
                                        <?php
                                        if (!empty($error['name'])) {
                                            $this->print_errors($error['name']);
                                        }
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label class="card-title">Author Name</label>
                                        <input type="text" class="form-control" name="author"
                                               placeholder="author name"
                                               value="<?php echo isset($user['author'])
                                                   ? $user['author'] :
                                                   ""; ?>" required>
                                    </div>
                                    <?php
                                    if (isset($_GET['id'])) {
                                        ?>
                                        <input type="hidden" value="true" name="edit">
                                        <?php
                                    }
                                    ?>
                                    <div class="mt-4">
                                        <button type="submit" name="submitSubject"
                                                class="btn login-form__btn submit w-100">Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 text-left mt-2">
                                <span class="card-title text-black font-weight-semi-bold ">
                                    Subjects Detail</span>
                            </div>
                            <?php
                            $thead = ['Class Name', 'Auhtor Name', 'Actions'];
                            $tbody = $tableBody;
                            $action = [
                                'button1' => [
                                    'value' => 'delete',
                                    'url' => 'subjectController/delete',
                                    'require' => ['id'],
                                    'class' => 'btn btn-danger btn-sm'
                                ],
                                'button2' => [
                                    'value' => 'edit',
                                    'url' => 'subjectController/edit',
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

<!--**********************************
    Scripts
***********************************-->
<script src="<?= urlPath('plugins/tables/js/jquery.dataTables.min.js') ?>"></script>
<script src=" <?= urlPath('plugins/tables/js/datatable/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?= urlPath('plugins/tables/js/datatable-init/datatable-basic.min.js') ?>"></script>

</body>
</html>