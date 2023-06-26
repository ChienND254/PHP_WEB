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
        if(isset($_SESSION['dangnhapthanhcong']) || isset($_COOKIE["rememberme"])) { // kiểm tra xem đã đăng nhập có chạy đoạn code ở dưới
    ?>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <?php include("template/loading.php"); ?>
        <?php include('template/sidebar.php') ?>
        <div class="content">
            <?php include('template/navbar.php') ?>
            <?php include('template/content.php') ?>
            <?php include('template/footer.php') ?>
        </div>
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>
    <?php
        } else {
            echo '<script> alert("Bạn chưa đăng nhập")</script>'; // Đưa ra thông báo người dùng chưa đăng nhập 
            header("Refresh: 0; url=/login.php"); // hiển thị lại thông báo trong 0 giây khi người dùng chưa đăng nhập chuyển về trang login
        }
    ?>
    <?php include('template/scripts.php') ?>
</body>
</html>