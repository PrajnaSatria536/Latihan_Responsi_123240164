<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $foto = $_FILES['foto']['name'];
    $foto_tmp = $_FILES['foto']['tmp_name'];
    $foto_unique = time() . '_' . $foto;
    move_uploaded_file($foto_tmp, 'uploads/' . $foto_unique);

    $stmt = $conn->prepare("INSERT INTO kue (nama, harga, stok, foto) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siis", $nama, $harga, $stok, $foto_unique);
    $stmt->execute();
    $stmt->close();
    header("Location: dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Kue</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Tambah Kue</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Nama Kue</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Harga</label>
                <input type="number" name="harga" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Stok</label>
                <input type="number" name="stok" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Foto</label>
                <input type="file" name="foto" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah</button>
            <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>