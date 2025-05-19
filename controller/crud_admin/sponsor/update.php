<?php

session_start();
require_once '../../../config/database.php';
if (!isset($_SESSION['username'])) {
    header("Location: auth/login/login_admin.php");
    exit();
}
$id = $_GET['id'];
$query = mysqli_query($conn, "DELETE FROM tb_sponsor WHERE id_sponsor = '$id'");
$row = mysqli_fetch_assoc($query);

if($_SERVER['REQUEST_METHOD'] =='POST'){
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $no_telp = $_POST['no_telp'];
    $alamat = $_POST['alamat'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $gambar_lama = $row['gambar'];
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    $error = $_FILES['gambar']['error'];
    $target_dir = "../../../asset/img/sponsor/";
    $target_file = $target_dir . basename($gambar);

    if (move_uploaded_file($tmp, $target_file)) {
        // File uploaded successfully
        if (file_exists($target_dir . $gambar_lama)) {
            unlink($target_dir . $gambar_lama);
        }
        if(move_uploaded_file($tmp, $target_file)){
            $query = "UPDATE tb_sponsor SET nama='$nama', gambar='$gambar', email='$email', no_telp='$no_telp', alamat='$alamat', username='$username', password='$password' WHERE id_sponsor='$id'";
            $user = "UPDATE tb_user SET username='$username', password='$password' WHERE username='$username'";
            if (mysqli_query($conn, $query) && mysqli_query($conn, $user)) {
                header("Location: ../../../view/admin/sponsorship.php");
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "Error uploading file.";
    }
}


?>