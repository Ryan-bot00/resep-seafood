<?php
session_start();
if ($_SESSION['role'] != 'pelanggan') {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar PlayStation</title>

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
            margin-bottom: 20px;
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

        .status-tersedia {
            color: #22c55e;
        }

        .status-disewa {
            color: #ef4444;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>PELANGGAN</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="playstation.php">Daftar PlayStation</a>
    <a href="../auth/logout.php">Logout</a>
</div>

<div class="content">
    <h1>Daftar PlayStation</h1>

    <table>
        <tr>
            <th>No</th>
            <th>Nama PS</th>
            <th>Tipe</th>
            <th>Harga / Hari</th>
            <th>Status</th>
        </tr>

        <?php
        $no = 1;
        $data = mysqli_query($koneksi, "SELECT * FROM playstation");
        while ($row = mysqli_fetch_assoc($data)) {
        ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $row['nama_ps']; ?></td>
            <td><?= $row['tipe_ps']; ?></td>
            <td>Rp <?= number_format($row['harga_sewa']); ?></td>
            <td class="<?= $row['status']=='tersedia'?'status-tersedia':'status-disewa'; ?>">
                <?= ucfirst($row['status']); ?>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
