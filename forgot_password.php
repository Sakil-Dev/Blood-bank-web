<?php
include 'db_connect.php';

if(isset($_POST['reset_request'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    
    if(mysqli_num_rows($check) > 0){
        header("Location: reset_password.php?email=$email");
        exit();
    } else {
        echo "<script>alert('Email not found in our database!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Forgot Password</title><link rel="stylesheet" href="style.css"></head>
<body>
    <div class="login-container">
        <h2>Reset Password</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Enter your registered email" required>
            <button type="submit" name="reset_request" class="login-btn">Next</button>
        </form>
    </div>
</body>
</html>