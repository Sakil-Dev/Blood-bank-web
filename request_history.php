<?php
session_start();
include 'db_connect.php';
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$query = "SELECT * FROM blood_requests ORDER BY request_date DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Request History - Blood Bank</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f7f6; margin: 0; }
        .sidebar { width: 250px; background: #2c2c2c; height: 100vh; position: fixed; padding-top: 20px; }
        .sidebar a { color: white; display: block; padding: 15px 25px; text-decoration: none; display: flex; align-items: center; gap: 15px; }
        .sidebar a:hover { background: #444; border-left: 4px solid #ff0000; }
        
        .content { margin-left: 270px; padding: 40px; }
        .history-card { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        
        h2 { color: #ff0000; margin-bottom: 20px; border-bottom: 2px solid #eee; padding-bottom: 10px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f8f8f8; color: #333; }
        

        .status { padding: 5px 12px; border-radius: 20px; font-size: 13px; font-weight: bold; }
        .pending { background: #fff3cd; color: #856404; }
        .approved { background: #d4edda; color: #155724; }
        .rejected { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>

<div class="sidebar">
    <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
    <a href="donations.php"><i class="fas fa-hand-holding-heart"></i> Donations</a>
    <a href="blood_requests.php"><i class="fas fa-exchange-alt"></i> Blood Requests</a>
    <a href="request_history.php"><i class="fas fa-history"></i> Request History</a>
    <a href="blood_stock.php"><i class="fas fa-layer-group"></i> Blood Stock</a>
</div>

<div class="content">
    <div class="history-card">
        <h2><i class="fas fa-history"></i> Blood Request History</h2>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Hospital Name</th>
                    <th>Blood Group</th>
                    <th>Units (ml)</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td>#<?php echo $row['request_id']; ?></td>
                    <td><?php echo $row['hospital_name']; ?></td>
                    <td style="color:red; font-weight:bold;"><?php echo $row['blood_group']; ?></td>
                    <td><?php echo $row['units_needed']; ?></td>
                    <td><?php echo date('d-M-Y', strtotime($row['request_date'])); ?></td>
                    <td>
                        <?php 
                            $statusClass = strtolower($row['status']);
                            echo "<span class='status $statusClass'>" . $row['status'] . "</span>";
                        ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>