<?php

include 'koneksi.php';

$id = $_GET['id'];

// Mengambil nama foto
$query = "SELECT bukti_foto FROM absensi_ukri WHERE id = ?";

$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$data = $result->fetch_assoc();

$stmt->close();

if (!$data) {
    die("Data tidak ditemukan.");
}

// Menghapus data dari database
$query_hapus = "DELETE FROM absensi_ukri WHERE id = ?";

$stmt_hapus = $koneksi->prepare($query_hapus);
$stmt_hapus->bind_param("i", $id);

if ($stmt_hapus->execute()) {

    // Menghapus file foto
    if (!empty($data['bukti_foto'])) {

        $foto = 'gambar/' . $data['bukti_foto'];

        if (file_exists($foto)) {
            unlink($foto);
        }

    }

    echo "<script>
        alert('Data berhasil dihapus!');
        window.location='daftar_absensi.php';
    </script>";

} else {

    echo "Gagal menghapus data.";

}

$stmt_hapus->close();

?>