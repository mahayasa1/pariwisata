<?php
include '../../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = mysqli_real_escape_string($conn, $_POST['nama']);
    $alamat   = mysqli_real_escape_string($conn, $_POST['alamat']);
    $no_telp  = mysqli_real_escape_string($conn, $_POST['no_telp']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Gunakan transaksi untuk memastikan data masuk ke dua tabel
    mysqli_begin_transaction($conn);

    try {
        // Simpan ke tabel tb_pengunjung
        $query1 = mysqli_query($conn, "INSERT INTO tb_pengunjung (nama, alamat, no_telp, email, username, password)
        VALUES ('$nama', '$alamat', '$no_telp', '$email', '$username', '$password')");

        // Simpan ke tabel tb_user
        $query2 = mysqli_query($conn, "INSERT INTO tb_user (username, password, level)
        VALUES ('$username', '$password', 'pengunjung')");

        if ($query1 && $query2) {
            mysqli_commit($conn);
            echo "<script>alert('Pendaftaran berhasil!'); window.location='../login/login_pengunjung.php';</script>";
        } else {
            throw new Exception("Gagal insert ke salah satu tabel.");
        }
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "<script>alert('Pendaftaran gagal!'); window.location='register_pengunjung.php';</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Register Pengunjung</title>
</head>

<body class="bg-dark text-white">
    <section class="min-vh-100 d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <form method="POST" action="" class="p-4 bg-dark rounded">
                        <h3 class="fw-normal mb-4 text-center" style="letter-spacing: 1px;">REGISTER PENGUNJUNG</h3>

                        <div class="form-outline mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control form-control-lg" required />
                        </div>

                        <div class="form-outline mb-3">
                            <label class="form-label">Alamat</label>
                            <input type="text" name="alamat" class="form-control form-control-lg" required />
                        </div>

                        <div class="form-outline mb-3">
                            <label class="form-label">No Telepon</label>
                            <input type="text" name="no_telp" class="form-control form-control-lg" required />
                        </div>

                        <div class="form-outline mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control form-control-lg" required />
                        </div>

                        <div class="form-outline mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control form-control-lg" required />
                        </div>

                        <div class="form-outline mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control form-control-lg" required />
                        </div>

                        <div class="d-grid mb-3">
                            <button class="btn btn-info btn-lg" type="submit">Sign Up</button>
                        </div>

                        <p class="text-center">Sudah punya akun? <a href="../login/login_pengunjung.php" class="link-info">Masuk di sini</a></p>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>