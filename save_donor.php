<?php
include 'db_connect.php';

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $blood_group = $_POST['blood_group'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    $sql = "INSERT INTO donors (name, gender, age, blood_group, phone, email, address) 
            VALUES ('$name', '$gender', '$age', '$blood_group', '$phone', '$email', '$address')";

    if(mysqli_query($conn, $sql)){
        echo "<script>alert('Donor Added Successfully!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>