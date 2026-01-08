
<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
include '../config/koneksi.php';

$total_ps = mysqli_fetch_row(
    mysqli_query($koneksi, "SELECT COUNT(*) FROM playstation")
)[0];

$ps_tersedia = mysqli_fetch_row(
    mysqli_query($koneksi, "SELECT COUNT(*) FROM playstation WHERE status='tersedia'")
)[0];

$ps_disewa = mysqli_fetch_row(
    mysqli_query($koneksi, "SELECT COUNT(*) FROM playstation WHERE status='disewa'")
)[0];

$total_pelanggan = mysqli_fetch_row(
    mysqli_query($koneksi, "SELECT COUNT(*) FROM pelanggan")
)[0];

$transaksi_aktif = mysqli_fetch_row(
    mysqli_query($koneksi, "SELECT COUNT(*) FROM transaksi WHERE status='aktif'")
)[0];

$pendapatan = mysqli_fetch_row(
    mysqli_query($koneksi, "SELECT SUM(total_harga) FROM transaksi WHERE tanggal_sewa = CURDATE()")
)[0];

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin | Rental PS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&family=Poppins&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: #020617;
            color: #e5e7eb;
            display: flex;
        }

        .sidebar {
            width: 240px;
            background: #020617;
            border-right: 1px solid #1e293b;
            padding: 30px 20px;
        }

        .sidebar h2 {
            font-family: 'Orbitron', sans-serif;
            color: #38bdf8;
            text-align: center;
            margin-bottom: 40px;
        }

        .sidebar a {
            display: block;
            color: #cbd5f5;
            text-decoration: none;
            padding: 12px 15px;
            border-radius: 10px;
            margin-bottom: 10px;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background: #1e293b;
            color: #38bdf8;
        }

        .content {
            flex: 1;
            padding: 30px;
        }

        .header {
            font-size: 22px;
            margin-bottom: 30px;
            font-family: 'Orbitron', sans-serif;
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
            font-family: 'Orbitron', sans-serif;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>RENTAL PS</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="playstation.php">Data PlayStation</a>
    <a href="pelanggan.php">Data Pelanggan</a>
    <a href="transaksi.php">Transaksi</a>
    <a href="../auth/logout.php">Logout</a>
</div>

<div class="content">
    <div class="header">Dashboard Admin</div>

    <div class="cards">
        <div class="card">
    <h3>Total PlayStation</h3>
    <span><?= $total_ps ?></span>
</div>

<div class="card">
    <h3>Total Pelanggan</h3>
    <span><?= $total_pelanggan ?></span>
</div>

<div class="card">
    <h3>Transaksi Aktif</h3>
    <span><?= $transaksi_aktif ?></span>
</div>

<div class="card">
    <h3>Total Pendapatan</h3>
    <span>Rp <?= number_format($pendapatan ?? 0) ?></span>
</div>
        </div>
    </div>
</div>

</body>
</html>
