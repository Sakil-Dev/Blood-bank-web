<?php
session_start();
include 'db_connect.php';


if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$query = "SELECT * FROM blood_stock";
$result = mysqli_query($conn, $query);

while($row = mysqli_fetch_assoc($result)) {
    echo "Group: " . $row['blood_group'] . " - Stock: " . $row['total_units'] . " ml<br>";
}

$blood_groups = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blood Stock Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f7f6; margin: 0; }
        .sidebar { width: 250px; background: #2c2c2c; height: 100vh; position: fixed; padding-top: 20px; }
        .sidebar a { color: white; display: block; padding: 15px 25px; text-decoration: none; display: flex; align-items: center; gap: 15px; }
        .sidebar a:hover { background: #444; border-left: 4px solid #ff0000; }
        
        .content { margin-left: 270px; padding: 40px; }
        .stock-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; }
        
        
        .stock-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            border-top: 5px solid #ff0000;
            position: relative;
            transition: 0.3s;
        }

        .low-stock {
            border: 2px solid #ff0000;
            background-color: #fff5f5;
        }

        .blood-name { font-size: 28px; font-weight: bold; color: #333; margin-bottom: 10px; }
        .amount { font-size: 20px; color: #666; }
        .unit { font-size: 14px; color: #999; }
        
        .alert-text {
            color: #ff0000;
            font-size: 12px;
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }

        .header-title { color: #ff0000; display: flex; align-items: center; gap: 10px; margin-bottom: 30px; }
    </style>
</head>
<body>

<div class="sidebar">
    <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
    <a href="donations.php"><i class="fas fa-hand-holding-heart"></i> Donations</a>
    <a href="blood_requests.php"><i class="fas fa-exchange-alt"></i> Blood Requests</a>
    <a href="request_history.php"><i class="fas fa-history"></i> Request History</a>
    <a href="blood_stock.php" style="background:#444; border-left:4px solid #ff0000;"><i class="fas fa-layer-group"></i> Blood Stock</a>
</div>

<div class="content">
    <h2><i class="fas fa-database"></i> Live Blood Stock Status</h2>
<div class="stock-grid">
    <?php
    foreach($blood_groups as $bg) {
        echo "
        <div class='stock-card'>
            <h1 style='color:red'>$bg <i class='fas fa-tint'></i></h1>
            <h3>Stock: 450 ml</h3> <progress value='45' max='100'></progress> 
        </div>";
    }
    ?>
<?php foreach ($bloodStock as $item): 
    $group = $item['group'];
    $stock = $item['stock'];
    $isLow = $stock < 500;
?>
    <div class="stock-card <?php echo $isLow ? 'low-stock' : ''; ?>">
        <div class="blood-name"><?php echo $group; ?></div>
        <div class="amount"><?php echo $stock; ?> <span class="unit">ml</span></div>

        <?php if ($isLow): ?>
            <span class="alert-text">
                <i class="fas fa-exclamation-triangle"></i> LOW STOCK!
            </span>
        <?php else: ?>
            <span style="color: green; font-size: 12px; margin-top: 10px; display: block;">
                <i class="fas fa-check-circle"></i> Sufficient
            </span>
        <?php endif; ?>
    </div>
<?php endforeach; ?>

</body>
</html>