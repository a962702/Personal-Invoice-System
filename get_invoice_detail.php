<?php
if(!isset($_GET['invNum']) || $_GET['invNum'] == ""){
	die("Invaild request!");
}

// Connect to SQL server
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "invoice_system";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}
$sql = "SELECT * FROM `detail` WHERE `invNum` = '" . $_GET['invNum'] . "'";
$result = mysqli_query($conn, $sql) or die("Search failed!");
$output = mysqli_fetch_all($result, MYSQLI_ASSOC);
echo json_encode($output);
?>
