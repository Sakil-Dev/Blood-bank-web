<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

//(Security update: mysqli_real_escape_string)
if(isset($_POST['add_donor'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $blood_group = $_POST['blood_group'];
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    $query = "INSERT INTO donors (name, gender, age, blood_group, phone, email, address) 
              VALUES ('$name', '$gender', '$age', '$blood_group', '$phone', '$email', '$address')";

    if(mysqli_query($conn, $query)){
        
        echo "<script>alert('Donor Added Successfully!'); window.location.href='dashboard.php?view=donors';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Donor - Blood Bank</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; display: flex; flex-direction: column; background-color: #f4f7f6; }
        .header { background-color: #ff0000; color: white; padding: 0 20px; display: flex; justify-content: space-between; align-items: center; position: fixed; width: 100%; height: 60px; top: 0; z-index: 1000; box-sizing: border-box; }
        
        /* Sidebar layout matching your dashboard */
        .sidebar { width: 250px; background-color: #333; color: white; padding-top: 20px; position: fixed; height: 100%; top: 60px; }
        .sidebar a { display: block; color: white; padding: 15px 20px; text-decoration: none; transition: 0.3s; }
        .sidebar a:hover { background-color: #555; border-left: 5px solid #ff0000; }
        
        .content { margin-left: 250px; margin-top: 80px; padding: 30px; }
        .form-container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); max-width: 600px; margin: auto; }
        .form-container h2 { color: #ff0000; margin-bottom: 20px; text-align: center; }
        
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        .submit-btn { background-color: #ff0000; color: white; padding: 12px; border: none; width: 100%; border-radius: 5px; font-size: 16px; cursor: pointer; font-weight: bold; }
        .submit-btn:hover { background-color: #cc0000; }
        .back-btn { display: block; text-align: center; margin-top: 15px; text-decoration: none; color: #333; font-size: 14px; }
    </style>
</head>
<body>

    <div class="header">
        <div style="font-weight:bold;"><i class="fas fa-heartbeat"></i> Blood Bank Management System</div>
        <div>Logged in as: <strong>Admin</strong> <a href="logout.php" style="color:white; margin-left:15px; text-decoration:none;"><i class="fas fa-sign-out-alt"></i></a></div>
    </div>

    <div class="sidebar">
        <a href="dashboard.php"><i class="fas fa-home"></i> Home</a>
        <a href="dashboard.php?view=donors"><i class="fas fa-user"></i> Donor List</a>
        <a href="dashboard.php?view=donations"><i class="fas fa-hand-holding-heart"></i> Donations</a>
        <a href="dashboard.php?view=requests"><i class="fas fa-exchange-alt"></i> Blood Requests</a>
        <a href="dashboard.php?view=stock"><i class="fas fa-database"></i> Blood Stock</a>
    </div>

    <div class="content">
        <div class="form-container">
            <h2><i class="fas fa-user-plus"></i> Add New Donor</h2>
            <form method="POST">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" placeholder="Enter Donor Name" required>
                </div>
                <div style="display: flex; gap: 15px;">
                    <div class="form-group" style="flex: 1;">
                        <label>Gender</label>
                        <select name="gender">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label>Age</label>
                        <input type="number" name="age" placeholder="Age" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Blood Group</label>
                    <select name="blood_group">
                        <option value="A+">A+</option><option value="A-">A-</option>
                        <option value="B+">B+</option><option value="B-">B-</option>
                        <option value="O+">O+</option><option value="O-">O-</option>
                        <option value="AB+">AB+</option><option value="AB-">AB-</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone" placeholder="Enter Phone Number" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Enter Email Address">
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <textarea name="address" rows="3" placeholder="Enter Full Address"></textarea>
                </div>
                <button type="submit" name="add_donor" class="submit-btn">Register Donor</button>
                <a href="dashboard.php?view=donors" class="back-btn"><i class="fas fa-arrow-left"></i> Back to List</a>
            </form>
        </div>
    </div>

</body>
</html>