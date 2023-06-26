<?php
    $ip_server = 'localhost'; //IP của server MySQL
    $usernameSQL = 'root'; //Username của server MySQL
    $passwordSQL = ''; //Password của server MySQL
    $database = 'web_tuyensinh'; //Tên Database trong MySQL

    $connect = new mysqli($ip_server, $usernameSQL, $passwordSQL, $database); //Kết nối đến MySQL và lấy thông tin MySQL bỏ vào biến $connect
    if ($connect->connect_error) { // Kiểm tra kết nối của code tới MySQL -> Nếu thành công thì echo ra bên dưới đồng thời dừng code ở tại đây luôn
        die('Kết nối ko thành công.');
    }
?>
