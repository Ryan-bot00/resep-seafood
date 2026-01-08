<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/koneksi.php';

/* TAMBAH TRANSAKSI */
if (isset($_POST['tambah'])) {
    $pelanggan = $_POST['id_pelanggan'];
    $ps        = $_POST['id_ps'];
    $tgl       = date('Y-m-d');
    $lama      = $_POST['lama_sewa'];

    $harga_ps = mysqli_fetch_assoc(
        mysqli_query($koneksi, "SELECT harga_sewa FROM playstation WHERE id_ps='$ps'")
    );

    $total = $harga_ps['harga_sewa'] * $lama;

    mysqli_query($koneksi, "INSERT INTO transaksi 
        (id_pelanggan, id_ps, tanggal_sewa, lama_sewa, total_harga, status)
        VALUES ('$pelanggan','$ps','$tgl','$lama','$total','aktif')");

    mysqli_query($koneksi, "UPDATE playstation SET status='disewa' WHERE id_ps='$ps'");
}

/* SELESAIKAN TRANSAKSI */
if (isset($_GET['selesai'])) {
    $id = $_GET['selesai'];

    $ps = mysqli_fetch_assoc(
        mysqli_query($koneksi, "SELECT id_ps FROM transaksi WHERE id_transaksi='$id'")
    );

    mysqli_query($koneksi, "UPDATE transaksi SET status='selesai' WHERE id_transaksi='$id'");
    mysqli_query($koneksi, "UPDATE playstation SET status='tersedia' WHERE id_ps='".$ps['id_ps']."'");
}

/* HAPUS TRANSAKSI */
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM transaksi WHERE id_transaksi='$id'");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Transaksi Rental | Admin</title>

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

        .box {
            background: #020617;
            border: 1px solid #1e293b;
            border-radius: 14px;
            padding: 20px;
            margin-bottom: 30px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            background: #020617;
            border: 1px solid #1e293b;
            border-radius: 8px;
            color: #e5e7eb;
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            background: linear-gradient(135deg,#2563eb,#22d3ee);
            cursor: pointer;
            font-weight: bold;
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

        .aksi a {
            color: #38bdf8;
            text-decoration: none;
            margin: 0 5px;
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
    <h1>Transaksi Rental</h1>

    <div class="box">
        <form method="POST">
            <select name="id_pelanggan" required>
                <option value="">Pilih Pelanggan</option>
                <?php
                $pelanggan = mysqli_query($koneksi, "SELECT * FROM pelanggan");
                while ($p = mysqli_fetch_assoc($pelanggan)) {
                    echo "<option value='{$p['id_pelanggan']}'>{$p['nama']}</option>";
                }
                ?>
            </select>

            <select name="id_ps" required>
                <option value="">Pilih PlayStation</option>
                <?php
                $ps = mysqli_query($koneksi, "SELECT * FROM playstation WHERE status='tersedia'");
                while ($s = mysqli_fetch_assoc($ps)) {
                    echo "<option value='{$s['id_ps']}'>{$s['nama_ps']} ({$s['tipe_ps']})</option>";
                }
                ?>
            </select>

            <input type="number" name="lama_sewa" placeholder="Lama Sewa (Hari)" required>

            <button type="submit" name="tambah">Tambah Transaksi</button>
        </form>
    </div>

    <div class="box">
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
                <td class="aksi">
                    <?php if ($row['status'] == 'aktif') { ?>
                        <a href="?selesai=<?= $row['id_transaksi']; ?>">Selesai</a> |
                    <?php } ?>
                    <a href="?hapus=<?= $row['id_transaksi']; ?>" onclick="return confirm('Hapus transaksi?')">
                        Hapus
                    </a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>

</body>
</html>
