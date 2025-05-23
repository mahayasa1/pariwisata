<?php

session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../../controller/auth/login/login_admin.php");
    exit();
}

$query = mysqli_query($conn, "SELECT * FROM tempat_wisata");

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Admin</title>
     <style>
    .table-wrapper {
      max-width: 1000px;  /* Sesuaikan lebar sesuai keinginan */
      margin: 50px auto;
    }
    th, td {
      vertical-align: middle !important;
    }
    .table-responsive {
        overflow-x: auto;
    }
  </style>  
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">DIBALI</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="destinasi.php">Destinasi</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                    User
                </a>
                <ul class="dropdown-menu" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="user.php">User</a></li>
                <li><a class="dropdown-item" href="pengunjung.php">Pengunjung</a></li>
                <li><a class="dropdown-item" href="sponsorship.php">Sponsorship</a></li>
            </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="transaksi.php">Transaksi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="booking.php">Booking</a>
            </li>
             <li class="nav-item">
                <a class="nav-link" href="berita.php">Berita</a>
            </li>
            </ul>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search">
                <button class="btn btn-outline-light me-2" type="submit">Search</button>
                <button class="btn btn-outline-light"><a class="text-decoration-none" href="../../controller/auth/logout.php?role=admin">Logout</a></button>
            </form>
            </div>
        </div>
    </nav>

<div class="table-wrapper">
    <h2 class="text-center mb-4">Data Destinasi</h2>
    <a href="../../controller/crud_admin/destinasi/add.php" class="btn btn-primary mb-3">Tambah Destinasi</a>

    <div class="table-responsive">
        <table class="table table-bordered table-striped text-center" style="word-wrap: break-word;">
        <thead class="table-dark">
        <tr>
            <th>No</th>
            <th>Gambar</th>
            <th>Nama Destinasi</th>
            <th>Alamat</th>
            <th>Deskripsi</th>
            <th>Fasilitas</th>
            <th>Harga Tiket</th>
            <th>Jam Buka</th>
            <th>Jam Tutup</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $no = 1;
        while ($row = $query->fetch_assoc()): ?>
            <tr>
                <td><?=$no++?></td>
                <td><img src="../../asset/img/destinasi/<?=$row['gambar']?>" alt="<?=$row['nama_tempat']?>" width="100" height="100" class="img-fluid rounded"></td>
                <td><?=$row['nama_tempat']?></td>   
                <td><?=$row['alamat']?></td>
                <td><?=$row['deskripsi']?></td>
                <td><?=$row['fasilitas']?></td>
                <td>Rp. <?=number_format($row['harga_tiket'],2,',', '.')?></td>
                <td><?=date('H:i', strtotime($row['jam_buka']))?></td>
                <td><?=date('H:i', strtotime($row['jam_tutup']))?></td>
                <td>
                    <a href='../../controller/crud_admin/destinasi/update.php?id=<?=$row['id_tempat']?>' class='btn btn-warning btn-sm mb-2'>Edit</a> <br>
                    <a href='../../controller/crud_admin/destinasi/delete.php?id=<?=$row['id_tempat']?>' class='btn btn-danger btn-sm' onclick="return confirm('Are you sure you want to delete this item?')">Delete</a>
                </td>
                </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>