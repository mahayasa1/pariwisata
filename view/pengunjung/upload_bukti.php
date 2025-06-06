<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['username']) || $_SESSION['level'] !== 'pengunjung') {
    echo "<script>alert('Akses ditolak!'); window.location='../../auth/login_pengunjung.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pemesanan = $_POST['id_pemesanan'] ?? null;

    if (!$id_pemesanan || !isset($_FILES['bukti'])) {
        echo "<script>alert('Data tidak lengkap!'); window.location='transaksi.php';</script>";
        exit;
    }

    // Upload gambar bukti
    $folder = "../../assets/img/bukti/";
    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    $file = $_FILES['bukti'];
    $nama_file = time() . '_' . basename($file['name']);
    $target_path = $folder . $nama_file;

    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        // Update ke tabel transaksi
        $update = mysqli_query($conn, "
            UPDATE tb_transaksi 
            SET bukti_pembayaran = '$nama_file', status = 'menunggu verifikasi'
            WHERE id_pemesanan = $id_pemesanan
        ");

        if ($update) {
            echo "<script>alert('Bukti berhasil dikirim! Menunggu verifikasi.'); window.location='riwayat_pesanan.php';</script>";
            exit;
        } else {
            echo "<script>alert('Gagal menyimpan ke database.'); window.location='transaksi.php';</script>";
        }
    } else {
        echo "<script>alert('Gagal mengupload bukti pembayaran.'); window.location='transaksi.php';</script>";
    }
}
?>
