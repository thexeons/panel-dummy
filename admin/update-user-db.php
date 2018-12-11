<?php
session_start();
$file = file_get_contents('bcainstance');

if(isset($_POST['verifyUpdate'])){
	$getCurrId = $_POST['id'];

	$conn = new mysqli("localhost","root","",$file);
	$sql = "DELETE from msdata where ktp ='$getCurrId'";
	$conn->query($sql);
	$conn->close();
	
	$conn = new mysqli("localhost", "root", "", $file);
    $sql = "select * from mstemp where ktp='$getCurrId'";
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
        }
    }

    $conn = new mysqli("localhost", "root", "", $file);
    $sql = "insert into msdata (firstname,lastname,ktp,email,dob,address,nationality,accountnum,photo,verified) values ('$getFirst','$getLast','$getKtp','$getEmail','$getDob','$getAddr','$getNatio','$getAccN','$getPhot','1')";
    $result = $conn->query($sql);
	

    $conn = new mysqli("localhost", "root", "", $file);
    $sql = "delete from mstemp where ktp ='$getCurrId'";
    $result = $conn->query($sql);
        

    $conn->close();



	$service_url = "localhost:8090/confirmUpdate";
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
		"verified"=>"1",
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

	header("location: update-user.php");
	return;
}
else if(isset($_POST['xd'])){
	header("location: welcome-admin.php");
	return;	
}
?>