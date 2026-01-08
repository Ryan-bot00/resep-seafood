<?php
session_start();
include '../config/koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
$data = mysqli_fetch_assoc($query);

if ($data && $password == $data['password']) {

    $_SESSION['id_user'] = $data['id_user'];
    $_SESSION['role'] = $data['role'];

    if ($data['role'] == 'admin') {
        header("Location: ../admin/dashboard.php");
    } elseif ($data['role'] == 'petugas') {
        header("Location: ../petugas/dashboard.php");
    } else {
        header("Location: ../pelanggan/dashboard.php");
    }

} else {
    header("Location: login.php?error=1");
}
