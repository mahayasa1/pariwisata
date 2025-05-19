<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sistem Informasi Pariwisata</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
      height: 100vh;
      background-image: url('https://img.freepik.com/free-photo/beautiful_1203-2633.jpg?ga=GA1.1.157147526.1735924019&semt=ais_hybrid&w=740');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      position: relative;
    }

    .overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.6); /* Transparansi background */
      z-index: 1;
    }

    .content-box {
      z-index: 2;
      position: relative;
      background-color: rgba(255, 255, 255, 0.2); /* Transparansi konten */
      color: white;
      padding: 40px;
      border-radius: 12px;
      /* box-shadow: 0 0 10px rgba(0,0,0,0.3); */
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="overlay"></div>

  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="content-box">
      <h1 class="fw-bold">Sistem Informasi Pariwisata</h1>
      <p class="fw-bold">Silahkan Pilih jenis Pengguna untuk login</p>
      <div class="d-grid gap-3 col-12 col-md-6 mx-auto">
        <a href="controller/auth/login/login_pengunjung.php" class="btn btn-primary fw-bold">PENGUNJUNG</a>
        <a href="controller/auth/login/login_sponsorship.php" class="btn btn-success fw-bold">SPONSORSHIP</a>
      </div>
    </div>
  </div>
</body>
</html>
