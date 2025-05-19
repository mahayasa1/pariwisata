<?php

require_once '../../../config/database.php';

$id = $_GET['id'];

$query = mysqli_query($conn, "DELETE FROM tb_user WHERE id_user = '$id'");
if ($query) {
    header("Location: ../../../view/admin/user.php");
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}
?>