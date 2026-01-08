<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/koneksi.php';

/* TAMBAH DATA */
if (isset($_POST['tambah'])) {
    $nama   = $_POST['nama'];
    $no_hp  = $_POST['no_hp'];
    $alamat = $_POST['alamat'];

    mysqli_query($koneksi, "INSERT INTO pelanggan (nama, no_hp, alamat)
        VALUES ('$nama','$no_hp','$alamat')");
}

/* HAPUS DATA */
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM pelanggan WHERE id_pelanggan='$id'");
}

/* AMBIL DATA EDIT */
$edit = false;
if (isset($_GET['edit'])) {
    $edit = true;
    $id = $_GET['edit'];
    $data_edit = mysqli_fetch_assoc(
        mysqli_query($koneksi, "SELECT * FROM pelanggan WHERE id_pelanggan='$id'")
    );
}

/* UPDATE DATA */
if (isset($_POST['update'])) {
    $id     = $_POST['id_pelanggan'];
    $nama   = $_POST['nama'];
    $no_hp  = $_POST['no_hp'];
    $alamat = $_POST['alamat'];

    mysqli_query($koneksi, "UPDATE pelanggan SET
        nama='$nama',
        no_hp='$no_hp',
        alamat='$alamat'
        WHERE id_pelanggan='$id'");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pelanggan | Admin</title>

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

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            background: #020617;
            border: 1px solid #1e293b;
            border-radius: 8px;
            color: #e5e7eb;
        }

        textarea {
            resize: none;
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
    <h1>Data Pelanggan</h1>

    <div class="box">
        <form method="POST">
            <?php if ($edit) { ?>
                <input type="hidden" name="id_pelanggan" value="<?= $data_edit['id_pelanggan']; ?>">
            <?php } ?>

            <input type="text" name="nama" placeholder="Nama Pelanggan" required
                value="<?= $edit ? $data_edit['nama'] : ''; ?>">

            <input type="text" name="no_hp" placeholder="Nomor HP"
                value="<?= $edit ? $data_edit['no_hp'] : ''; ?>">

            <textarea name="alamat" placeholder="Alamat"><?= $edit ? $data_edit['alamat'] : ''; ?></textarea>

            <button type="submit" name="<?= $edit ? 'update' : 'tambah'; ?>">
                <?= $edit ? 'Update Data' : 'Tambah Data'; ?>
            </button>
        </form>
    </div>

    <div class="box">
        <table>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>No HP</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>

            <?php
            $no = 1;
            $data = mysqli_query($koneksi, "SELECT * FROM pelanggan");
            while ($row = mysqli_fetch_assoc($data)) {
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['nama']; ?></td>
                <td><?= $row['no_hp']; ?></td>
                <td><?= $row['alamat']; ?></td>
                <td class="aksi">
                    <a href="?edit=<?= $row['id_pelanggan']; ?>">Edit</a> |
                    <a href="?hapus=<?= $row['id_pelanggan']; ?>" onclick="return confirm('Hapus data?')">
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
