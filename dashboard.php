<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

$result = $conn->query("SELECT * FROM kue");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Dashboard Katalog Kue</h2>
        <a href="logout.php" class="btn btn-danger mb-3">Logout</a>
        <a href="tambah_kue.php" class="btn btn-success mb-3">Tambah Kue</a>
        <div class="row">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="uploads/<?php echo $row['foto']; ?>" class="card-img-top" alt="Foto Kue">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['nama']; ?></h5>
                            <p class="card-text">Harga: Rp <?php echo number_format($row['harga']); ?></p>
                            <p class="card-text">Stok: <?php echo $row['stok']; ?></p>
                            <a href="edit_kue.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a>
                            <a href="hapus_kue.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus?')">Delete</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>