<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

$res = mysqli_query($conn, "SELECT * FROM donors WHERE donor_id = '$id'");
$data = mysqli_fetch_assoc($res);


if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $blood_group = $_POST['blood_group'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    
    $update_sql = "UPDATE donors SET 
                   name='$name', gender='$gender', age='$age', 
                   blood_group='$blood_group', phone='$phone', 
                   email='$email', address='$address' 
                   WHERE donor_id='$id'";

    if (mysqli_query($conn, $update_sql)) {
        header("Location: dashboard.php?view=donors&msg=updated");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Donor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; display: flex; justify-content: center; padding: 20px; }
        .form-container { width: 400px; background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); border-top: 4px solid #ff0000; }
        h3 { text-align: center; color: #333; margin-top: 0; }
        label { font-weight: bold; display: block; margin-top: 10px; font-size: 14px; }
        input, select, textarea { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .btn-save { background: #28a745; color: white; border: none; padding: 12px; cursor: pointer; width: 100%; border-radius: 4px; font-size: 16px; margin-top: 20px; }
        .btn-save:hover { background: #218838; }
        .back-btn { display: block; text-align: center; margin-top: 15px; color: #666; text-decoration: none; font-size: 14px; }
    </style>
</head>
<body>
    <div class="form-container">
        <h3><i class="fas fa-user-edit"></i> Edit Donor Info</h3>
        <form method="POST">
            <label>Name</label>
            <input type="text" name="name" value="<?php echo $data['name']; ?>" required>

            <div style="display:flex; gap:10px;">
                <div style="flex:1;">
                    <label>Gender</label>
                    <select name="gender">
                        <option value="Male" <?php if($data['gender']=='Male') echo 'selected'; ?>>Male</option>
                        <option value="Female" <?php if($data['gender']=='Female') echo 'selected'; ?>>Female</option>
                    </select>
                </div>
                <div style="flex:1;">
                    <label>Age</label>
                    <input type="number" name="age" value="<?php echo $data['age']; ?>" required>
                </div>
            </div>

            <label>Blood Group</label>
            <select name="blood_group">
                <?php 
                $groups = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];
                foreach($groups as $g){
                    $selected = ($data['blood_group'] == $g) ? 'selected' : '';
                    echo "<option value='$g' $selected>$g</option>";
                }
                ?>
            </select>

            <label>Phone</label>
            <input type="text" name="phone" value="<?php echo $data['phone']; ?>" required>

            <label>Email</label>
            <input type="email" name="email" value="<?php echo $data['email']; ?>" required>

            <label>Address</label>
            <textarea name="address" rows="3"><?php echo $data['address']; ?></textarea>

            <button type="submit" name="update" class="btn-save">Update Donor Details</button>
            <a href="dashboard.php?view=donors" class="back-btn"><i class="fas fa-arrow-left"></i> Back to List</a>
        </form>
    </div>
</body>
</html>