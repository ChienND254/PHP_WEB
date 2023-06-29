<?php
include("connect.php");
include("sessions.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('template/header.php') ?>
</head>

<body>
    <?php
    if (isset($_SESSION['dangnhapthanhcong']) || isset($_COOKIE["rememberme"])) { // kiểm tra xem đã đăng nhập có chạy đoạn code ở dưới
        ?>
        <div class="container-xxl position-relative bg-white d-flex p-0">
            <?php include("template/loading.php"); ?>
            <?php include('template/sidebar.php') ?>
            <div class="content">
                <?php include('template/navbar.php') ?>
                <div class="container-fluid pt-4 px-4">
                    <div class="row vh-100 bg-light rounded mx-0">
                        <div class="col-sm-12 col-xl-6">
                            <div class="bg-light rounded h-100 p-4">
                                <h6 class="mb-4">Chỉnh sửa thông tin</h6>
                                <?php
                                if (isset($_SESSION['khongthanhcong'])) {
                                ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fa fa-exclamation-circle me-2"></i>
                                    <?php echo $_SESSION['khongthanhcong']; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <?php
                                    unset($_SESSION['khongthanhcong']);
                                }
                                ?>
                                <form method="POST" action="profile.php">
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Tên hiển thị</label>
                                        <input type="text" class="form-control" name="username" placeholder="<?php echo $_SESSION['username']; ?>">
                                            
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email address</label>
                                        <input type="email" class="form-control" name="email" placeholder="<?php echo $_SESSION['email']; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="oldpassword" class="form-label">Mật khẩu cũ</label>
                                        <input type="password" class="form-control" name="oldpassword">
                                    </div>
                                    <div class="mb-3">
                                        <label for="newpassword" class="form-label">Mật khẩu mới</label>
                                        <input type="password" class="form-control" name="newpassword">
                                    </div>
                                    <div class="mb-3">
                                        <label for="newpassword2" class="form-label">Nhập lại mật khẩu mới</label>
                                        <input type="password" class="form-control" name="newpassword2">
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="xacnhanthaydoithongtin">Thay đổi thông tin</button>
                                       
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include('template/footer.php') ?>
            </div>
            <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
        </div>
        <?php
        if (isset($_POST['xacnhanthaydoithongtin'])) {
            $email = mysqli_real_escape_string($connect, $_POST['email']); // gán email = email trong form
            $username = mysqli_real_escape_string($connect, $_POST['username']); // gán username = username trong form
            $oldpassword = $_POST['oldpassword'];
            $newpassword = md5($_POST['newpassword']);
            $newpassword2 = md5($_POST['newpassword2']);
            $changeusername = false;
            $changemail = false;
            $changpassword = false;
            if ($username != "") { // neu username ma khong bi bo trong 
                $sqlcheckuser = "SELECT * FROM `users` WHERE `username` = '" . $username . "'"; // SQL lấy email và pw từ DB
                $results = $connect->query($sqlcheckuser); // chạy câu lệnh SQL và lấy kết quả 
                if ($results->num_rows > 0) { // đếm số dòng trùng vs thông tin câu lệnh trên. Nếu > 0 => thông tin tồn tại
                    $_SESSION['khongthanhcong'] = "Tên tài khoản tồn tại.";
                    echo '<meta http-equiv="refresh" content="0;URL=profile.php">';
                } else {
                    $connect->query("UPDATE `users` SET `username` = '" . $username . "' WHERE `username` = '" . $_SESSION['username'] . "'");
                    $changeusername = true;
                }
            }
            if ($email != "") { // nếu email mà không bị bỏ trống
                $sqlcheckuser = "SELECT * FROM `users` WHERE `email` = '" . $email . "'"; // SQL lấy email và pw từ DB
                $results = $connect->query($sqlcheckuser); // chạy câu lệnh SQL và lấy kết quả 
                if ($results->num_rows > 0) { // đếm số dòng trùng vs thông tin câu lệnh trên. Nếu > 0 => thông tin tồn tại
                    $_SESSION['khongthanhcong'] = "Email tồn tại.";
                    echo '<meta http-equiv="refresh" content="0;URL=profile.php">';
                } else {
                    $connect->query("UPDATE `users` SET `email` = '" . $email . "' WHERE `username` = '" . $_SESSION['username'] . "'");
                    $changemail = true;
                }
            }
            if ($oldpassword != "") { // nếu oldpassword mà không bị bỏ trống
                if ($newpassword != $newpassword2) {
                    $_SESSION['khongthanhcong'] = "Mật khẩu mới và  Xác nhận mật khẩu mới không chính xác.";
                    echo '<meta http-equiv="refresh" content="0;URL=profile.php">';
                } else {
                    $sqlcheckuser = "SELECT * FROM `users` WHERE `email` = '". $_SESSION['email'] ."' AND `password` = '". md5($oldpassword) ."'";
                    $results = $connect->query($sqlcheckuser);
                    if ($results->num_rows > 0) {
                        $connect->query("UPDATE `users` SET `password` = '". $newpassword ."' WHERE `username` = '" . $_SESSION['username'] . "'");
                    }
                    else {
                        $_SESSION['khongthanhcong'] = "Mật khẩu cũ không chính xác";
                        echo '<meta http-equiv="refresh" content="0;URL=profile.php">';
                    }
                }
            }
            if ($changeusername) {
                $_SESSION['username'] = $username;
            }
            if ($changemail) {
                $_SESSION['email'] = $email;
            }
        }
    } else {
        echo '<script> alert("Bạn chưa đăng nhập")</script>'; // Đưa ra thông báo người dùng chưa đăng nhập 
        echo '<meta http-equiv="refresh" content="0;URL=/profile.php">'; // hiển thị lại thông báo trong 0 giây khi người dùng chưa đăng nhập chuyển về trang login
    }
    ?>
    <?php include('template/scripts.php') ?>
</body>

</html>