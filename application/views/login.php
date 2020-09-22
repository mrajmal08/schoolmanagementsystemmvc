<!DOCTYPE html>
<html class="h-100" lang="en">
<head>
    <?php
    include "../includes/head.php";
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
                            <form method="post" action="loginUser" class="mt-5 mb-5 login-input">
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control"
                                           placeholder="Email"
                                           required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control"
                                           placeholder="Password" required>
                                </div>
                                <button type="submit" name="submitLogin"
                                        class="btn login-form__btn submit w-100">Sign In
                                </button>
                            </form>
                            <p class="mt-5 login-form__footer">Dont have account?
                                <a href="register"
                                   class="text-primary">Sign Up</a>
                                now</p>
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