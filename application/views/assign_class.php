<?php
$sess = $myData;
$data = $body;
$singleData = $assigned;
$resultClass = $userId;

include '../includes/include.php'; ?>
<div class="content-body">
    <div class="login-form-bg mt-3 mb-3 ">
        <div class="row ml-3 mr-3">
            <div class="form-input-content col-12">
                <div class="card login-form mb-0">
                    <div class="card-body pt-5">
                        <a href="<?= urlPath('Student') ?>" class="btn btn-success float-left text-white"><span
                                class="fa fa-backward "> All Students</span> </a>
                        <a class="text-center" href="home.php"><h4>
                                Assign Class to <?= $data['name']; ?></h4></a>
                        <form method="post" action="<?= urlPath('Student/ClassAssignTo') ?>"
                              class="mt-5 mb-5 login-input">
                            <div class="row">
                                <div class="col-6">
                                    <input type="hidden" name="user_id"
                                           value="<?php echo $data['id']; ?>"/>
                                    <div class="mb-2 form-group">
                                        <select aria-label="ss" class="form-control form-control-lg" name="class_id"
                                                required>
                                            <option disabled selected>--Select class--</option>
                                            <?php
                                            $result = $resultClass;
                                            foreach ($result as $row) {
                                                ?>
                                                <option value="<?= $row['id'] ?>"><?= $row['name'] ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mt-4">
                                        <button type="submit" name="submit"
                                                class="btn login-form__btn submit w-100">
                                            Assign
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
    <!--**********************************
        Content body end
    ***********************************-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 text-left mt-2">
                                <span class="card-title text-black font-weight-semi-bold ">
                                    Assigned Class of <?= $data['name']; ?> </span>
                            </div>
                            <!--table for assigned classes-->
                            <?php
                            //table header array
                            $thead = ['Class Name', 'Class Number', 'Actions'];
                            $user_id = $data['id'];
                            $tbody = $singleData;

                            //buttons array
                            $action = [
                                'button1' => [
                                    'default' => [
                                        'user_id' => $user_id
                                    ],
                                    'value' => 'un_assign',
                                    'url' => 'unAssignClass',
                                    'require' => ['id'],
                                    'class' => 'btn btn-danger btn-sm'
                                ],
                            ];
                            echo datatable($thead, $tbody, $action);
//                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #/ container -->
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