<?php
include 'db_connect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);


    $query = "SELECT * FROM users WHERE email='$email' AND password='$password' AND role='$role'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        
        echo "<script>alert('Login Successful!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Error! Invalid Email, Password or Role.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="login-container">
        <div class="icon-wrapper">
            <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2.5C12 2.5 5 11 5 15.5C5 19.5 8.1 22.5 12 22.5C15.9 22.5 19 19.5 19 15.5C19 11 12 2.5 12 2.5Z" fill="#FF0000" stroke="#CC0000" stroke-width="0.5"/>
                <path d="M8.5 13C8.5 13 7 15 7 16.5" stroke="white" stroke-width="1.5" stroke-linecap="round" opacity="0.5"/>
            </svg>
        </div>

        <h1>Welcome Back</h1>
        <p class="subtitle">Enter your credentials to access your account</p>

        <form action="index.php" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter your password" required>
            </div>

            <div class="form-group">
                <label for="role">Select Role</label>
                <div class="select-wrapper">
                    <select name="role" id="role" required>
                        <option value="" disabled selected>Select your role</option>
                        <option value="Admin">Admin</option>
                        <option value="Donor">Donor</option>
                        <option value="Hospital">Hospital</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="login-btn">Login</button>
        </form> 
        <div class="footer-links">
            <a href="forgot_password.php" class="forgot-pass">Forgot your password?</a>
            <p>Don't have an account? <a href="registration.php" class="register">Register Here</a></p>
        </div>
    </div>

</body>
</html>
<!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>