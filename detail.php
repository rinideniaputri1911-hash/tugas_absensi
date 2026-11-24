<?php

include 'koneksi.php';

$id = $_GET['id'];

$query = "SELECT * FROM absensi_ukri WHERE id = ?";

$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("Data tidak ditemukan.");
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Absensi</title>
</head>

<body>

<h1>Detail Absensi Mahasiswa</h1>

<p>
    Nama Mahasiswa:
    <?= htmlspecialchars($data['nama_mahasiswa']) ?>
</p>

<p>
    NPM:
    <?= htmlspecialchars($data['npm']) ?>
</p>

<p>
    Kelas:
    <?= htmlspecialchars($data['kelas']) ?>
</p>

<p>
    Status Kehadiran:
    <?= htmlspecialchars($data['status_kehadiran']) ?>
</p>

<p>Bukti Foto:</p>

<?php if ($data['bukti_foto'] != '') { ?>

    <img src="gambar/<?= rawurlencode($data['bukti_foto']) ?>"
         width="200">

<?php } else { ?>

    Tidak ada foto.

<?php } ?>

<br><br>

<a href="daftar_absensi.php">Kembali</a>

</body>
</html>