<?php
include 'db_connect.php';
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM donors WHERE donor_id = '$id'";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: dashboard.php?view=donors&msg=deleted");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>