<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

function getBloodStock($conn, $bg) {
    $q = mysqli_query($conn, "SELECT amount FROM blood_stock WHERE blood_group = '$bg'");
    $r = mysqli_fetch_assoc($q);
    return $r['amount'] ?? 0;
}

$res_donors = mysqli_query($conn, "SELECT COUNT(*) as total FROM donors");
$total_donors = ($res_donors) ? mysqli_fetch_assoc($res_donors)['total'] : 0;

$res_req = mysqli_query($conn, "SELECT COUNT(*) as total FROM blood_requests");
$total_requests = ($res_req) ? mysqli_fetch_assoc($res_req)['total'] : 0;

$res_app = mysqli_query($conn, "SELECT COUNT(*) as total FROM blood_requests WHERE status='Approved'");
$approved_requests = ($res_app) ? mysqli_fetch_assoc($res_app)['total'] : 0;

$res_stock_total = mysqli_query($conn, "SELECT SUM(amount) as total FROM blood_stock");
$total_units = 0;
if ($res_stock_total) {
    $row_stock_total = mysqli_fetch_assoc($res_stock_total);
    $total_units = $row_stock_total['total'] ?? 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Blood Bank</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; display: flex; flex-direction: column; height: 100vh; background-color: #f4f4f4;}
        .header { background-color: #ff0000; color: white; padding: 0 30px; display: flex; justify-content: space-between; align-items: center; position: fixed; width: 100%; height: 60px; top: 0; z-index: 1000; box-sizing: border-box; }
        .header .project-title { font-size: 18px; font-weight: bold; display: flex; align-items: center; gap: 10px; }
        .header-right { display: flex; align-items: center; gap: 20px; }
        .logout-btn { color: white; text-decoration: none; font-weight: bold; background: rgba(0,0,0,0.2); padding: 5px 12px; border-radius: 4px; transition: 0.3s; }
        
        .main-container { display: flex; margin-top: 60px; height: calc(100vh - 60px); }
        .sidebar { width: 250px; background-color: #333; color: white; padding-top: 20px; position: fixed; height: 100%; }
        .sidebar a { display: block; color: white; padding: 15px 20px; text-decoration: none; transition: 0.3s; }
        .sidebar a:hover { background-color: #555; border-left: 5px solid #ff0000; }
        
        .content { margin-left: 250px; padding: 40px; flex-grow: 1; overflow-y: auto; }
        .card-container { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px; }
        .card { background: white; padding: 20px; border-radius: 8px; text-align: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .card h3 { color: #ff0000; font-size: 24px; margin-bottom: 5px; }

        .styled-table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .styled-table th, .styled-table td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #ddd; }
        .styled-table th { background-color: #333; color: white; }
        .styled-table tr:hover { background-color: #f1f1f1; }
        
        .stock-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; margin-top: 20px; }
        .stock-card { background:#fff; padding:20px; border-radius:10px; text-align:center; box-shadow:0 2px 10px rgba(0,0,0,0.1); border-top: 4px solid red; }
    </style>
</head>
<body>

    <div class="header">
        <div class="project-title"><i class="fas fa-heartbeat"></i> Blood Bank Management System</div>
        <div class="header-right">
            <strong><?php echo $_SESSION['role'] ?? 'Admin'; ?></strong>
            <a href="logout.php" class="logout-btn">Logout <i class="fas fa-sign-out-alt"></i></a>
        </div>
    </div>

    <div class="main-container">
        <div class="sidebar">
            <a href="dashboard.php"><i class="fas fa-home"></i> Home</a>
            <a href="dashboard.php?view=donors"><i class="fas fa-user"></i> Donor</a>
            <a href="dashboard.php?view=hospitals"><i class="fas fa-hospital-user"></i>Hospital</a>
            <a href="dashboard.php?view=donations"><i class="fas fa-hand-holding-heart"></i> Donations</a>
            <a href="dashboard.php?view=requests"><i class="fas fa-exchange-alt"></i> Blood Requests</a>
           <a href="dashboard.php?view=history"><i class="fas fa-history"></i> Requests History</a> 
            <a href="dashboard.php?view=stock"><i class="fas fa-database"></i> Blood Stock</a>
        </div>

        <div class="content">
            <?php
            $view = $_GET['view'] ?? 'home';

         if($view == 'donors'): ?>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0;"><i class="fas fa-users"></i> List of all Donors</h2>
        <a href="add_donor.php" style="background: #ff0000; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; font-weight: bold; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-plus-circle"></i> Add New Donor
        </a>
    </div>

    <table class="styled-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Age</th>
                <th>Blood</th>
                <th>Phone Number</th>
                <th>Email</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sl = 1; 

            $q = mysqli_query($conn, "SELECT * FROM donors ORDER BY donor_id ASC");
            
            while($r = mysqli_fetch_assoc($q)){
                echo "<tr>
                    <td>{$r['donor_id']}</td>
                    <td>{$r['name']}</td>
                    <td>{$r['gender']}</td>
                    <td>{$r['age']}</td>
                    <td style='color:red; font-weight:bold;'>{$r['blood_group']}</td>
                    <td>{$r['phone']}</td>
                    <td>{$r['email']}</td>
                    <td>{$r['address']}</td>
                    <td style='white-space: nowrap;'>
                        <a href='add_donations.php?id={$r['donor_id']}' style='background:#007bff; color:white; padding:6px 12px; text-decoration:none; border-radius:4px; display:inline-block; font-size:14px; margin-right:5px;'>
                            <i class='fas fa-plus-circle'></i> Donation
                        </a>

                        <a href='edit_donor.php?id={$r['donor_id']}' style='background:#28a745; color:white; padding:6px 12px; text-decoration:none; border-radius:4px; display:inline-block; font-size:14px;'>
                            <i class='fas fa-edit'></i> Edit
                        </a>

                        <a href='delete_donor.php?id={$r['donor_id']}' onclick=\"return confirm('Are you sure?')\" style='background:#ff0000; color:white; padding:6px 12px; text-decoration:none; border-radius:4px; display:inline-block; font-size:14px; margin-left:5px;'>
                            <i class='fas fa-trash'></i> Delete
                        </a>
                    </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>

            <?php elseif($view == 'donations'): ?>
    <h2><i class="fas fa-hand-holding-heart"></i> Donation Records</h2>
    <table class="styled-table">
        <thead>
            <tr>
                <th>ID</th> <th>Donor Name</th>
                <th>Blood Group</th>
                <th>Amount (ml)</th> 
                <th>Donation Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $q = mysqli_query($conn, "SELECT dn.id, d.name, dn.blood_group, dn.amount, dn.donation_date FROM donations dn JOIN donors d ON dn.donor_id = d.donor_id ORDER BY dn.donation_date DESC");
            
            while($r = mysqli_fetch_assoc($q)){
                echo "<tr>
                    <td>{$r['id']}</td> <td>{$r['name']}</td>
                    <td style='color:red; font-weight:bold;'>{$r['blood_group']}</td>
                    <td>{$r['amount']} ml</td> 
                    <td>{$r['donation_date']}</td>
                </tr>";
            }
            ?>
        </tbody>
    </table> 
    <?php elseif($view == 'requests'): ?>
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h2><i class="fas fa-exchange-alt"></i> Active Blood Requests</h2>
        <a href="make_request.php" style="background: #ff0000; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; font-weight: bold;">
            <i class="fas fa-plus"></i> Add New Request
        </a>
    </div>
    <table class="styled-table">
        <thead>
            <tr> 
                <th>Id</th>
                <th>Patient Name</th>
                <th>Blood</th>
                <th>Unit (ml)</th>
                <th>Status</th>
                <th>Request Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sl =1;
            $q = mysqli_query($conn, "SELECT * FROM blood_requests WHERE status='Pending' ORDER BY id DESC");
            
            if(mysqli_num_rows($q) > 0) {
                while($r = mysqli_fetch_assoc($q)){
                    echo "<tr>
                        <td>{$r['id']}</td>
                        <td>{$r['patient_name']}</td> 
                        <td style='color:red; font-weight:bold;'>{$r['blood_group']}</td>
                        <td>{$r['units_needed']} ml</td>
                        <td><span style='color:orange; font-weight:bold;'>{$r['status']}</span></td>
                        <td>{$r['request_date']}</td>
                        <td>
                            <a href='approve_request.php?id={$r['id']}' style='background:green; color:white; padding:6px 10px; text-decoration:none; border-radius:4px; font-size:13px; display:inline-block;'>Approve</a>
                            <a href='reject_request.php?id={$r['id']}' style='background:red; color:white; padding:6px 10px; text-decoration:none; border-radius:4px; font-size:13px; display:inline-block; margin-left:5px;'>Reject</a>
                        </td>
                    </tr>";
                }
            } else { 
                echo "<tr><td colspan='7' style='text-align:center;'>No active requests found.</td></tr>"; 
            }
            ?>
        </tbody>
    </table>
             <?php elseif($view == 'history'): ?>
                <h2><i class="fas fa-history"></i> Request History</h2>
                <table class="styled-table">
                    <thead>
                        <tr><th>Patient Name</th><th>Blood</th><th>Date</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        <?php
                        $q = mysqli_query($conn, "SELECT * FROM blood_requests ORDER BY request_date DESC");
                        while($r = mysqli_fetch_assoc($q)){
                            $color = ($r['status'] == 'Approved') ? 'green' : (($r['status'] == 'Rejected') ? 'red' : 'orange');
                            echo "<tr>
                                <td>{$r['patient_name']}</td>
                                <td>{$r['blood_group']}</td>
                                <td>{$r['request_date']}</td>
                                <td><b style='color:$color'>{$r['status']}</b></td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>

            <?php elseif($view == 'stock'): ?>
    <h2><i class="fas fa-database"></i> Live Blood Stock Status</h2>
    <div class="stock-grid">
        <?php
        $blood_groups = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];
        
        
        foreach($blood_groups as $bg) {
        
            $q = mysqli_query($conn, "SELECT amount FROM blood_stock WHERE blood_group = '$bg'");
            $r = mysqli_fetch_assoc($q);
            $amt = $r['amount'] ?? 0;
            
            
            $percent = min(($amt / 2000) * 100, 100);
            
            echo "
            <div class='stock-card'>
                <h1 style='color:red; margin:0;'>$bg <i class='fas fa-tint'></i></h1>
                <h3 style='margin:10px 0;'>Stock: $amt ml</h3> 
                <progress value='$percent' max='100' style='width:100%; height:10px;'></progress> 
            </div>";
        }
        ?>
    </div>
    <?php elseif($view == 'hospitals'): ?>
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h2><i class="fas fa-hospital"></i> Hospital List</h2>
        <a href="add_hospital.php" style="background: #333; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; font-weight: bold;">
            <i class="fas fa-plus"></i> Add New Hospital
        </a>
    </div>

    <table class="styled-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Hospital Name</th>
                <th>Phone Number</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sl = 1;
            $q = mysqli_query($conn, "SELECT * FROM hospitals ORDER BY id ASC");
            if(mysqli_num_rows($q) > 0) {
                while($r = mysqli_fetch_assoc($q)){
                    echo "<tr>
                        <td>{$r['id']}</td>
                        <td>{$r['hospital_name']}</td>
                        <td>{$r['phone']}</td>
                        <td>{$r['address']}</td>
                        <td>
                            <a href='delete_hospital.php?id={$r['id']}' onclick=\"return confirm('Are you sure?')\" style='color:red;'><i class='fas fa-trash'></i> Delete</a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='5' style='text-align:center;'>No hospitals added yet.</td></tr>";
            }
            ?>
        </tbody>
    </table>

            <?php else: // Home View (Default) ?>
                <div class="card-container">
                    <div class="card"><h3>A+ <i class="fas fa-tint" style="color:red;"></i></h3><p>Stock: <?php echo getBloodStock($conn, 'A+'); ?> ml</p></div>
                    <div class="card"><h3>B+ <i class="fas fa-tint" style="color:red;"></i></h3><p>Stock: <?php echo getBloodStock($conn, 'B+'); ?> ml</p></div>
                    <div class="card"><h3>O+ <i class="fas fa-tint" style="color:red;"></i></h3><p>Stock: <?php echo getBloodStock($conn, 'O+'); ?> ml</p></div>
                    <div class="card"><h3>AB+ <i class="fas fa-tint" style="color:red;"></i></h3><p>Stock: <?php echo getBloodStock($conn, 'AB+'); ?> ml</p></div>
                </div>
                <div class="card-container">
                    <div class="card"><h3>A- <i class="fas fa-tint" style="color:red;"></i></h3><p>Stock: <?php echo getBloodStock($conn, 'A-'); ?> ml</p></div>
                    <div class="card"><h3>B- <i class="fas fa-tint" style="color:red;"></i></h3><p>Stock: <?php echo getBloodStock($conn, 'B-'); ?> ml</p></div>
                    <div class="card"><h3>O- <i class="fas fa-tint" style="color:red;"></i></h3><p>Stock: <?php echo getBloodStock($conn, 'O-'); ?> ml</p></div>
                    <div class="card"><h3>AB- <i class="fas fa-tint" style="color:red;"></i></h3><p>Stock: <?php echo getBloodStock($conn, 'AB-'); ?> ml</p></div>
                </div>
                <div class="card-container">
                    <div class="card"><i class="fas fa-users" style="font-size:30px;"></i><h3><?php echo $total_donors; ?></h3><p>Total Donors</p></div>
                    <div class="card"><i class="fas fa-spinner" style="font-size:30px;color:#f39c12;"></i><h3><?php echo $total_requests; ?></h3><p>Total Requests</p></div>
                    <div class="card"><i class="fas fa-check-circle" style="font-size:30px;color:#27ae60;"></i><h3><?php echo $approved_requests; ?></h3><p>Approved Requests</p></div>
                    <div class="card"><i class="fas fa-droplet" style="font-size:30px;color:#3498db;"></i><h3><?php echo $total_units; ?></h3><p>Total Units (ml)</p></div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>