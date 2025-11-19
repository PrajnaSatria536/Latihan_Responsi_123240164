<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM kue WHERE id = $id");
$kue = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $foto_lama = $kue['foto'];

    if ($_FILES['foto']['name']) {
        $foto = $_FILES['foto']['name'];
        $foto_tmp = $_FILES['foto']['tmp_name'];
        $foto_unique = time() . '_' . $foto;
        move_uploaded_file($foto_tmp, 'uploads/' . $foto_unique);
        unlink('uploads/' . $foto_lama);
    } else {
        $foto_unique = $foto_lama;
    }

    $stmt = $conn->prepare("UPDATE kue SET nama = ?, harga = ?, stok = ?, foto = ? WHERE id = ?");
    $stmt->bind_param("siisi", $nama, $harga, $stok, $foto_unique, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kue</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Kue</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Nama Kue</label>
                <input type="text" name="nama" value="<?php echo $kue['nama']; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Harga</label>
                <input type="number" name="harga" value="<?php echo $kue['harga']; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Stok</label>
                <input type="number" name="stok" value="<?php echo $kue['stok']; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Foto (Biarkan kosong jika tidak diganti)</label>
                <input type="file" name="foto" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>