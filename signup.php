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
                        <form name="formdangky" method="POST" action="signup.php">
                            <div class="form-floating mb-3">
                                <input name="username" type="text" class="form-control" id="floatingText" placeholder="Nguyễn Duy Chiến">
                                <label for="floatingText">Username</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input name="email" type="email" class="form-control" id="floatingInput" placeholder="abc@gmail.com">
                                <label for="floatingInput">Email</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
                                <label for="floatingPassword">Password</label>
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
        if (isset($_POST['dangkytaikhoan'])) { // kiểm tra nút đăng ký tài khoản đã bấm hay chưa
            $username = mysqli_real_escape_string($connect, $_POST['username']);
            $email = mysqli_real_escape_string($connect, $_POST['email']); // gán email = email trong form
            $password = md5($_POST['password']); // gán pw = pw trong form
            $sql = $connect->prepare("INSERT INTO users (username,password, email) VALUES (?,?,?)");
            $sql->bind_param("sss",$username,$password,$email);
            if ($sql -> execute() === TRUE) { 
                echo '<script> alert("Bạn đăng ký thành công")</script>';
            } else {
                echo '<script> alert("Bạn đăng ký chưa thành công")</script>';
            }
        }   
    ?>
    <?php include("template/scripts.php") ?>
</body>

</html>