<?php
session_start();
$file = file_get_contents('bcainstance');

if(!isset($_SESSION["loggedin"])){
    header("location: ../login.php");
    return;
}
if($_SESSION["role"] != 1){
    if($_SESSION["role"] == 2){
        header("location: welcome.php");
        return;
    }
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
    unset($_SESSION["ResultID"]);
    header("location: authorize-user.php");
    return;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Authorize Result</title>
    <link rel="shortcut icon" href="../css/Logo.png">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css.map">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css.map">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap-theme.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap-theme.css.map">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap-theme.min.css.map">
    <script src="../js/bootstrap.js"></script> 
    <script src="../js/bootstrap.min.js"></script> 
    <script src="../js/npm.js"></script> 
    <script src="../js/jquery.min.js"></script> 
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">
                    <img style="max-width:40px; margin-top: -10px;" src="../css/Logo.png">
                </a>
            </div>
                <ul class="nav navbar-nav navbar-left">
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="#" id="date">
                            <script>
                                document.getElementById("date").innerHTML = new Date().toDateString();
                            </script>
                        </a>
                    </li>
                    <li><a href="#">Hi, <?php echo htmlspecialchars($_SESSION["username"]);?></a></li>
                    <li><a href="../logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
                </ul>
        </div>
    </nav>
    <br><br><br><br>
    <?php 
        $resultID = $_SESSION["ResultID"];
        $conn = mysqli_connect("localhost","root","",$file);
        $sql = "select * from msdata where ktp = '$resultID'";
        $result = mysqli_query($conn,$sql);

        $server = mysql_connect("localhost","root", "");
        $db =  mysql_select_db($file,$server);
        $query = mysql_query("select * from msdata where ktp = '$resultID'");
        if(mysqli_num_rows($result)>0){
            while ($row = mysql_fetch_array($query)) {
                $getResultFirstName     = $row["firstname"];
                $getResultLastName      = $row["lastname"];
                $getResultNoKtp         = $row["ktp"];
                $getResultEmail         = $row["email"];
                $getResultDOB           = $row["dob"];
                $getResultAddress       = $row["address"];
                $getResultNationality   = $row["nationality"];
                $getResultAccountNum    = $row["accountnum"];
                $getResultPhoto         = $row["photo"];
            }
        }
    ?>
    <div class="col-sm-4"></div>
    <div style="text-align:left" class="col-sm-4">
        <center><h3>New user has been approved.</h3></center><br>
        <table class="table table-bordered" >
            <tr>
                <td style="width:155px"><b>First Name</b></td>
                <td><?php echo htmlspecialchars($getResultFirstName);?></td>
            </tr>
            <tr>
                <td><b>Last Name</b></td>
                <td><?php echo htmlspecialchars($getResultLastName);?></td>
            </tr>
            <tr>
                <td><b>No. KTP</b></td>
                <td><?php echo htmlspecialchars($getResultNoKtp);?></td>
            </tr>
            <tr>
                <td><b>Email</b></td>
                <td><?php echo htmlspecialchars($getResultEmail);?></td>
            </tr>
            <tr>
                <td><b>Date of Birth</b></td>
                <td><?php echo htmlspecialchars($getResultDOB);?></td>
            </tr>
            <tr>
                <td><b>Address</b></td>
                <td><?php echo htmlspecialchars($getResultAddress);?></td>
            </tr>
            <tr>
                <td><b>Nationality</b></td>
                <td><?php echo htmlspecialchars($getResultNationality);?></td>
            </tr>
            <tr>
                <td><b>Account Number</b></td>
                <td><?php echo htmlspecialchars($getResultAccountNum);?></td>
            </tr>
            <tr>
                <?php 
                $append = "data:image/jpeg;base64,";
                $photoresult = $append.$getResultPhoto;
                ?>
                <td><b>Photo</b></td>
                <td><img id ="photo" style="width:360px;height:180px" src="<?php echo htmlspecialchars($photoresult);?>"></td>
            </tr>
        </table>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <center><input class="btn btn-success" type="submit" value="Return"></center>
        <form>
    <br><br><br><br>
    </div>

    <div class="col-sm-4"></div>
</body>
</html>