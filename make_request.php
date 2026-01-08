<?php
include 'db_connect.php';

if(isset($_POST['submit'])){
    $name = $_POST['patient_name'];
    $blood = $_POST['blood_group'];
    $units = $_POST['units']; 
    $phone = $_POST['phone'];

    
    $q = "INSERT INTO blood_requests (patient_name, blood_group, units_needed, status, request_date) 
          VALUES ('$name', '$blood', '$units', 'Pending', NOW())";

    if(mysqli_query($conn, $q)){
        echo "<script>alert('Request Submitted!'); window.location='dashboard.php?view=requests';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Blood Request</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; display: flex; justify-content: center; padding: 50px; }
        .box { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 350px; border-top: 5px solid red; }
        input, select { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: red; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
    </style>
</head>
<body>
    <div class="box">
        <h2 style="color:red; text-align:center;">New Blood Request</h2>
        <form method="POST">
            <input type="text" name="patient_name" placeholder="Patient Name" required>
            <select name="blood_group" required>
                <option value="">Select Blood Group</option>
                <option>A+</option><option>A-</option><option>B+</option><option>B-</option>
                <option>O+</option><option>O-</option><option>AB+</option><option>AB-</option>
            </select>
            <input type="number" name="units" placeholder="Units Needed (ml)" required>
            <input type="text" name="phone" placeholder="Phone Number" required>
            <button type="submit" name="submit">Save Request</button>
            <a href="dashboard.php?view=requests" style="display:block; text-align:center; margin-top:10px; text-decoration:none; color:gray;">Cancel</a>
        </form>
    </div>
</body>
</html>