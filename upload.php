<?php
if ($_FILES['uploadfile']['error'] === UPLOAD_ERR_OK) {
	$file = fopen($_FILES["uploadfile"]["tmp_name"], "r") or die("無法開啟檔案!");

	// Connect to SQL server
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "invoice_system";
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

	// skip first two line
	fgets($file);
	fgets($file);

	// Insert to database
	while (($line = fgets($file)) !== false) {
		$arr = explode("|", $line);
		if ($arr[0] == "M") {
			$sql = "INSERT INTO `invoice`(`cardName`, `cardNo`, `invDate`, `sellerBan`, `sellerName`, `invNum`, `amount`, `invStatus`) VALUES ('" . mysqli_real_escape_string($conn, $arr[1]) . "','" . mysqli_real_escape_string($conn, $arr[2]) . "','" . mysqli_real_escape_string($conn, $arr[3]) . "','" . mysqli_real_escape_string($conn, $arr[4]) . "','" . mysqli_real_escape_string($conn, $arr[5]) . "','" . mysqli_real_escape_string($conn, $arr[6]) . "','" . mysqli_real_escape_string($conn, $arr[7]) . "','" . mysqli_real_escape_string($conn, $arr[8]) . "')";
			if (!mysqli_query($conn, $sql)) {
				die("無法加入資料!");
			}
		} else if ($arr[0] == "D") {
			$invPeriod = explode("-", $_POST['invPeriod']);
			$sql = "INSERT INTO `detail`(`invPeriod`, `invNum`, `amount`, `description`) VALUES ('" . mysqli_real_escape_string($conn, $invPeriod[0] . $invPeriod[1]) . "','" . mysqli_real_escape_string($conn, $arr[1]) . "','" . mysqli_real_escape_string($conn, $arr[2]) . "','" . mysqli_real_escape_string($conn, $arr[3]) . "')";
			if (!mysqli_query($conn, $sql)) {
				die("無法加入資料!");
			}
		} else {
			die("上傳的資料有誤");
		}
	}
} else {
	header('Location: upload_invoice.html');
}
?>
<!doctype html>
<html lang="zh-tw">

<head>
	<meta charset="UTF-8">
	<script>
		alert("上傳成功!");
		window.location.replace("upload_invoice.html");
	</script>
</head>

<body>
</body>

</html>
