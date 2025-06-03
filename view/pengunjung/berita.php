<?php
require_once '../../config/database.php';
session_start();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Berita tidak ditemukan.";
    exit;
}

$id = (int) $_GET['id'];

// Ambil data berita berdasarkan ID
$berita = mysqli_query($conn, "SELECT * FROM tb_berita WHERE id_berita = $id");
$data = mysqli_fetch_assoc($berita);

if (!$data) {
    echo "Berita tidak ditemukan.";
    exit;
}

// Ambil gambar-gambar berita
$gambarQuery = mysqli_query($conn, "SELECT gambar FROM tb_gambar WHERE id_berita = $id");
$gambarList = [];
while ($g = mysqli_fetch_assoc($gambarQuery)) {
    $gambarList[] = $g['gambar'];
}


// Ambil data destinasi yang berelasi dengan berita
$destinasiQuery = mysqli_query($conn, "SELECT tw.* FROM tempat_wisata tw JOIN tb_berita_wisata bw ON tw.id_tempat = bw.id_tempat WHERE bw.id_berita = $id");
$destinasiList = [];
while ($d = mysqli_fetch_assoc($destinasiQuery)) {
    $destinasiList[] = $d;
}

// Ambil berita lainnya
$beritalainnyaquery = mysqli_query($conn, "SELECT * FROM tb_berita WHERE id_berita != $id ORDER BY id_berita DESC LIMIT 5");
$beritalainnya = [];
while ($berita = mysqli_fetch_assoc($beritalainnyaquery)) {
    $beritalainnya[] = $berita;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($data['judul']) ?> - DIBALI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="../../index.php">DIBALI</a>
  </div>
</nav>

<div class="container mt-4">
    <div class="row">
        <div class="col-lg-8">
            <h3 class="fw-bold mb-3"><?= htmlspecialchars($data['judul']) ?></h3>
            
            <!-- Gambar utama atau slideshow -->
            <?php if (!empty($gambarList)): ?>
                <div id="carouselBerita" class="carousel slide mb-3" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php foreach ($gambarList as $index => $img): ?>
                            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                <img src="../../asset/img/berita/<?= htmlspecialchars($img) ?>" class="d-block w-100 rounded" alt="Gambar Berita">
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php if (count($gambarList) > 1): ?>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselBerita" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselBerita" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Isi Berita -->
                        <p class="text-muted">Dipublikasikan: <?= date('d M Y', strtotime($data['tanggal'])) ?></p>
                        <p style="white-space: pre-line;"><?= htmlspecialchars($data['isi']) ?></p>
                        
                        <!-- Destinasi Terkait -->
                        <?php if (!empty($destinasiList)): ?>
                            <hr class="my-4">
                            <h4 class="fw-bold mb-3">Destinasi Terkait:</h4>
                            <div class="row">
                                <?php foreach ($destinasiList as $destinasi): ?>
                                    <div class="col-12 mb-4">
                                        <div class="card-body">
                                            <h1 class="card-title fw-bold mb-3"><?= htmlspecialchars($destinasi['nama_tempat']) ?></h1>
                                            <div class=" h-100 overflow-hidden">
                                                <img src="../../asset/img/destinasi/<?= htmlspecialchars($destinasi['gambar']) ?>" class="card-img-top mb-3" alt="<?= htmlspecialchars($destinasi['nama_tempat']) ?>">
                                                <p class="card-text"><?= substr(strip_tags($destinasi['deskripsi']), 0, 1000000) ?></p>
                                                <?php if (isset($_SESSION['id_pengunjung'])): ?>
                                                    <a href="booking.php?id=<?= $destinasi['id_tempat'] ?>" class="btn btn-primary">Booking</a>
                                                    <?php else: ?>
                                                        <a href="../../controller/auth/login/login_pengunjung.php" class="btn btn-warning">Login untuk Booking</a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                <a href="../../index.php" class="btn btn-secondary mt-4 mb-4">← Kembali ke Beranda</a>
        </div>
        <div class="col-lg-4">
            <h5 class="mb-3">berita Lainnya</h5>
            <?php if(!empty($beritalainnya)): ?>
                <?php foreach ($beritalainnya as $berita): ?>
                        <?php
                            $gambarQuery = mysqli_query($conn, "SELECT gambar FROM tb_gambar WHERE id_berita = {$berita['id_berita']} LIMIT 1");
                            $gambarData = mysqli_fetch_assoc($gambarQuery);
                            $gambar = $gambarData ? $gambarData['gambar'] : 'default.jpg';
                        ?>
                        <div class="d-flex mb-3 border-bottom pb-2">
                            <img src="../../asset/img/berita/<?= htmlspecialchars($gambar) ?>" width="80" height="80" class="me-2 rounded" alt="Gambar Berita">
                        <div>
                            <a href="?id=<?= $berita['id_berita'] ?>" class="text-decoration-none fw-bold text-primary">
                                <?= htmlspecialchars($berita['judul']) ?>
                            </a>
                        <div class="text-muted small">Dipublikasikan: <?= date('d M Y', strtotime($berita['tanggal'])) ?></div>
                        <p class="mb-0"><?= htmlspecialchars(substr($berita['isi'], 0, 80)) ?>...</p>
                        </div>
                    </div>
                <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted">Belum ada berita lainnya</p>
        <?php endif; ?>
        </div>
    </div>
</div>
                                
                                
                                
                                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
                            </body>
                            </html>
                            