<?php
include 'db_connect.php';
session_start();

if (!isset($_GET['id'])) {
    header("Location: dashboard.php?view=requests");
    exit();
}

$id = $_GET['id'];


$res = mysqli_query($conn, "SELECT * FROM blood_requests WHERE id = '$id'");
$data = mysqli_fetch_assoc($res);

if ($data) {
    $bg = $data['blood_group'];
    $needed = $data['units_needed'];

    
    
$stock_res = mysqli_query($conn, "SELECT amount FROM blood_stock WHERE blood_group = '$bg'");
$stock_data = mysqli_fetch_assoc($stock_res);

$current_stock = ($stock_data) ? $stock_data['amount'] : 0;

    if ($current_stock >= $needed) {

        $update_stock = "UPDATE blood_stock SET amount = amount - $needed WHERE blood_group = '$bg'";
        $update_request = "UPDATE blood_requests SET status = 'Approved' WHERE id = '$id'";

        if (mysqli_query($conn, $update_stock) && mysqli_query($conn, $update_request)) {
            echo "<script>alert('Request Approved and Stock Updated!'); window.location='dashboard.php?view=requests';</script>";
        } else {
            echo "Error updating records: " . mysqli_error($conn);
        }
    } else {
        
        echo "<script>alert('Insufficient stock for $bg. Current Stock: $current_stock ml'); window.location='dashboard.php?view=requests';</script>";
    }
} else {
    echo "<script>alert('Invalid Request!'); window.location='dashboard.php?view=requests';</script>";
}
?>