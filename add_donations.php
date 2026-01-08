<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id'])) {
    $donor_id = $_GET['id'];
    $res = mysqli_query($conn, "SELECT * FROM donors WHERE donor_id = '$donor_id'");
    $donor = mysqli_fetch_assoc($res);
    if (!$donor) { die("Donor not found!"); }
}

if (isset($_POST['submit'])) {
    $d_id = $_POST['donor_id'];
    $b_group = $_POST['blood_group'];
    $amount = $_POST['amount'];
    $d_date = $_POST['donation_date'];

    $q1 = "INSERT INTO donations (donor_id, blood_group, amount, donation_date) VALUES ('$d_id', '$b_group', '$amount', '$d_date')";

    $q2 = "UPDATE blood_stock SET amount = amount + $amount WHERE blood_group = '$b_group'";

    if (mysqli_query($conn, $q1) && mysqli_query($conn, $q2)) {
        echo "<script>alert('Donation successful!'); window.location='dashboard.php?view=donations';</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Donation</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; display: flex; justify-content: center; padding-top: 50px; }
        .box { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 350px; border-top: 5px solid red; }
        input { width: 100%; padding: 10px; margin: 10px 0; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: red; color: white; border: none; cursor: pointer; font-weight: bold; }
    </style>
</head>
<body>
    <div class="box">
        <h2 style="color:red; text-align:center;">Add Donation</h2>
        <form method="POST">
            <input type="hidden" name="donor_id" value="<?php echo $donor['donor_id']; ?>">
            <p>Donor: <b><?php echo $donor['name']; ?></b></p>
            <p>Group: <b><?php echo $donor['blood_group']; ?></b></p>
            <input type="hidden" name="blood_group" value="<?php echo $donor['blood_group']; ?>">
            <label>Amount (ml):</label>
            <input type="number" name="amount" placeholder="450" required>
            <label>Date:</label>
            <input type="date" name="donation_date" value="<?php echo date('Y-m-d'); ?>" required>
            <button type="submit" name="submit">Save Donation</button>
            <a href="dashboard.php" style="display:block; text-align:center; margin-top:10px; text-decoration:none; color:gray;">Cancel</a>
        </form>
    </div>
</body>
</html>