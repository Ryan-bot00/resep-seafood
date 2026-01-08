<?php
session_start();
if ($_SESSION['role'] != 'petugas') {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/koneksi.php';

/* SELESAIKAN TRANSAKSI */
if (isset($_GET['selesai'])) {
    $id = $_GET['selesai'];

    $ps = mysqli_fetch_assoc(
        mysqli_query($koneksi, "SELECT id_ps FROM transaksi WHERE id_transaksi='$id'")
    );

    mysqli_query($koneksi, "UPDATE transaksi SET status='selesai' WHERE id_transaksi='$id'");
    mysqli_query($koneksi, "UPDATE playstation SET status='tersedia' WHERE id_ps='".$ps['id_ps']."'");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Transaksi Petugas</title>

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

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #1e293b;
            text-align: center;
        }

        th {
            color: #38bdf8;
        }

        a {
            color: #38bdf8;
            text-decoration: none;
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
    <h1>Transaksi Rental</h1>

    <table>
        <tr>
            <th>No</th>
            <th>Pelanggan</th>
            <th>PlayStation</th>
            <th>Lama</th>
            <th>Total</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;
        $data = mysqli_query($koneksi, "
            SELECT t.*, p.nama, ps.nama_ps
            FROM transaksi t
            JOIN pelanggan p ON t.id_pelanggan=p.id_pelanggan
            JOIN playstation ps ON t.id_ps=ps.id_ps
        ");
        while ($row = mysqli_fetch_assoc($data)) {
        ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $row['nama']; ?></td>
            <td><?= $row['nama_ps']; ?></td>
            <td><?= $row['lama_sewa']; ?> Hari</td>
            <td>Rp <?= number_format($row['total_harga']); ?></td>
            <td><?= $row['status']; ?></td>
            <td>
                <?php if ($row['status'] == 'aktif') { ?>
                    <a href="?selesai=<?= $row['id_transaksi']; ?>">Selesaikan</a>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
