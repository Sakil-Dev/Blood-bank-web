<?php
include 'db_connect.php';
$email = $_GET['email']; 

if(isset($_POST['update_password'])){
    $new_password = $_POST['new_password'];


    $sql = "UPDATE users SET password = '$new_password' WHERE email = '$email'";

    if(mysqli_query($conn, $sql)){
        echo "<script>alert('Password Updated!'); window.location.href='index.php';</script>";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>New Password</title><link rel="stylesheet" href="style.css"></head>
<body>
    <div class="login-container">
        <h2>Enter New Password</h2>
        <form method="POST">
            <input type="password" name="new_password" placeholder="New Password" required>
            <button type="submit" name="update_password" class="login-btn">Update Password</button>
        </form>
    </div>
</body>
</html>