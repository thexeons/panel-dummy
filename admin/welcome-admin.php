<?php
session_start();
 
$_SESSION["searchFName"] = "";
$_SESSION["verified1"] = "1";
$_SESSION["verified2"] = "2";

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
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome Admin</title>
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
                <a class="navbar-brand" href="welcome-admin.php">
                    <img style="max-height:40px; margin-top: -10px;" src="../css/Logo.png">
                </a>
            </div>
                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <a href="authorize-user.php">Authorize User</a>
                    </li>
                    <li>
                        <a href="update-user.php">Pending Update</a>
                    </li>
                    <li>
                        <a href="approved-user.php">Approved User</a>
                    </li>
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
    <br><br>
    <h1>Dashboard</h1>
    <br><br><br><br><br>
    

    <?php
        $file = file_get_contents('bcainstance');
        $conn = new mysqli("localhost", "root", "", $file);
        $sql = "select count(*) as listrow from mstemp";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $pendingUpdate = $row['listrow'];
            }
        }

        $conn = new mysqli("localhost", "root", "", $file);
        $sql = "select count(*) as listrow from msdata where verified='0'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $pendingUser = $row['listrow'];
            }
        }

        $conn->close();
    ?>

    <div class="container">
        <div class="col-sm-2"></div> 
            <div class="col-sm-8">
                <div> <h3>Hi, <?php echo htmlspecialchars($_SESSION['username']);?> you have: </h3> </div><br>
                <div> <h3> <b><?php echo "$pendingUser";?></b> pending user(s)</h3> </div>
                <div> <h3> <b><?php echo "$pendingUpdate";?></b> pending update(s)</h3> </div>
                <div> <h3> waiting for you.</h3> </div>
                <div> <h3> Have a nice day.</h3> </div>
            </div> 
        <div class="col-sm-2"></div> 

    </div>

</body>
</html>