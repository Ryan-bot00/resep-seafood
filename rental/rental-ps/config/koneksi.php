<?php
$koneksi = mysqli_connect("localhost", "root", "", "rental_playstation");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
