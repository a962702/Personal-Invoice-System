<?php
if((!isset($_GET['productName']) || $_GET['productName'] == "") && (!isset($_GET['description']) || $_GET['description'] == "")){
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
if (isset($_GET['productName']) && $_GET['productName'] != "")$sql = "SELECT * FROM `detail` WHERE `description` LIKE '%" . $_GET['productName'] . "%'";
else if (isset($_GET['description']) && $_GET['description'] != "")$sql = "SELECT detail.*, invoice.invDate, invoice.sellerName FROM `detail` LEFT JOIN invoice ON invoice.invNum = detail.invNum WHERE `description` = '" . $_GET['description'] . "' ORDER BY invDate DESC";
//echo $sql;
$result = mysqli_query($conn, $sql) or die("Search failed!");
$output = mysqli_fetch_all($result, MYSQLI_ASSOC);
echo json_encode($output);
?>
