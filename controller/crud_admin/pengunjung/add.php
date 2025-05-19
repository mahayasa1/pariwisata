<?php

session_start();
require_once '../../../config/database.php';
if (!isset($_SESSION['username'])) {
    header("Location: ../../auth/login/login_admin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $no_telp = $_POST['no_telp'];
    $alamat = $_POST['alamat'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "INSERT INTO tb_pengunjung (nama, email, no_telp, alamat, username, password) VALUES ('$nama', '$email', '$no_telp', '$alamat', '$username', '$password')";
    $user = "INSERT INTO tb_user (username, password, level) VALUES ('$username', '$password', 'pengunjung')";

    if (mysqli_query($conn, $query) && mysqli_query($conn, $user)) {
        header("Location: ../../../view/admin/pengunjung.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Add Pengunjung</title>
</head>

<body class="bg-dark">
    <div class="container d-flex justify-content-center align-items-center min-vh-100 mt-4">
        <div class="card p-4 bg-secondary text-light shadow-sm" style="max-width: 500px; width: 100%;">
            <h2 class="text-center mb-4">Add New Pengunjung</h2>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="no_telp" class="form-label">No HP</label>
                    <input type="text" class="form-control" id="no_telp" name="no_telp" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Add Pengunjung</button>
            </form>
        </div>
    </div>
</body>
</html>