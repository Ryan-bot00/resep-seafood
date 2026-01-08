<?php
session_start();
if ($_SESSION['role'] != 'petugas') {
    header("Location: ../auth/login.php");
    exit;
}
include '../config/koneksi.php';

$transaksi_aktif = mysqli_fetch_row(
    mysqli_query($koneksi, "SELECT COUNT(*) FROM transaksi WHERE status='aktif'")
)[0];

$ps_tersedia = mysqli_fetch_row(
    mysqli_query($koneksi, "SELECT COUNT(*) FROM playstation WHERE status='tersedia'")
)[0];

$ps_disewa = mysqli_fetch_row(
    mysqli_query($koneksi, "SELECT COUNT(*) FROM playstation WHERE status='disewa'")
)[0];

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Petugas | Rental PS</title>

    <link href="https://fonts.googleapis.com/css2?family=Orbitron&family=Poppins&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            background: #020617;
            font-family: 'Poppins', sans-serif;
            color: #e5e7eb;
            display: flex;
        }

        .sidebar {
            width: 220px;
            padding: 25px;
            border-right: 1px solid #1e293b;
        }

        .sidebar h2 {
            font-family: 'Orbitron';
            color: #38bdf8;
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            color: #cbd5f5;
            text-decoration: none;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .sidebar a:hover {
            background: #1e293b;
            color: #38bdf8;
        }

        .content {
            flex: 1;
            padding: 30px;
        }

        h1 {
            font-family: 'Orbitron';
            margin-bottom: 30px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .card {
            background: #020617;
            border: 1px solid #1e293b;
            border-radius: 14px;
            padding: 25px;
            box-shadow: 0 0 20px rgba(56,189,248,0.15);
        }

        .card h3 {
            font-size: 14px;
            color: #94a3b8;
            margin-bottom: 10px;
        }

        .card span {
            font-size: 28px;
            color: #38bdf8;
            font-family: 'Orbitron';
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>PETUGAS</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="transaksi.php">Transaksi Rental</a>
    <a href="../auth/logout.php">Logout</a>
</div>

<div class="content">
    <h1>Dashboard Petugas</h1>

<div class="cards">

    <div class="card">
        <h3>Transaksi Aktif</h3>
        <span><?= $transaksi_aktif ?></span>
    </div>

    <div class="card">
        <h3>PlayStation Tersedia</h3>
        <span><?= $ps_tersedia ?></span>
    </div>

    <div class="card">
        <h3>PlayStation Disewa</h3>
        <span><?= $ps_disewa ?></span>
    </div>

</div>
</div>

</body>
</html>
