<?php
include 'koneksi.php';

$cari = $_GET['cari'] ?? '';

if ($cari != '') {

    $keyword = "%$cari%";

    $query = "SELECT * FROM absensi_ukri
              WHERE nama_mahasiswa LIKE ?
              OR npm LIKE ?";

    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("ss", $keyword, $keyword);
    $stmt->execute();

    $result = $stmt->get_result();

} else {

    $query = "SELECT * FROM absensi_ukri ORDER BY id DESC";
    $result = $koneksi->query($query);

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Absensi Mahasiswa UKRI</title>

    <style>
        body {
            font-family: Arial;
            background: #f2f4f8;
            padding: 25px;
        }

        h1 {
            color: #243b64;
        }

        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background: #243b64;
            color: white;
        }

        img {
            width: 80px;
            height: 70px;
            object-fit: cover;
        }

        a {
            text-decoration: none;
        }

        .tambah {
            background: #243b64;
            color: white;
            padding: 10px;
        }

        .search-box {
    margin: 20px 0;
}

.search-form {
    display: flex;
    gap: 10px;
    align-items: center;
    flex-wrap: wrap;
}

.search-form input {
    width: 300px;
    padding: 12px 15px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    font-size: 15px;
}

.search-form button {
    padding: 12px 22px;
    background: #2563eb;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 15px;
}

.search-form button:hover {
    background: #1d4ed8;
}

.reset-btn {
    padding: 12px 18px;
    background: #e2e8f0;
    color: #334155;
    text-decoration: none;
    border-radius: 8px;
}

.reset-btn:hover {
    background: #cbd5e1;
}
    </style>
</head>

<body>

<div class="container">

    <h1>Sistem Absensi Mahasiswa UKRI</h1>

    <p>Program Studi Sistem Informasi</p>

    <a class="tambah" href="tambah.php">
        + Tambah Absensi
    </a>

    <br><br>

    <form method="GET" class="search-form">
        <input
            type="text"
            name="cari"
            placeholder="Cari nama atau NPM..."
            value="<?php echo isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : ''; ?>"
        >

        <button type="submit">Cari</button>
        <a href="daftar_absensi.php" class="reset-btn">Reset</a>
    </form>
</div>

    <table>

        <tr>
            <th>No</th>
            <th>NPM</th>
            <th>Nama Mahasiswa</th>
            <th>Kelas</th>
            <th>Status</th>
            <th>Bukti Foto</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;

        while ($data = $result->fetch_assoc()) {
        ?>

        <tr>

            <td><?= $no++ ?></td>

            <td><?= htmlspecialchars($data['npm']) ?></td>

            <td><?= htmlspecialchars($data['nama_mahasiswa']) ?></td>

            <td><?= htmlspecialchars($data['kelas']) ?></td>

            <td><?= htmlspecialchars($data['status_kehadiran']) ?></td>

            <td>
                <?php if ($data['bukti_foto'] != '') { ?>
                    <img src="gambar/<?= rawurlencode($data['bukti_foto']) ?>">
                <?php } else { ?>
                    Tidak ada foto
                <?php } ?>
            </td>

            <td>
                <a href="detail.php?id=<?= $data['id'] ?>">Detail</a> |

                <a href="edit.php?id=<?= $data['id'] ?>">Edit</a> |

                <a href="hapus.php?id=<?= $data['id'] ?>"
                   onclick="return confirm('Yakin ingin menghapus?')">
                   Hapus
                </a>
            </td>

        </tr>

        <?php } ?>

    </table>

</div>

</body>
</html>

<?php
if (isset($stmt)) {
    $stmt->close();
}
?>