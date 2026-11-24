<?php

include 'koneksi.php';

$id = $_POST['id'];
$nama = $_POST['nama_mahasiswa'];
$npm = $_POST['npm'];
$kelas = $_POST['kelas'];
$status = $_POST['status_kehadiran'];

if (!in_array($status, ['Hadir', 'Sakit', 'Izin'], true)) {
    die("Status tidak valid.");
}

// Mengambil foto lama
$query_lama = "SELECT bukti_foto FROM absensi_ukri WHERE id = ?";

$stmt_lama = $koneksi->prepare($query_lama);
$stmt_lama->bind_param("i", $id);
$stmt_lama->execute();

$data_lama = $stmt_lama->get_result()->fetch_assoc();

$stmt_lama->close();

if (!$data_lama) {
    die("Data tidak ditemukan.");
}

$nama_foto = $data_lama['bukti_foto'];
$file_baru = null;

// Mengecek apakah ada foto baru
if ($_FILES['bukti_foto']['error'] !== UPLOAD_ERR_NO_FILE) {

    if ($_FILES['bukti_foto']['error'] !== UPLOAD_ERR_OK) {
        die("Upload foto gagal.");
    }

    $foto = $_FILES['bukti_foto']['name'];
    $file_tmp = $_FILES['bukti_foto']['tmp_name'];

    if ($_FILES['bukti_foto']['size'] > 5 * 1024 * 1024) {
        die("Ukuran foto maksimal 5 MB.");
    }

    $ekstensi = strtolower(
        pathinfo($foto, PATHINFO_EXTENSION)
    );

    if (!in_array($ekstensi, ['jpg', 'jpeg', 'png'], true)
        || !getimagesize($file_tmp)) {
        die("Format foto tidak valid.");
    }

    $nama_foto = bin2hex(random_bytes(8)) . '.' . $ekstensi;

    $file_baru = 'gambar/' . $nama_foto;

    if (!move_uploaded_file($file_tmp, $file_baru)) {
        die("Foto gagal diupload.");
    }

}

// Query UPDATE
$query = "UPDATE absensi_ukri SET
nama_mahasiswa = ?,
npm = ?,
kelas = ?,
status_kehadiran = ?,
bukti_foto = ?
WHERE id = ?";

$stmt = $koneksi->prepare($query);

// s = String, i = Integer
$stmt->bind_param(
    "sssssi",
    $nama,
    $npm,
    $kelas,
    $status,
    $nama_foto,
    $id
);

if ($stmt->execute()) {

    // Menghapus foto lama jika diganti
    if ($file_baru && $data_lama['bukti_foto']) {

        $foto_lama = 'gambar/' . $data_lama['bukti_foto'];

        if (file_exists($foto_lama)) {
            unlink($foto_lama);
        }

    }

    echo "<script>
        alert('Data berhasil diubah!');
        window.location='daftar_absensi.php';
    </script>";

} else {

    if ($file_baru && file_exists($file_baru)) {
        unlink($file_baru);
    }

    echo "Gagal mengubah data: " . $stmt->error;

}

$stmt->close();

?>