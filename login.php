<?php
include("connect.php");
include("sessions.php");
include("config.php")
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('template/header.php') ?>
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <?php
        if (isset($_SESSION['dangnhapthanhcong']) || isset($_COOKIE['rememberme'])) {
            echo '<meta http-equiv="refresh" content="0;URL=index.php">';
        } else {
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

                            <form name="formdangnhap" method="POST" action="login.php">
                                <div class="form-floating mb-3">
                                    <input name="email" type="email" class="form-control" id="floatingInput"
                                        placeholder="name@gmail.com">
                                    <label for="floatingInput">Email</label>
                                </div>
                                <div class="form-floating mb-4">
                                    <input name="password" type="password" class="form-control" id="floatingPassword"
                                        placeholder="Password">
                                    <label for="floatingPassword">Password</label>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div class="form-check">
                                        <input name="rememberme" type="checkbox" class="form-check-input">
                                        <label class="form-check-label" for="exampleCheck1">Ghi nhớ tài khoản</label>
                                    </div>
                                    <a href="">Quên mật khẩu</a>
                                </div>
                                <button name="tienhanhdangnhap" type="submit" class="btn btn-primary py-3 w-100 mb-4">Đăng
                                    nhập</button>
                                <p class="text-center mb-0">Có phải bạn chưa có Tài khoản? <a href="/signup.php">Đăng ký</a>
                                </p>
                            </form>
                            <a href="<?= $login_url ?>">Login with Google</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        // login with account sign up
        if (isset($_POST['tienhanhdangnhap'])) { // kiểm tra nút đăng nhập đã được bấm
            $email = mysqli_real_escape_string($connect, $_POST['email']); // gán email = email trong form
            $password = md5($_POST['password']); // gán pw = pw trong form
            $rememberme = $_POST['rememberme'];
            $sqlcheckuser = "SELECT * FROM `users` WHERE `email` = '" . $email . "' AND `password` = '" . $password . "'"; // SQL lấy email và pw từ DB
            $results = $connect->query($sqlcheckuser); // chạy câu lệnh SQL và lấy kết quả 
            if ($results->num_rows > 0) { // đếm số dòng trùng vs thông tin câu lệnh trên. Nếu > 0 => thông tin tồn tại
                $user = $results->fetch_array(); // nạp thông tin vào mảng với từng key là thành cột trong bảng DB
                $_SESSION['dangnhapthanhcong'] = "OK"; // Gán biến session đăngnhậpthànhcông để hiểu là đăng nhập thành công
                $_SESSION['username'] = $user['username']; // Gán biến session username để máy hiểu tên người sử dụng
                $_SESSION['email'] = $user['email']; // Gán biến session email để hiểu là email
                if (isset($rememberme)) {
                    setcookie("rememberme", $email, time() + 3600);
                }
                echo '<meta http-equiv="refresh" content="0;URL=index.php">';
            } else { // Nếu mặt khẩu không chính xác thông báo cho người dùng
                $_SESSION['khongthanhcong'] = "Mật khẩu hoặc tên tài khoản không chính xác.";
                echo '<meta http-equiv="refresh" content="0;URL=login.php">';
            }
        }
        // login with googel account
        if (isset($_GET['code'])) {
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
            if (isset($token['error'])) { // check token 
                echo '<meta http-equiv="refresh" content="0;URL=login.php">';
                exit;
            }
            $_SESSION['token'] = $token;
            # Fetching the user data from the google account
            $client->setAccessToken($token);
            $google_oauth = new Google_Service_Oauth2($client);
            $user_info = $google_oauth->userinfo->get();

            $google_id = trim($user_info['id']);
            $l_name = trim($user_info['family_name']);
            $email = trim($user_info['email']);

            # Checking whether the email already exists in our database.
            $check_email = $connect->query("SELECT `email` FROM `users` WHERE `email`= '" . $email . "'");
            if ($check_email->num_rows == 0) {
                # Inserting the new user into the database
                $connect->query("INSERT INTO `users` (`username`, `email`) VALUES ('" . $l_name . "','" . $email . "')");
                $_SESSION['username'] = $l_name;
                $_SESSION['email'] = $email;
                $_SESSION['dangnhapthanhcong'] = "OK";
            } else {
                $_SESSION['username'] = $l_name;
                $_SESSION['email'] = $email;
                $_SESSION['dangnhapthanhcong'] = "OK";
            }
            echo '<meta http-equiv="refresh" content="0;URL=index.php">';
            exit;
        }
        ?>
        <?php include('template/scripts.php') ?>

</body>

</html>