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

<style>
    * {
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        background: #f1f5f9;
        margin: 0;
        padding: 40px 15px;
    }

    .container {
        max-width: 500px;
        margin: auto;
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }

    h1 {
        text-align: center;
        color: #1e40af;
        margin-top: 0;
        margin-bottom: 25px;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #334155;
    }

    input, select {
        width: 100%;
        padding: 12px;
        margin-bottom: 20px;
        border: 1px solid #cbd5e1;
        border-radius: 7px;
        font-size: 15px;
    }

    input[type="file"] {
        padding: 8px;
    }

    img {
        max-width: 180px;
        height: auto;
        display: block;
        margin: 10px 0 20px;
        border-radius: 8px;
    }

    button {
        width: 100%;
        padding: 13px;
        background: #2563eb;
        color: white;
        border: none;
        border-radius: 7px;
        font-size: 16px;
        cursor: pointer;
    }

    button:hover {
        background: #1d4ed8;
    }

    .kembali {
        display: block;
        text-align: center;
        margin-top: 18px;
        color: #2563eb;
        text-decoration: none;
    }
</style>
    <title>Edit Absensi</title>
</head>

<body>
<div class="container">

    <!-- Judul dan form edit kamu di sini -->

</div>
<h1>Edit Data Absensi</h1>

<form action="proses_edit.php"
      method="POST"
      enctype="multipart/form-data">

    <input type="hidden"
           name="id"
           value="<?= $data['id'] ?>">

    <label>Nama Mahasiswa</label><br>

    <input type="text"
           name="nama_mahasiswa"
           value="<?= htmlspecialchars($data['nama_mahasiswa']) ?>"
           required>

    <br><br>

    <label>NPM</label><br>

    <input type="text"
           name="npm"
           value="<?= htmlspecialchars($data['npm']) ?>"
           required>

    <br><br>

    <label>Kelas</label><br>

    <input type="text"
           name="kelas"
           value="<?= htmlspecialchars($data['kelas']) ?>"
           required>

    <br><br>

    <label>Status Kehadiran</label><br>

    <select name="status_kehadiran" required>

        <option value="Hadir"
        <?= $data['status_kehadiran'] == 'Hadir' ? 'selected' : '' ?>>
            Hadir
        </option>

        <option value="Sakit"
        <?= $data['status_kehadiran'] == 'Sakit' ? 'selected' : '' ?>>
            Sakit
        </option>

        <option value="Izin"
        <?= $data['status_kehadiran'] == 'Izin' ? 'selected' : '' ?>>
            Izin
        </option>

    </select>

    <br><br>

    <label>Bukti Foto Saat Ini</label><br>

    <?php if (!empty($data['bukti_foto'])) { ?>

        <img src="gambar/<?= rawurlencode($data['bukti_foto']) ?>"
             width="120">

    <?php } ?>

    <br><br>

    <label>Ganti Bukti Foto (Opsional)</label><br>

    <input type="file"
           name="bukti_foto"
           accept=".jpg,.jpeg,.png">

    <br><br>

    <button type="submit">Update Data</button>

    <a href="daftar_absensi.php">Kembali</a>
    ← Kembali ke Daftar Absensi
</a>

</form>

</body>
</html>