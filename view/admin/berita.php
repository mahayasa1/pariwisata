<?php

include_once '../../config/database.php';

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../controller/auth/login/login_admin.php");
    exit();
}

$query = mysqli_query($conn, "SELECT * FROM tb_berita ORDER BY tanggal DESC");
$gambar = mysqli_query($conn , "SELECT * FROM tb_gambar")


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Berita</title>
    <style>
        .table-wrapper {
            max-width: 900px;  /* Sesuaikan lebar sesuai keinginan */
            margin: 50px auto;
        }
        th, td {
            vertical-align: middle !important;
        }
    </style>
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" >DIBALI</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="destinasi.php">Destinasi</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            User
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="user.php">User</a></li>
                            <li><a class="dropdown-item" href="pengunjung.php">Pengunjung</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="transaksi.php">Transaksi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="booking.php">Booking</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="berita.php">Berita</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search">
                    <button class="btn btn-outline-light me-2" type="submit">Search</button>
                    <button class="btn btn-outline-light"><a class="text-decoration-none text-white" href="../../controller/auth/logout.php?role=admin">Logout</a></button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Table -->
    <div class="table-wrapper mt-4">
        <h2 class="text-center mb-4">Data Berita</h2>
        <a href="../../controller/crud_admin/berita/add.php" class="btn btn-primary mb-3">Tambah Berita</a>
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Isi</th>
                    <th>Gambar</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1; 
                while ($row = mysqli_fetch_assoc($query)) : 
                    $id_berita = $row['id_berita'];
                    $gambarQuery = mysqli_query($conn, "SELECT * FROM tb_gambar WHERE id_berita = $id_berita");
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row['judul'] ?></td>
                        <td><?= $row['isi'] ?></td>
                        <td>
                            <?php while ($img = mysqli_fetch_assoc($gambarQuery)) : ?>
                                <img src="../../asset/img/berita/<?= $img['gambar'] ?>" alt="gambar" width="100" class="img-thumbnail me-1 mb-1">
                            <?php endwhile; ?>
                        </td>
                        <td><?= date('d M Y', strtotime($row['tanggal'])) ?></td>
                        <td>
                            <a href="../../controller/crud_admin/berita/update.php?id=<?= $row['id_berita'] ?>" class="btn btn-warning btn-sm mb-2">Edit</a>
                            <a href="../../controller/crud_admin/berita/delete.php?id=<?= $row['id_berita'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus berita ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>