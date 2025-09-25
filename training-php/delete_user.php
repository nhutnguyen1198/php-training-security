<?php
require_once 'models/UserModel.php';
session_start();
$userModel = new UserModel();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kiểm tra CSRF token
    if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        exit('CSRF token không hợp lệ!');
    }
    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
        $userModel->deleteUserById($id);
    }
}
header('location: list_users.php');
exit;
?>
