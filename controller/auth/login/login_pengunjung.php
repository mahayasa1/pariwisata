<?php 
session_start();
require_once '../../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Hindari SQL Injection
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    // Perbaikan query
    $query = mysqli_query($conn, "SELECT * FROM tb_user WHERE username='$username' AND password='$password' AND level='pengunjung'");

    if ($query && mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
        $_SESSION['username'] = $data['username'];
        $_SESSION['level'] = 'admin';
        header("Location: ../../../view/pengunjung/index.php");
        exit;
    } else {
        echo "<script>alert('Login gagal!'); window.location='login_pengunjung.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Login Admin</title>
</head>
<body class="bg-dark">
<section class="vh-100">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6 text-white d-flex justify-content-center align-items-center">

        <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">

          <form style="width: 23rem;" method="POST" action="">

            <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">LOG IN</h3>

            <div data-mdb-input-init class="form-outline mb-4">
              <input type="username" name="username" id="form2Example18" class="form-control form-control-lg" />
              <label class="form-label" for="form2Example18">Username</label>
            </div>

            <div data-mdb-input-init class="form-outline mb-4">
              <input type="password" name="password" id="form2Example28" class="form-control form-control-lg" />
              <label class="form-label" for="form2Example28">Password</label>
            </div>

            <div class="pt-1 mb-4">
              <button data-mdb-button-init data-mdb-ripple-init class="btn btn-info btn-block" type="submit">Login</button>
            </div>

            <p class="small mb-5 pb-lg-2"><a class="text-muted" href="#!">Forgot password?</a></p>
            <p>Don't have an account? <a href="../register/register_pengunjung.php" class="link-info">Register here</a></p>

          </form>

        </div>

      </div>
      <div class="col-sm-6 px-0 d-none d-sm-block">
        <img src="https://img.freepik.com/premium-photo/directly-shot-equipments-table_1048944-587490.jpg?ga=GA1.1.157147526.1735924019&semt=ais_hybrid&w=740"
          alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">
      </div>
    </div>
  </div>
</section>
</body>
</html>
