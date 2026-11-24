
<?php
include "koneksi.php";

// Mengambil data dari formulir
$nama = $_POST['nama_mahasiswa'];
$npm = $_POST['npm'];
$kelas = $_POST['kelas'];
$status = $_POST['status_kehadiran'];

// Mengambil data foto
$nama_foto = $_FILES['bukti_foto']['name'];
$file_tmp = $_FILES['bukti_foto']['tmp_name'];
$ukuran = $_FILES['bukti_foto']['size'];

$ekstensi = strtolower(pathinfo($nama_foto, PATHINFO_EXTENSION));
$ekstensi_diizinkan = ['jpg', 'jpeg', 'png'];

if (!in_array($ekstensi, $ekstensi_diizinkan)) {
    die("Format foto harus JPG, JPEG, atau PNG.");
}

if ($ukuran > 5 * 1024 * 1024) {
    die("Ukuran foto maksimal 5 MB.");
}

if (!getimagesize($file_tmp)) {
    die("File yang diunggah bukan gambar.");
}

// Membuat nama foto unik
$foto_baru = uniqid('absensi_') . '.' . $ekstensi;
$tujuan = "gambar/" . $foto_baru;

// Memindahkan foto ke folder gambar
if (move_uploaded_file($file_tmp, $tujuan)) {

    // Menyimpan data ke database
    $query = "INSERT INTO absensi_ukri
              (nama_mahasiswa, npm, kelas, status_kehadiran, bukti_foto)
              VALUES (?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($koneksi, $query);

    mysqli_stmt_bind_param(
        $stmt,
        "sssss",
        $nama,
        $npm,
        $kelas,
        $status,
        $foto_baru
    );

    if (mysqli_stmt_execute($stmt)) {
        header("Location: daftar_absensi.php");
        exit;
    } else {
        if (file_exists($tujuan)) {
            unlink($tujuan);
        }
        echo "Gagal menyimpan data: " . mysqli_error($koneksi);
    }

} else {
    echo "Gagal mengunggah foto.";
}
?>
