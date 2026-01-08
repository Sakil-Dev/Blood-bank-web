<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $sql = "INSERT INTO users (full_name, email, phone, username, password, role) 
            VALUES ('$full_name', '$email', '$phone', '$username', '$password', '$role')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Registration Successful!');
                window.location.href='index.php'; 
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>












<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Maxpense</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="register-container">
        <h1 class="register-title">Register</h1>
        <p class="subtitle">Create an <span class="highlight-red">account</span> to unlock all features of <span class="highlight-red">Maxpense</span>.</p>

        <form action="registration.php" method="POST">
    
    <div class="input-group">
        <i class="fas fa-user field-icon"></i>
        <input type="text" name="full_name" placeholder="Full Name" class="reg-input" required>
    </div>

    <div class="input-group">
        <i class="fas fa-envelope field-icon"></i>
        <input type="email" name="email" placeholder="Email" class="reg-input" required>
    </div>

    <div class="input-group">
        <i class="fas fa-phone field-icon"></i>
        <input type="tel" name="phone" placeholder="Phone Number" class="reg-input" required>
    </div>

    <div class="input-group">
        <i class="fas fa-at field-icon"></i>
        <input type="text" name="username" placeholder="Username" class="reg-input" required>
    </div>

    <div class="input-group">
        <i class="fas fa-lock field-icon"></i>
        <input type="password" name="password" id="password" placeholder="Password" class="reg-input" required>
        <i class="fas fa-eye eye-icon" id="togglePassword"></i>
    </div>

    <div class="input-group">
        <i class="fas fa-users field-icon"></i>
        <select name="role" class="reg-input" required>
            <option value="" disabled selected>Select Role</option>
            <option value="Admin">Admin</option>
            <option value="Donor">Donor</option>
            <option value="Hospital">Hospital</option>
        </select>
    </div>

    <button type="submit" class="register-btn">REGISTER</button>
</form>

        <p class="footer-text">Already have an account? <a href="index.php" class="login-link">Login</a></p>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>