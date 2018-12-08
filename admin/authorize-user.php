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
    <script type="text/javascript" src="../js/jquery.min.js"></script> 
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">
                    <img style="max-height:40px; margin-top: -10px;" src="../css/Logo.png">
                </a>
            </div>
                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <a href="authorize-user.php">Authorize User</a>
                    </li>
                    <li>
                        <a href="blacklist-user.php">Blacklist User</a>
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
    <br><br><br><br>
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
        <?php
            $conn = mysqli_connect("localhost","root","",$file);
            $sql = "select * from msdata where verified = '0'";
            $result = mysqli_query($conn,$sql);

            $server = mysql_connect("localhost","root", "");
            $db =  mysql_select_db($file,$server);
            $query = mysql_query("select * from msdata where verified = '0'");

            if(mysqli_num_rows($result)>0){

                echo "<h1>Pending user.</h1>";
                echo "<br>";
                echo "<table class=\"table table-hover\">";
                echo "<thead>";
                echo "<tr class=\"header\">";
                echo "<td style=\"text-align:center;vertical-align:middle;\" class=\"col-sm-1\"><b>KTP</b></td>";
                echo "<td style=\"text-align:center;vertical-align:middle;\" class=\"col-sm-2\"><b>First Name</b></td>";
                echo "<td style=\"text-align:center;vertical-align:middle;\" class=\"col-sm-2\"><b>Last Name</b></td>";
                echo "<td class=\"col-sm-1\"></td>";
                echo "</tr>";
                echo "</thead>";

                $i = 0;
                while ($row = mysql_fetch_array($query)) {
                $getID = $row["ktp"];
                $getFirstName = $row["firstname"];
                $getLastName = $row["lastname"];
                $getKTP = $row['ktp'];
                $getEmail = $row['email'];
                $getDOB = $row['dob'];
                $getAddress = $row['address'];
                $getAccount = $row['accountnum'];
                $getNation = $row['nationality'];
                $getPhoto = $row['photo'];

                $class = ($i == 0) ? "" : "alt";
                echo "<form action=\"authorize-user-db.php\" method=\"post\" enctype=\"multipart/form-data\">";
                echo "<tr class=\"".$class."\">";
                echo "<td data-toggle=\"modal\" data-target=\"#$getID\" style=\"text-align:center;vertical-align:middle;width:90px\">".$row["ktp"]."</td>";
                echo "<td style=\"text-align:center;vertical-align:middle;\">".$row["firstname"]."</td>";
                echo "<td style=\"text-align:center;vertical-align:middle;\">".$row["lastname"]."</td>";
                echo "<td>
                <input type=\"hidden\" name =\"id\" value=\"$getID\">
                <input type=\"submit\" class=\"btn btn-success\" value=\"&#x2714;\" name =\"authorize\">
                <input type=\"submit\" class=\"btn btn-danger\" value=\"&#x2716;\" name =\"reject\">
                </td>";
                echo "</form>";
                echo "</tr>";


                //This is modal header
                echo "<div id=\"$getID\" class=\"modal fade\" role=\"dialog\">";
                echo "<div class=\"modal-dialog modal-lg\">";
        
                echo "<div class=\"modal-content\">";
                echo "<div class=\"modal-header\">";
                echo "<h4 \class=\"modal-title\">$getID - $getFirstName $getLastName</h4>";
                echo "</div>";
                echo "<div class=\"modal-body\">";
                echo "<div style=\"text-align:left\">";

                //This is modal body Line 1
                echo "<div class=\"form-inline\">";
                echo "<div class=\"form-group\">";
                echo "<label style=\"width:170px\">First Name</label>";
                echo "<input style=\"width:230px\"type=\"text\" class=\"form-control\" value=\"$getFirstName\" readonly>";
                echo "</div>";
                echo "<label  style=\"width:30px\"> </label>";
                echo "<div class=\"form-group\">";
                echo "<label  style=\"width:170px\">Last Name</label>";
                echo "<input  style=\"width:230px\" type=\"text\" class=\"form-control\" value=\"$getLastName\" readonly>";
                echo "</div>";
                echo "</div><br>";

                //This is modal body Line 2
                echo "<div class=\"form-inline\">";
                echo "<div class=\"form-group\">";
                echo "<label style=\"width:170px\">KTP</label>";
                echo "<input style=\"width:230px\"type=\"text\" class=\"form-control\" value=\"$getKTP\" readonly>";
                echo "</div>";
                echo "<label  style=\"width:30px\"> </label>";
                echo "<div class=\"form-group\">";
                echo "<label  style=\"width:170px\">Email</label>";
                echo "<input  style=\"width:230px\" type=\"text\" class=\"form-control\" value=\"$getEmail\" readonly>";
                echo "</div>";
                echo "</div><br>";

                //This is modal body Line 3
                echo "<div class=\"form-inline\">";
                echo "<div class=\"form-group\">";
                echo "<label style=\"width:170px\">DOB</label>";
                echo "<input style=\"width:230px\"type=\"text\" class=\"form-control\" value=\"$getDOB\" readonly>";
                echo "</div>";
                echo "<label  style=\"width:30px\"> </label>";
                echo "<div class=\"form-group\">";
                echo "<label  style=\"width:170px\">Address</label>";
                echo "<input  style=\"width:230px\" type=\"text\" class=\"form-control\" value=\"$getAddress\" readonly>";
                echo "</div>";
                echo "</div><br>";

                //This is modal body Line 4
                echo "<div class=\"form-inline\">";
                echo "<div class=\"form-group\">";
                echo "<label style=\"width:170px\">Nationality</label>";
                echo "<input style=\"width:230px\"type=\"text\" class=\"form-control\" value=\"$getNation\" readonly>";
                echo "</div>";
                echo "<label  style=\"width:30px\"> </label>";
                echo "<div class=\"form-group\">";
                echo "<label  style=\"width:170px\">Account Num</label>";
                echo "<input  style=\"width:230px\" type=\"text\" class=\"form-control\" value=\"$getAccount\" readonly>";
                echo "</div>";
                echo "</div><br>";

                //This is modal body Line 5
                echo "<div class=\"form-inline\">";
                echo "<div class=\"form-group\">";
                echo "<label style=\"width:170px\">Photo</label>";

                $append = "data:image/jpeg;base64,";
                $photoresult = $append.$getPhoto;
                ?>

                <img id ="photo" style="width:660px;height:300px" src="<?php echo "$photoresult";?>">
                <?php
                
                echo "</div><br>";

                echo "</div>";
                echo "</div>";
                echo "<div class=\"modal-footer\">";
                echo "<button type=\"button\" class=\"btn btn-primary\" data-dismiss=\"modal\">Close Form</button>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                //End modal

                $i = ($i==0) ? 1:0;
                }
            }
            else {
                echo "<h1>No Pending user.</h1>";
            }
        ?>
    </table>
    </div>

    <div class="col-sm-3"></div>
</body>
</html>