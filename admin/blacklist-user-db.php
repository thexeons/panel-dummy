<?php
session_start();
if(isset($_POST['blacklist'])){
	$getCurrId = $_POST['id'];
	$_SESSION["BlackListID"] = $getCurrId;

	$conn = new mysqli("localhost","root","","bcabank");
	$sql = "UPDATE msdata set verified = '2' where ktp = '$getCurrId'";
	$conn->query($sql);
	$conn->close();

	header("location: blacklist-user-result.php");
	return;
}

?>