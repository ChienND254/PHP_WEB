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
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <?php
            if(isset($_SESSION['dangnhapthanhcong'])) {
                echo '<meta http-equiv="refresh" content="0;URL=index.php">';
            }
            else {
        ?>
        <?php
            include("template/loading.php"); 
        ?>
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="/" class="">
                                <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>HUS</h3>
                            </a>
                            <h3>Đăng Nhập</h3>
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

                        <form name="formdangnhap" method="POST" action="login.php">
                            <div class="form-floating mb-3">
                                <input name="email" type="email" class="form-control" id="floatingInput" placeholder="name@gmail.com">
                                <label for="floatingInput">Email</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
                                <label for="floatingPassword">Password</label>
                            </div>
                            <button name="tienhanhdangnhap" type="submit" class="btn btn-primary py-3 w-100 mb-4">Đăng nhập</button>
                            <p class="text-center mb-0">Có phải bạn chưa có Tài khoản? <a href="/signup.php">Đăng ký</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
        }
        if (isset($_POST['tienhanhdangnhap'])) { // kiểm tra nút đăng nhập đã được bấm
            $email = mysqli_real_escape_string($connect, $_POST['email']); // gán email = email trong form
            $password = md5($_POST['password']); // gán pw = pw trong form
            $sqlcheckuser = "SELECT * FROM `users` WHERE `email` = '". $email ."' AND `password` = '". $password ."' AND `adminlevel` > 0"; // SQL lấy email và pw từ DB
            $results = $connect -> query($sqlcheckuser); // chạy câu lệnh SQL và lấy kết quả 
            if ($results->num_rows > 0) { // đếm số dòng trùng vs thông tin câu lệnh trên. Nếu > 0 => thông tin tồn tại
                $user = $results->fetch_array(); // nạp thông tin vào mảng với từng key là thành cột trong bảng DB
                $_SESSION['dangnhapthanhcong'] = "OK"; // Gán biến session đăngnhậpthànhcông để hiểu là đăng nhập thành công
                $_SESSION['username'] = $user['username']; // Gán biến session username để máy hiểu tên người sử dụng
                $_SESSION['email'] = $user['email']; // Gán biến session email để hiểu là email
                echo '<meta http-equiv="refresh" content="0;URL=index.php">';
            } else {  // Nếu mặt khẩu không chính xác thông báo cho người dùng
                $_SESSION['khongthanhcong'] = "Mật khẩu hoặc tên tài khoản không chính xác.";
                echo '<meta http-equiv="refresh" content="0;URL=login.php">';
            }
        }   
    ?>
    <?php include('template/scripts.php') ?>
    
</body>

</html>