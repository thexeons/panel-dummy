<?php
session_start();
$file = file_get_contents('bcainstance');

if(isset($_POST['authorize'])){
	$getCurrId = $_POST["id"];

	$_SESSION["ResultID"] = $getCurrId;
	$thisAdmin = $_SESSION["id"];

	$conn = new mysqli("localhost","root","",$file);
	$sql = "UPDATE msdata set verified = '1',adminid='$thisAdmin' where ktp = '$getCurrId'";
	$conn->query($sql);
	$conn->close();

	$conn = new mysqli("localhost", "root", "", $file);
    $sql = "select * from msdata where ktp='$getCurrId'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $getFirst = $row['firstname'];
            $getLast  = $row['lastname'];
            $getKtp   = $row['ktp'];
            $getEmail = $row['email'];
            $getDob   = $row['dob'];
            $getAddr  = $row['address'];
            $getNatio = $row['nationality'];
            $getAccN  = $row['accountnum'];
			$getPhot  = $row['photo'];
			$getVerif  = $row['verified'];
        }
    }

    $conn->close();

	$service_url = "localhost:8090/acceptBlock";
	$data = array(
		"firstname"=>$getFirst,
		"lastname"=>$getLast,
		"ktp"=>$getKtp,
		"email"=>$getEmail,
		"dob"=>$getDob,
		"address"=>$getAddr,
		"nationality"=>$getNatio,
		"accountnum"=>$getAccN,
		"photo"=>$getPhot,
		"verified"=>$getVerif,
		"bcabank"=>"0",
		"bcainsurance"=>"1",
		"bcafinancial"=>"0",
		"bcasyariah"=>"0",
		"bcasekuritas"=>"0"
	);

	$data_string = json_encode($data);

	$curl= curl_init($service_url);
	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array(
	  'Content-Type: application/json',
	  'Content-Length: ' . strlen($data_string))
	);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	$result = curl_exec($curl);
	echo $result;


	header("location: authorize-user-result.php");
	return;
}
else if(isset($_POST['reject'])){
	$getCurrId = $_POST["id"];

	$conn = new mysqli("localhost", "root", "", $file);
    $sql = "select * from msdata where ktp='$getCurrId'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $getFirst = $row['firstname'];
            $getLast  = $row['lastname'];
            $getKtp   = $row['ktp'];
            $getEmail = $row['email'];
            $getDob   = $row['dob'];
            $getAddr  = $row['address'];
            $getNatio = $row['nationality'];
            $getAccN  = $row['accountnum'];
			$getPhot  = $row['photo'];
			$getVerif  = $row['verified'];
        }
    }

    $sqlx = "delete from msdata where ktp ='$getCurrId'";
    $resultx = $conn->query($sqlx);

    $conn->close();

	$service_url = "localhost:8090/rejectBlock";
	$data = array(
		"firstname"=>$getFirst,
		"lastname"=>$getLast,
		"ktp"=>$getKtp,
		"email"=>$getEmail,
		"dob"=>$getDob,
		"address"=>$getAddr,
		"nationality"=>$getNatio,
		"accountnum"=>$getAccN,
		"photo"=>$getPhot,
		"verified"=>$getVerif,
		"bcabank"=>"1",
		"bcainsurance"=>"0",
		"bcafinancial"=>"0",
		"bcasyariah"=>"0",
		"bcasekuritas"=>"0"
	);

	$data_string = json_encode($data);

	$curl= curl_init($service_url);
	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array(
	  'Content-Type: application/json',
	  'Content-Length: ' . strlen($data_string))
	);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	$result = curl_exec($curl);
	echo $result;
	header("location: authorize-user.php");
	return;
}
?>