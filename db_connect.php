<?php
$conn = mysqli_connect("localhost", "root", "", "blood bank");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>