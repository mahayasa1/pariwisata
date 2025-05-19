<?php

session_start();
require_once '../../config/database.php';

// Hapus semua session
session_unset();
session_destroy();

if(isset($_GET['role'])){
    $role = $_GET['role'];
    if ($role == 'admin') {
        header("Location: login/login_admin.php");
    } elseif ($role == 'sponsor') {
        header("Location: login/login_sponsor.php");
    } elseif ($role == 'pengunjung') {
        header("Location: login/login_pengunjung.php");
    } else {
        header("Location: ../../index.php");
    }
} else {
    header("Location: ../../index.php");
}

?>