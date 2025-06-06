<?php

session_start();
require_once '../../../config/database.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../../auth/login/login_admin.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = mysqli_query($conn, "SELECT * FROM tb_user WHERE id_user = '$id'");
    $row = mysqli_fetch_assoc($query);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $level = $_POST['level'];

    $query = "UPDATE tb_user SET username='$username', password='$password', level='$level' WHERE id_user='$id'";

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
    <title>Edit User</title>
</head>
<body class="bg-dark">
    <div class="container d-flex justify-content-center align-items-center min-vh-100 mt-4">
        <div class="card p-4 bg-secondary text-light shadow-sm" style="max-width: 500px; width: 100%;">
            <h2 class="text-center mb-4">Edit User</h2>
            <form method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?=$row['username']?>" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" value="<?=$row['password']?>" required>
                </div>
                <div class="mb-3">
                    <label for="level" class="form-label">Role</label>
                    <select class="form-select" id="level" name="level" required>
                        <option value="" disabled>Select Role</option>
                        <option value="admin" <?= $row['level'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="pengunjung" <?= $row['level'] == 'pengunjung' ? 'selected' : '' ?>>Pengunjung</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">Update User</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>