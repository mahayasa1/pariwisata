<?php

session_start();
require_once '../../../config/database.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../../auth/login/login_admin.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = mysqli_query($conn, "DELETE FROM tb_sponsor WHERE id_sponsor = '$id'");
    
    if ($query) {
        header("Location: ../../../view/admin/sponsorship.php");
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    echo "ID not set.";
}


?>