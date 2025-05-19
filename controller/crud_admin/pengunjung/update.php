<?php

session_start();
require_once '../../../config/database.php';
if (!isset($_SESSION['username'])) {
    header("Location: ../../auth/login/login_admin.php");
    exit();
}

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = mysqli_query($conn, "SELECT * FROM tb_pengunjung WHERE id_pengunjung = '$id'");
    $row = mysqli_fetch_assoc($query);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $no_telp = $_POST['no_telp'];
    $alamat = $_POST['alamat'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "UPDATE tb_pengunjung SET nama='$nama', email='$email', no_telp='$no_telp', alamat='$alamat', username='$username', password='$password' WHERE id_pengunjung='$id'";
    $user = "UPDATE tb_user SET username='$username', password='$password' WHERE id_user='$id'";

    if (mysqli_query($conn, $query)) {
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
    <title>Edit Pengunjung</title>
</head>
<body class="bg-dark">
    <div class="container d-flex justify-content-center align-items-center min-vh-100 mt-4">
        <div class="card p-4 bg-secondary text-light shadow-sm" style="max-width: 500px; width: 100%;">
            <h2 class="text-center mb-4">Edit Pengunjung</h2>
            <form method="POST">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?=$row['nama']?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?=$row['email']?>" required>
                </div>
                <div class="mb-3">
                    <label for="no_telp" class="form-label">No HP</label>
                    <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?=$row['no_telp']?>" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat" value="<?=$row['alamat']?>" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?=$row['username']?>" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" value="<?=$row['password']?>" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Update Pengunjung</button>
            </form>
        </div>        
    </div>
</body>
</html>