<?php
$sessionId = $this->getSession('id');
$sessionName = $this->getSession('name');
$error = $errors;
$user = $userId;
$tableBody = $body;

if ($user) {
    $actionPath = urlPath('classController/updateclass');
} else {
    $actionPath = urlPath('classController/createClass');
}

include '../includes/include.php';
?>
<div class="content-body">
    <div class="login-form-bg mt-3 mb-3 ">
        <div class="row ml-3 mr-3">
            <div class="form-input-content col-12">
                <div class="card login-form mb-0">
                    <div class="card-body pt-5">
                        <a class="text-center" href="<?= urlPath('home') ?>"><h4>Fill the
                                <?php echo isset($user['name']) ?
                                    $user['name'] : ""; ?> Detail</h4></a>
                        <!-- class adding and editing code with validation error code -->
                        <form method="post" action="<?= $actionPath ?>" class="mt-5 mb-5 login-input">
                            <div class="row">
                                <div class="col-6">
                                    <input type="hidden" name="class_id" value="
                                    <?php echo isset($user['id']) ?
                                        $user['id'] : ""; ?>"/>
                                    <div class="form-group">
                                        <label class="card-title">Class Name</label>
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
                                        <label class="card-title">Class No</label>
                                        <input type="text" class="form-control" name="number"
                                               placeholder="123..."
                                               value="<?php echo isset($user['number']) ?
                                                   $user['number'] : ""; ?>"
                                               required>
                                    </div>
                                    <?php
                                    if (isset($_GET['id'])) {
                                        ?>
                                        <input type="hidden" value="true" name="edit">
                                        <?php
                                    }
                                    ?>
                                    <div class="mt-4">
                                        <button type="submit" name="submitClass"
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
                                    Classes Detail</span>
                            </div>
                            <?php
                            $thead = ['Class Name', 'Class Number', 'Actions'];
                            $tbody = $tableBody;

                            $action = [
                                'button1' => [
                                    'value' => 'delete',
                                    'url' => "".urlPath('classController') ."/delete",
                                    'require' => ['id'],
                                    'class' => 'btn btn-danger btn-sm'
                                ],
                                'button2' => [
                                    'value' => 'edit',
                                    'url' => "".urlPath('classController') ."/edit",
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