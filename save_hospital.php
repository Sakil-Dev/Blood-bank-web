<?php
include 'db_connect.php';

if(isset($_POST['save_hospital'])){
    $name = $_POST['h_name'];
    $phone = $_POST['h_phone'];
    $email = $_POST['h_email'];
    $address = $_POST['h_address'];

    $sql = "INSERT INTO hospitals (name, phone, email, address) VALUES ('$name', '$phone', '$email', '$address')";

    if(mysqli_query($conn, $sql)){
        echo "<script>alert('Hospital Added!'); window.location.href='dashboard.php';</script>";
    }
}
?>