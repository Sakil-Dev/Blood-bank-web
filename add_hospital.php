<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

if(isset($_POST['submit'])){
    $h_name = $_POST['h_name'];
    $h_phone = $_POST['h_phone'];
    $h_address = $_POST['h_address'];

    $q = "INSERT INTO hospitals (hospital_name, phone, address) VALUES ('$h_name', '$h_phone', '$h_address')";

    if(mysqli_query($conn, $q)){
        echo "<script>alert('Hospital Added Successfully!'); window.location='dashboard.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Hospital</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { font-family: Arial; background: #f4f4f4; display: flex; justify-content: center; padding: 50px; }
        .box { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 400px; border-top: 5px solid red; }
        input, textarea { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: red; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
    </style>
</head>
<body>
    <div class="box">
        <h2 style="text-align:center; color:#333;"><i class="fas fa-hospital"></i> Add Hospital</h2>
        <form method="POST">
            <input type="text" name="h_name" placeholder="Hospital Name" required>
            <input type="text" name="h_phone" placeholder="Phone Number" required>
            <textarea name="h_address" placeholder="Hospital Address" rows="3"></textarea>
            <button type="submit" name="submit">Save Hospital Information</button>
            <a href="dashboard.php" style="display:block; text-align:center; margin-top:15px; text-decoration:none; color:gray;">Cancel</a>
        </form>
    </div>
</body>
</html>