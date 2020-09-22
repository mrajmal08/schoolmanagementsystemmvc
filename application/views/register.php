<?php  $error = $myData; ?>
<!DOCTYPE html>
<html class="h-100" lang="en">
<head>
    <?php
    require_once "../includes/head.php";
    ?>
</head>
<body class="h-100">
<div class="pt-5 mr-5 text-right">
    <a href="index" class="fa fa-home"> Home</a>
</div>
<div class="login-form-bg h-100">
    <div class="container h-100">
        <div class="row justify-content-center h-100">
            <div class="col-xl-6">
                <div class="form-input-content">
                    <div class="card login-form mb-0">
                        <div class="card-body pt-5">
                            <a class="text-center" href="index"><h4>
                                    School Management System</h4></a>
                            <form method="post" action="<?= urlPath('userController/signUp') ?>"
                                  class="mt-5 mb-5 login-input">
                                <div class="form-group">
                                    <label class="card-title">Name</label>
                                    <input type="text" class="form-control" name="name"
                                           placeholder="Enter Name" required>
                                    <?php
                                    if (!empty($error['name'])) {
                                        $this->print_errors($error['name']);
                                    }
                                    ?>

                                </div>
                                <div class="form-group">
                                    <label class="card-title">Email</label>
                                    <input type="text" class="form-control" name="email"
                                           placeholder="test@test.com" required>
                                    <?php
                                    if(!empty($error['email'])) {
                                        $this->print_errors($error['email']);
                                    }
                                    ?>

                                </div>
                                <div class="form-group">
                                    <label class="card-title">Password</label>
                                    <input type="password" class="form-control" name="password"
                                           placeholder="******" required>
                                    <?php
                                    if(!empty($error['password'])) {
                                        $this->print_errors($error['password']);
                                    }
                                    ?>

                                </div>
                                <div class="form-group">
                                    <label class="card-title">Address</label>
                                    <input type="text" class="form-control" name="address"
                                           placeholder="Enter Address">
                                </div>
                                <div class="form-group">
                                    <label class="card-title">Contact</label>
                                    <input type="number" class="form-control" name="contact"
                                           placeholder="123...">

                                </div>
                                <label class="card-title">Gender</label>
                                <div class="form-group">
                                    <label class="radio-inline mr-3" data-children-count="1">
                                        <input type="radio" class="" value="male" name="gender">
                                        Male</label>
                                    <label class="radio-inline mr-3" data-children-count="1">
                                        <input type="radio" value="female" name="gender">
                                        Female</label>
                                </div>
                                <div class="mb-2">
                                    <select class="form-control form-control-lg" name="role" required>
                                        <option disabled selected>--Select Role--</option>
                                        <?php
                                        foreach ($myData as $row) {
                                            ?>
                                            <option value="<?= $row['id'] ?>"><?= $row['name'] ?>
                                            </option>

                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <button type="submit" name="submitForm" class="btn login-form__btn
                                    submit w-100">Sign in
                                </button>
                            </form>
                            <p class="mt-5 login-form__footer">Have account <a href="login"
                                                                               class="text-primary">Sign In </a> now</p>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!--**********************************
    Scripts
***********************************-->
</body>
</html>

