<?php

include_once '../config/database.php';

$username = $_POST['username'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

$query = "INSERT INTO tb_user (username, password, level) VALUES ('$username', '$password', 'admin')";

if(!isset($username) || !isset($password) || !isset($confirm_password)) {
    echo "<script>alert('Please fill in all fields!'); window.location='register_admin.php';</script>";
} elseif ($password !== $confirm_password) {
    echo "<script>alert('Passwords do not match!'); window.location='register_admin.php';</script>";
} else {
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Registration successful!'); window.location='login_admin.php';</script>";
    } else {
        echo "<script>alert('Registration failed!'); window.location='register_admin.php';</script>";
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
<body class="bg_light">
    <div class="containe py-5r">
        <div class="row justify-content-center">
            <div class="card-header bg-primary text-white text-center">
                Register Admin
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Register</button>
                    <a href="login_admin.php" class="btn btn-secondary w-100">Back to Login</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>