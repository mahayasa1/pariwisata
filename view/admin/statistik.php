<?php
session_start();
include_once "../../config/database.php";

if (!isset($_SESSION['username'])) {
    header("Location: ../../controller/auth/login/login_admin.php");
    exit();
}

// Inisialisasi variabel
$labelsHarian = [];
$dataHarianPerTempat = [];

$labelsBulanan = [];
$dataBulananPerTempat = [];

// Query Harian
$qHarian = $conn->query("SELECT tanggal, tempat_wisata.nama_tempat, SUM(tb_pemesanan.jumlah_tiket) AS total FROM tb_pemesanan JOIN tempat_wisata ON tb_pemesanan.id_tempat = tempat_wisata.id_tempat GROUP BY tanggal, tb_pemesanan.id_tempat ORDER BY tanggal ASC");

while ($row = $qHarian->fetch_assoc()) {
    $tanggal = $row['tanggal'];
    $nama_tempat = $row['nama_tempat'];
    $total = (int) $row['total'];

    if (!in_array($tanggal, $labelsHarian)) {
        $labelsHarian[] = $tanggal;
    }

    $dataHarianPerTempat[$nama_tempat][$tanggal] = $total;
}

// Query Bulanan
$qBulanan = $conn->query("SELECT DATE_FORMAT(tanggal, '%Y-%m') AS bulan, tempat_wisata.nama_tempat, SUM(tb_pemesanan.jumlah_tiket) AS total FROM tb_pemesanan JOIN tempat_wisata ON tb_pemesanan.id_tempat = tempat_wisata.id_tempat GROUP BY bulan, tb_pemesanan.id_tempat ORDER BY bulan ASC");

while ($row = $qBulanan->fetch_assoc()) {
    $bulan = $row['bulan'];
    $nama_tempat = $row['nama_tempat'];
    $total = (int) $row['total'];

    if (!in_array($bulan, $labelsBulanan)) {
        $labelsBulanan[] = $bulan;
    }

    $dataBulananPerTempat[$nama_tempat][$bulan] = $total;
}

// Format data Chart.js
$datasetsHarian = [];
foreach ($dataHarianPerTempat as $namaTempat => $data) {
    $row = [];
    foreach ($labelsHarian as $tgl) {
        $row[] = $data[$tgl] ?? 0;
    }
    $datasetsHarian[] = [
        'label' => $namaTempat,
        'data' => $row,
        'backgroundColor' => 'rgba('.rand(0,255).','.rand(0,255).','.rand(0,255).',0.5)'
    ];
}

$datasetsBulanan = [];
foreach ($dataBulananPerTempat as $namaTempat => $data) {
    $row = [];
    foreach ($labelsBulanan as $bln) {
        $row[] = $data[$bln] ?? 0;
    }
    $datasetsBulanan[] = [
        'label' => $namaTempat,
        'data' => $row,
        'fill' => true,
        'borderColor' => 'rgba('.rand(0,255).','.rand(0,255).','.rand(0,255).',1)',
        'backgroundColor' => 'rgba(255, 206, 86, 0.2)',
        'tension' => 0.3
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Statistik Pengunjung per Tempat Wisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="#">DIBALI</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="destinasi.php">Destinasi</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">User</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="user.php">User</a></li>
                        <li><a class="dropdown-item" href="pengunjung.php">Pengunjung</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="transaksi.php">Transaksi</a></li>
                <li class="nav-item"><a class="nav-link" href="booking.php">Booking</a></li>
                <li class="nav-item"><a class="nav-link" href="berita.php">Berita</a></li>
                <li class="nav-item"><a class="nav-link active" href="statistik.php">Statistik</a></li>
            </ul>
            <div class="d-flex">
                <span class="navbar-text text-white me-3"><?php echo $_SESSION['username']; ?></span>
                <form action="../../controller/auth/logout/logout_admin.php" method="post">
                    <button type="submit" name="logout" class="btn btn-outline-light">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="mb-4">📊 Statistik Pengunjung per Tempat Wisata</h2>
    <a href="excel.php" class="btn btn-success mb-3">📤 Export ke Excel</a>

    <!-- Statistik Harian -->
    <h4 class="mt-5">📅 Statistik Harian</h4>
    <canvas id="chartHarian" height="100"></canvas>
    <table class="table table-bordered">
        <thead>
        <tr><th>Tanggal</th><th>Tempat Wisata</th><th>Total Pengunjung</th></tr>
        </thead>
        <tbody>
        <?php
        $harian = $conn->query("SELECT tanggal, tempat_wisata.nama_tempat, SUM(tb_pemesanan.jumlah_tiket) AS total FROM tb_pemesanan JOIN tempat_wisata ON tb_pemesanan.id_tempat = tempat_wisata.id_tempat GROUP BY tanggal, tb_pemesanan.id_tempat ORDER BY tanggal DESC, tempat_wisata.nama_tempat ASC");
        while ($row = $harian->fetch_assoc()) {
            echo "<tr><td>{$row['tanggal']}</td><td>{$row['nama_tempat']}</td><td>{$row['total']}</td></tr>";
        }
        ?>
        </tbody>
    </table>

    <!-- Statistik Bulanan -->
    <h4 class="mt-5">🗓️ Statistik Bulanan</h4>
    <canvas id="chartBulanan" height="100"></canvas>
    <table class="table table-bordered">
        <thead>
        <tr><th>Bulan</th><th>Tempat Wisata</th><th>Total Pengunjung</th></tr>
        </thead>
        <tbody>
        <?php
        $bulanan = $conn->query("SELECT DATE_FORMAT(tanggal, '%Y-%m') AS bulan, tempat_wisata.nama_tempat, SUM(tb_pemesanan.jumlah_tiket) AS total FROM tb_pemesanan JOIN tempat_wisata ON tb_pemesanan.id_tempat = tempat_wisata.id_tempat GROUP BY bulan, tb_pemesanan.id_tempat ORDER BY bulan DESC, tempat_wisata.nama_tempat ASC");
        while ($row = $bulanan->fetch_assoc()) {
            echo "<tr><td>{$row['bulan']}</td><td>{$row['nama_tempat']}</td><td>{$row['total']}</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>

<script>
const labelsHarian = <?= json_encode($labelsHarian) ?>;
const datasetsHarian = <?= json_encode($datasetsHarian) ?>;
const labelsBulanan = <?= json_encode($labelsBulanan) ?>;
const datasetsBulanan = <?= json_encode($datasetsBulanan) ?>;

const ctxHarian = document.getElementById('chartHarian').getContext('2d');
new Chart(ctxHarian, {
    type: 'bar',
    data: {
        labels: labelsHarian,
        datasets: datasetsHarian
    },
    options: {
        responsive: true,
        plugins: {
            title: { display: true, text: 'Statistik Harian Pengunjung' },
            legend: { position: 'top' }
        }
    }
});

const ctxBulanan = document.getElementById('chartBulanan').getContext('2d');
new Chart(ctxBulanan, {
    type: 'line',
    data: {
        labels: labelsBulanan,
        datasets: datasetsBulanan
    },
    options: {
        responsive: true,
        plugins: {
            title: { display: true, text: 'Statistik Bulanan Pengunjung' },
            legend: { position: 'top' }
        }
    }
});
</script>

</body>
</html>
