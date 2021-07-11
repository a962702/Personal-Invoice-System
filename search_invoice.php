<?php
if((!isset($_GET['invDate_from']) || $_GET['invDate_from'] == "")
	&& (!isset($_GET['invDate_to']) || $_GET['invDate_to'] == "")
	&& (!isset($_GET['sellerName']) || $_GET['sellerName'] == "")
	&& (!isset($_GET['invNum']) || $_GET['invNum'] == "")
	&& (!isset($_GET['amount_from']) || $_GET['amount_from'] == "")
	&& (!isset($_GET['amount_to']) || $_GET['amount_to'] == "")
){
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
$sql = "SELECT * FROM `invoice` WHERE 1";
if((isset($_GET['invDate_from']) && $_GET['invDate_from'] != "") && (isset($_GET['invDate_to']) && $_GET['invDate_to'] != "")){
	$sql = $sql . " AND `invDate` BETWEEN '" . $_GET['invDate_from'] . "' AND '" . $_GET['invDate_to'] . "'";
}
if(isset($_GET['sellerName']) && $_GET['sellerName'] != ""){
	$sql = $sql . " AND `sellerName` LIKE '%" . $_GET['sellerName'] . "%'";
}
if(isset($_GET['invNum']) && $_GET['invNum'] != ""){
	$sql = $sql . " AND `invNum` LIKE '%" . $_GET['invNum'] . "%'";
}
if((isset($_GET['amount_from']) && $_GET['amount_from'] != "") && (isset($_GET['amount_to']) && $_GET['amount_to'] != "")){
	$sql = $sql . " AND `amount` BETWEEN '" . $_GET['amount_from'] . "' AND '" . $_GET['amount_to'] . "'";
}
$sql = $sql . " ORDER BY `invDate` DESC";
$result = mysqli_query($conn, $sql) or die("Search failed!");
$output = mysqli_fetch_all($result, MYSQLI_ASSOC);
echo json_encode($output);
?>
