<?php
include_once '../../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($username) || empty($password) || empty($confirm_password)) {
        echo "<script>alert('Please fill in all fields!'); window.location='register_admin.php';</script>";
    } elseif ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!'); window.location='register_admin.php';</script>";
    } else {
        $query = "INSERT INTO tb_user (username, password, level) VALUES ('$username', '$password', 'admin')";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Registration successful!'); window.location='../login/login_admin.php';</script>";
        } else {
            echo "<script>alert('Registration failed!'); window.location='register_admin.php';</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Register Admin</title>
</head>
<body class="bg-dark">
    <section class="vh-90">
        <div class="container-fluid">
            <div class="mt-5 text-white d-flex justify-content-center align-items-center">
                <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">
                    <form style="width: 23rem;" method="POST" action="">
                    <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">REGISTER ADMIN</h3>
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="form2Example18">Username</label>
                            <input type="username" name="username" id="form2Example18" class="form-control form-control-lg" />
                        </div>
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="form2Example28">Password</label>
                            <input type="password" name="password" id="form2Example28" class="form-control form-control-lg" />
                        </div>
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="form2Example28">Confirm Password</label>
                            <input type="password" name="confirm_password" id="form2Example28" class="form-control form-control-lg" />
                        </div>
                        <div class="pt-1 mb-4">
                            <button data-mdb-button-init data-mdb-ripple-init class="btn btn-info btn-lg btn-block" type="submit">Sign Up</button>
                        </div>
                        <p>Already have an account? <a href="../login/login_admin.php" class="link-info">Sign in here</a></p>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>