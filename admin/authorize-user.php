<?php
session_start();
 
if(!isset($_SESSION["loggedin"])){
    header("location: login.php");
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
                <a class="navbar-brand" href="#">
                    <img style="max-width:40px; margin-top: -10px;" src="../css/Logo.png">
                </a>
            </div>
                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <a href="authorize-user.php">Authorize User</a>
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
    <br><br><br><br>
    <div class="col-sm-12">
        <?php
            $conn = mysqli_connect("localhost","root","","bcabank");
            $sql = "select * from msdata where verified = '0'";
            $result = mysqli_query($conn,$sql);

            $server = mysql_connect("localhost","root", "");
            $db =  mysql_select_db("bcabank",$server);
            $query = mysql_query("select * from msdata where verified = '0'");

            if(mysqli_num_rows($result)>0){

                echo "<h1>Pending user.</h1>";
                echo "<br>";
                echo "<table class=\"table table-hover\">";
                echo "<thead>";
                echo "<tr class=\"header\">";
                echo "<td style=\"text-align:left;vertical-align:middle;\"><b>F. Name</b></td>";
                echo "<td style=\"text-align:left;vertical-align:middle;\"><b>L. Name</b></td>";
                echo "<td style=\"text-align:left;vertical-align:middle;\"><b>KTP</b></td>";
                echo "<td style=\"text-align:left;vertical-align:middle;\"><b>Acc. Num.</b></td>";
                echo "<td style=\"text-align:left;vertical-align:middle;\"><b>Email</b></td>";
                echo "<td style=\"text-align:left;vertical-align:middle;\"><b>DOB</b></td>";
                echo "<td style=\"text-align:left;vertical-align:middle;\"><b>Address</b></td>";
                echo "<td style=\"text-align:left;vertical-align:middle;\"><b>Nationality</b></td>";
                echo "</tr>";
                echo "</thead>";

                $i = 0;
                while ($row = mysql_fetch_array($query)) {
                $getID = $row["ktp"];

                $class = ($i == 0) ? "" : "alt";
                echo "<form action=\"authorize-user-db.php\" method=\"post\" enctype=\"multipart/form-data\">";
                echo "<tr class=\"".$class."\">";
                echo "<td style=\"text-align:left;vertical-align:middle;width:90px\">".$row["firstname"]."</td>";
                echo "<td style=\"text-align:left;vertical-align:middle;\">".$row["lastname"]."</td>";
                echo "<td style=\"text-align:left;vertical-align:middle;\">".$row["ktp"]."</td>";
                echo "<td style=\"text-align:left;vertical-align:middle;\">".$row["accountnum"]."</td>";
                echo "<td style=\"text-align:left;vertical-align:middle;\">".$row["email"]."</td>";
                echo "<td style=\"text-align:left;vertical-align:middle;\">".$row["dob"]."</td>";
                echo "<td style=\"text-align:left;vertical-align:middle;\">".$row["address"]."</td>";
                echo "<td style=\"text-align:left;vertical-align:middle;\">".$row["nationality"]."</td>";
                echo "<td>
                <input type=\"hidden\" name =\"id\" value=\"$getID\">
                <input type=\"submit\" class=\"btn btn-success\" value=\"&#x2714;\" name =\"authorize\">
                <input type=\"submit\" class=\"btn btn-danger\" value=\"&#x2716;\" name =\"reject\">
                </td>";
                echo "</form>";
                echo "</tr>";
                $i = ($i==0) ? 1:0;
                }
            }
            else {
                echo "<h1>No Pending user.</h1>";
            }
        ?>
    </table>
    </div>
</body>
</html>