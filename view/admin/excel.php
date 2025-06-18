<?php
session_start();
include_once "../../config/database.php";

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=statistik_Pemesanan_Tiket.xls");

// Supaya karakter seperti emoji dan huruf spesial tampil benar
echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
?>

<table border="1">
    <thead>
        <tr>
            <th colspan="3" style="background-color:#ddd;">📅 Statistik Harian</th>
        </tr>
        <tr>
            <th>Tanggal</th>
            <th>Tempat Wisata</th>
            <th>Total Pemesanan Tiket</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $harian = $conn->query("SELECT tanggal, tempat_wisata.nama_tempat, SUM(tb_pemesanan.jumlah_tiket) AS total FROM tb_pemesanan JOIN tempat_wisata ON tb_pemesanan.id_tempat = tempat_wisata.id_tempat GROUP BY tanggal, tb_pemesanan.id_tempat ORDER BY tanggal DESC, tempat_wisata.nama_tempat ASC");
        while ($row = $harian->fetch_assoc()):
        ?>
        <tr>
            <td><?= $row['tanggal'] ?></td>
            <td><?= $row['nama_tempat'] ?></td>
            <td><?= $row['total'] ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<br><br>

<table border="1">
    <thead>
        <tr>
            <th colspan="3" style="background-color:#ddd;">🗓️ Statistik Bulanan</th>
        </tr>
        <tr>
            <th>Bulan</th>
            <th>Tempat Wisata</th>
            <th>Total Pemesanan Tiket</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $bulanan = $conn->query("SELECT DATE_FORMAT(tanggal, '%Y-%m') AS bulan, tempat_wisata.nama_tempat, SUM(tb_pemesanan.jumlah_tiket) AS total FROM tb_pemesanan JOIN tempat_wisata ON tb_pemesanan.id_tempat = tempat_wisata.id_tempat GROUP BY bulan, tb_pemesanan.id_tempat ORDER BY bulan DESC, tempat_wisata.nama_tempat ASC");
        while ($row = $bulanan->fetch_assoc()):
        ?>
        <tr>
            <td><?= $row['bulan'] ?></td>
            <td><?= $row['nama_tempat'] ?></td>
            <td><?= $row['total'] ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
