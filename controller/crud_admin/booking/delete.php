<?php
require_once '../../../config/database.php';

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM tb_pemesanan WHERE id_pemesanan = $id");

header("Location: ../../../view/admin/booking.php");