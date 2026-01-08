<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/koneksi.php';

/* TAMBAH DATA */
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama_ps'];
    $tipe = $_POST['tipe_ps'];
    $harga = $_POST['harga_sewa'];
    $status = $_POST['status'];

    mysqli_query($koneksi, "INSERT INTO playstation 
        (nama_ps, tipe_ps, harga_sewa, status) 
        VALUES ('$nama','$tipe','$harga','$status')");
}

/* HAPUS DATA */
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM playstation WHERE id_ps='$id'");
}

/* AMBIL DATA UNTUK EDIT */
$edit = false;
if (isset($_GET['edit'])) {
    $edit = true;
    $id = $_GET['edit'];
    $data_edit = mysqli_fetch_assoc(
        mysqli_query($koneksi, "SELECT * FROM playstation WHERE id_ps='$id'")
    );
}

/* UPDATE DATA */
if (isset($_POST['update'])) {
    $id = $_POST['id_ps'];
    $nama = $_POST['nama_ps'];
    $tipe = $_POST['tipe_ps'];
    $harga = $_POST['harga_sewa'];
    $status = $_POST['status'];

    mysqli_query($koneksi, "UPDATE playstation SET
        nama_ps='$nama',
        tipe_ps='$tipe',
        harga_sewa='$harga',
        status='$status'
        WHERE id_ps='$id'");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data PlayStation | Admin</title>

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
    <h1>Data PlayStation</h1>

    <div class="box">
        <form method="POST">
            <?php if ($edit) { ?>
                <input type="hidden" name="id_ps" value="<?= $data_edit['id_ps']; ?>">
            <?php } ?>

            <input type="text" name="nama_ps" placeholder="Nama PlayStation" required
                value="<?= $edit ? $data_edit['nama_ps'] : ''; ?>">

            <input type="text" name="tipe_ps" placeholder="Tipe (PS4 / PS5)"
                value="<?= $edit ? $data_edit['tipe_ps'] : ''; ?>">

            <input type="number" name="harga_sewa" placeholder="Harga Sewa"
                value="<?= $edit ? $data_edit['harga_sewa'] : ''; ?>">

            <select name="status">
                <option value="tersedia">Tersedia</option>
                <option value="disewa" <?= $edit && $data_edit['status']=='disewa'?'selected':''; ?>>
                    Disewa
                </option>
            </select>

            <button type="submit" name="<?= $edit ? 'update' : 'tambah'; ?>">
                <?= $edit ? 'Update Data' : 'Tambah Data'; ?>
            </button>
        </form>
    </div>

    <div class="box">
        <table>
            <tr>
                <th>No</th>
                <th>Nama PS</th>
                <th>Tipe</th>
                <th>Harga</th>
                <th>Status</th>
                <th>Aksi</th>
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
                <td><?= $row['status']; ?></td>
                <td class="aksi">
                    <a href="?edit=<?= $row['id_ps']; ?>">Edit</a> |
                    <a href="?hapus=<?= $row['id_ps']; ?>" onclick="return confirm('Hapus data?')">
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
