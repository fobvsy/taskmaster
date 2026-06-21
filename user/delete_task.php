<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'user') {
    header("Location: ../auth/login.php");
    exit();
}

$id_user = $_SESSION['id_user'];

if (isset($_GET['id'])) {
    $id_task = (int)$_GET['id'];
    
    // Verifikasi kepemilikan tugas
    $check_query = "SELECT id_task FROM tasks WHERE id_task = $id_task AND id_user = $id_user";
    $result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($result) > 0) {
        $delete_query = "DELETE FROM tasks WHERE id_task = $id_task AND id_user = $id_user";
        mysqli_query($conn, $delete_query);
        header("Location: tasks.php?msg=deleted");
        exit();
    }
}

header("Location: tasks.php");
exit();
?>
