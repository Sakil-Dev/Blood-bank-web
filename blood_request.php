<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}


if(isset($_POST['add_donor_request'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $blood_group = $_POST['blood_group'];
    $units = mysqli_real_escape_string($conn, $_POST['units_needed']);
    $status = $_POST['status']; 
    $request_date = date('Y-m-d H:i:s');

    
    $q1 = "INSERT INTO blood_requests (patient_name, blood_group, units_needed, status, request_date) 
           VALUES ('$name', '$blood_group', '$units', '$status', '$request_date')";

    if(mysqli_query($conn, $q1)){
        echo "<script>alert('Blood Request Added Successfully!'); window.location.href='add_donor_request.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}


$fetch_query = "SELECT * FROM blood_requests ORDER BY id DESC";
$list_result = mysqli_query($conn, $fetch_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Active Blood Requests - Blood Bank</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; margin: 0; display: flex; background-color: #f4f7f6; }
        .header { background-color: #ff0000; color: white; padding: 0 20px; display: flex; justify-content: space-between; align-items: center; position: fixed; width: 100%; height: 60px; top: 0; z-index: 1000; box-sizing: border-box; }
        .sidebar { width: 250px; background-color: #333; color: white; padding-top: 20px; position: fixed; height: 100%; top: 60px; }
        .sidebar a { display: block; color: white; padding: 15px 20px; text-decoration: none; border-bottom: 1px solid #444; }
        .sidebar a:hover { background-color: #ff0000; }
        .content { margin-left: 250px; margin-top: 80px; padding: 30px; width: 100%; box-sizing: border-box; }
        
        .card { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); margin-bottom: 30px; border-top: 5px solid #ff0000; }
        .form-grid { display: flex; gap: 15px; flex-wrap: wrap; }
        .form-group { flex: 1; min-width: 150px; margin-bottom: 15px; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 5px; }
        .form-group input, .form-group select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        .submit-btn { background: #ff0000; color: white; border: none; padding: 12px 25px; border-radius: 5px; cursor: pointer; font-weight: bold; width: 100%; font-size: 16px; transition: 0.3s; }
        .submit-btn:hover { background: #cc0000; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f8f9fa; color: #333; }
        .status-badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; color: white; font-weight: bold; }
        .emergency { background: #ff0000; }
        .pending { background: #ffa500; }
    </style>
</head>
<body>

<div class="header">
    <div style="font-weight:bold;"><i class="fas fa-heartbeat"></i> Blood Bank System</div>
    <div><i class="fas fa-user-shield"></i> Admin Panel</div>
</div>

<div class="sidebar">
    <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
    <a href="add_donor.php"><i class="fas fa-user-plus"></i> Add Donor</a>
    <a href="add_donor_request.php" style="background:#ff0000;"><i class="fas fa-hand-holding-medical"></i> Active Requests</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<div class="content">
    <div class="card">
        <h2><i class="fas fa-plus-circle"></i> Create New Blood Request</h2>
        <form method="POST">
            <div class="form-grid">
                <div class="form-group" style="flex: 2;">
                    <label>Patient Name</label>
                    <input type="text" name="name" placeholder="Patient Full Name" required>
                </div>
                <div class="form-group">
                    <label>Blood Group</label>
                    <select name="blood_group">
                        <option value="A+">A+</option><option value="B+">B+</option>
                        <option value="O+">O+</option><option value="AB+">AB+</option>
                        <option value="A-">A-</option><option value="B-">B-</option>
                        <option value="O-">O-</option><option value="AB-">AB-</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Bags Needed</label>
                    <input type="number" name="units_needed" placeholder="Qty" required>
                </div>
                <div class="form-group">
                    <label>Priority Status</label>
                    <select name="status">
                        <option value="Pending">Pending</option>
                        <option value="Emergency">Emergency</option>
                    </select>
                </div>
            </div>
            <button type="submit" name="add_donor_request" class="submit-btn">Add Blood Request</button>
        </form>
    </div>

    <div class="card">
        <h3><i class="fas fa-list"></i> Active Blood Request List</h3>
        <table>
            <thead>
                <tr>
                    <th>Patient Name</th>
                    <th>Blood Group</th>
                    <th>Bags</th>
                    <th>Status</th>
                    <th>Request Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($list_result)): ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($row['patient_name']); ?></strong></td>
                    <td><span style="color:#ff0000; font-weight:bold;"><?php echo $row['blood_group']; ?></span></td>
                    <td><?php echo $row['units_needed']; ?></td>
                    <td>
                        <span class="status-badge <?php echo ($row['status'] == 'Emergency') ? 'emergency' : 'pending'; ?>">
                            <?php echo $row['status']; ?>
                        </span>
                    </td>
                    <td><?php echo date('d M, Y', strtotime($row['request_date'])); ?></td>
                </tr>
                <?php endwhile; ?>
                <?php if(mysqli_num_rows($list_result) == 0): ?>
                    <tr><td colspan="5" style="text-align:center;">No active requests found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>