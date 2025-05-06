<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Selamat Datang - Sistem Pariwisata</title>
  </head>
  <body class="bg-light">

  <div class="container py-5">
    <div class="text-center mb-5">
      <h1 class="display-5 fw-bold">Sistem Informasi Pariwisata</h1>
      <p class="lead">Silahkan Pilih jenis Pengguna untuk login atau mendaftar</p>
    </div>

    <div class="row g-4 justify-content-center">
      <!-- Ppengunjung -->
    <div class="col-md-3">
      <div class="card border-primary">
        <div class="card-header bg-primary text-white text-center">
          Pengunjung
        </div>
        <div class="card-body text-center">
          <a href="auth/login.php?role=pengunjung" class="btn btn-outline-primary mb-2 w-100">Login</a>
          <a href="auth/register.php?role=pengunjung" class="btn btn-outline-seconary w-100">Daftar</a>
        </div>
      </div>
    </div>

  <!-- Sponsorship -->
      <div class="col-md">
        <div class="card border-success">
          <div class="card-header bg-success text-dark text-center">
            Sponsorship
          </div>
          <div class="card-body text-center">
            <a href="auth/login.php?role=sponsorship" class="btn btn-outline-success mb-2 w-100">Login</a>
            <a href="auth/register.php?role=sponsorship" class="btn btn-outline-secondary w-100">Daftar</a>
        </div>
      </div>
    </div>
  </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>