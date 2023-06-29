<?php
    include("connect.php");
    include("sessions.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("template/header.php") ?>
</head>
<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <?php include("template/loading.php"); ?>
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="/login.php" class="">
                                <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>HUS</h3>
                            </a>
                            <h3>Đăng ký</h3>
                        </div>
                        <?php
                                if(isset($_SESSION['khongthanhcong'])) {
                            ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fa fa-exclamation-circle me-2"></i><?php echo $_SESSION['khongthanhcong']; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php
                                unset($_SESSION['khongthanhcong']);
                            }
                            ?>

                        <?php
                                if(isset($_SESSION['thanhcong'])) {
                        ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fa fa-exclamation-circle me-2"></i><?php echo $_SESSION['thanhcong']; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php
                                unset($_SESSION['thanhcong']);
                            }
                            ?>

                        <form name="formdangky" method="POST" action="signup.php">
                            <div class="form-floating mb-3">
                                <input name="username" type="text" class="form-control" id="floatingText">
                                <label for="floatingText">Username</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input name="email" type="email" class="form-control" id="floatingInput">
                                <label for="floatingInput">Email</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input name="password" type="password" class="form-control" id="floatingPassword">
                                <label for="floatingPassword">Mật khẩu</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input name="password2" type="password" class="form-control" id="floatingPassword">
                                <label for="floatingPassword">Xác nhận lại mật khẩu</label>
                            </div>
                            <button name="dangkytaikhoan" type="submit" class="btn btn-primary py-3 w-100 mb-4">Đăng ký</button>
                            <p class="text-center mb-0">Có phải bạn đã có tài khoản?<a href="/login.php">Đăng nhập</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
        if (isset($_POST['dangkytaikhoan'])) {
            $username = mysqli_real_escape_string($connect, $_POST['username']);
            $email = mysqli_real_escape_string($connect, $_POST['email']);
            $password = md5($_POST['password']);
            $password2 = md5($_POST['password2']);
            if ($username != "" && $email != "" && $password != "" && $password2 != "")
            {
                $sqlcheckuser = "SELECT * FROM `users` WHERE `email` = '". $email ."'";
                $ketqua = $connect->query($sqlcheckuser);

                if ($ketqua->num_rows > 0) {
                    $_SESSION['khongthanhcong'] = "Địa chỉ email đã tồn tại";
                    echo '<meta http-equiv="refresh" content="0;URL=signup.php">';
                } else {
                    if ($password != $password2) {
                        $_SESSION['khongthanhcong'] = "Mật khẩu và Xác nhận mật khẩu không chính xác";
                        echo '<meta http-equiv="refresh" content="0;URL=signup.php">';
                    }
                    else {
                        $adminlevel = 0;
                        $connect->query("INSERT INTO `users` (`username`, `password`, `email`, `adminlevel`) VALUES ('". $username ."', '". $password ."', '". $email ."', '". $adminlevel ."')");
                        $_SESSION['thanhcong'] = "Tạo tài khoản thành công";
                        echo '<meta http-equiv="refresh" content="0;URL=signup.php">';
                    }
                }
            }
            else
            {
                $_SESSION['khongthanhcong'] = "Các thông tin trên không được bỏ trống";
                echo '<meta http-equiv="refresh" content="0;URL=signup.php">';
            }
        }
    ?>
    <?php include("template/scripts.php") ?>
</body>

</html>