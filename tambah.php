
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Absensi</title>

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

        input:focus, select:focus {
            outline: none;
            border-color: #2563eb;
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
</head>

<body>

<div class="container">

    <h1>Tambah Data Absensi</h1>

    <form action="proses_tambah.php" method="POST"
          enctype="multipart/form-data">

        <label>Nama Mahasiswa</label>
        <input type="text" name="nama_mahasiswa"
               placeholder="Masukkan nama mahasiswa" required>

        <label>NPM</label>
        <input type="text" name="npm"
               placeholder="Masukkan NPM" required>

        <label>Kelas</label>
        <input type="text" name="kelas"
               placeholder="Contoh: 4A" required>

        <label>Status Kehadiran</label>
        <select name="status_kehadiran" required>
            <option value="">-- Pilih Status --</option>
            <option value="Hadir">Hadir</option>
            <option value="Sakit">Sakit</option>
            <option value="Izin">Izin</option>
        </select>

        <label>Bukti Foto (Selfie/Surat)</label>
        <input type="file" name="bukti_foto"
               accept="image/*" required>

        <button type="submit">Simpan Absensi</button>

    </form>

    <a href="daftar_absensi.php" class="kembali">
        ← Kembali ke Daftar Absensi
    </a>

</div>

</body>
</html>
