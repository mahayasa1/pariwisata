<?php

session_start();
include_once '../../../config/database.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../../auth/login/login_admin.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $level = $_POST['level'];

    $query = "INSERT INTO tb_user (username, password, level) VALUES ('$username', '$password', '$level')";

    if (mysqli_query($conn, $query)) {
        header("Location: ../../../view/admin/user.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Add User</title>
</head>

<body class="bg-dark">
    <div class="container d-flex justify-content-center align-items-center min-vh-100 mt-4">
        <div class="card p-4 bg-secondary text-light shadow-sm" style="max-width: 500px; width: 100%;">
            <h2 class="text-center mb-4">Add New User</h2>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="level" class="form-label">Role  </label>
                    <select class="form-select" id="level" name="level" required>
                        <option value="" disabled selected>Select role</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">Add User</button>
            </form>
        </div>        
    </div>
</body>