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
    $_SESSION["searchFName"] = $_POST["searchFirstName"];
    header("location: approved-user.php");
    return;
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
    <br><br>
    <h1>Approved User</h1>
    <div class="col-sm-2" style="overflow-y:scroll; height:550px;">
        <div class="form-group">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="text" name="searchFirstName" class="form-control" placeholder="Search...">
                <input type="submit" style="display: none">
            </form>
            </div>
        <?php
            $getName = $_SESSION["searchFName"];
            $conn = mysqli_connect("localhost","root","",$file);
            $sql = "select * from msdata where (verified = '1' or verified = '2') and firstname like '%$getName%'";
            $result = mysqli_query($conn,$sql);

            $server = mysql_connect("localhost","root", "");
            $db =  mysql_select_db($file,$server);
            $query = mysql_query("select * from msdata where (verified = '1' or verified = '2') and firstname like '%$getName%'");
            $nom = 0;
            if(mysqli_num_rows($result)>0){
                echo "<table id = \"data\" class=\"table table-hover\">";
                echo "<tr>";
                echo "<td><b>First Name</b></td>";
                echo "<td style=\"display:none\"><b>L. Name</b></td>";
                echo "<td style=\"display:none\"><b>Ktp</b></td>";
                echo "<td style=\"display:none\"><b>Email</b></td>";
                echo "<td style=\"display:none\"><b>Dob</b></td>";
                echo "<td style=\"display:none\"><b>Address</b></td>";
                echo "<td style=\"display:none\"><b>Nationality</b></td>";
                echo "<td style=\"display:none\"><b>Account Num</b></td>";
                echo "<td style=\"display:none\"><b>Photo</b></td>";
                echo "<td style=\"display:none\"><b>Verified</b></td>";
                echo "</tr>";

                while ($row = mysql_fetch_array($query)) {
                    $getFName   = $row["firstname"];
                    $getLName   = $row["lastname"];
                    $getKtp     = $row["ktp"];
                    $getEmail   = $row["email"];
                    $getDob     = $row["dob"];
                    $getAdd     = $row["address"];
                    $getNation  = $row["nationality"];
                    $getAcc     = $row["accountnum"];
                    $getPhoto   = $row["photo"];
                    $getVerif   = $row["verified"];

                    if($getVerif==1){
                        $getVerif="APPROVED";
                    }
                    else{
                        $getVerif="BLACKLISTED";
                    }

                    echo "<tr onclick=\"settext(this.rowIndex)\">";
                    echo "<td>$getFName</td>";
                    echo "<td style=\"display:none\">$getLName</td>";
                    echo "<td style=\"display:none\">$getKtp</td>";
                    echo "<td style=\"display:none\">$getEmail</td>";
                    echo "<td style=\"display:none\">$getDob</td>";
                    echo "<td style=\"display:none\">$getAdd</td>";
                    echo "<td style=\"display:none\">$getNation</td>";
                    echo "<td style=\"display:none\">$getAcc</td>";
                    echo "<td style=\"display:none\">$getPhoto</td>";
                    echo "<td style=\"display:none\">$getVerif</td>";
                    echo "</tr>";
                }
            }  
        ?>
        </table>
    </div>
    <div style="text-align:left">
        <div class="wrapper col-sm-5">
            <br>
                <div class="form-group">
                    <label>First Name</label><input type="text" id="firstname" class="form-control" value="EMPTY" readonly>
                </div>
                <div class="form-group">
                    <label>KTP</label><input type="text" id="norek" class="form-control" value="EMPTY" readonly>
                </div>
                <div class="form-group">
                    <label>Date of Birth</label><input type="text" id="dob" class="form-control" value="EMPTY" readonly>
                </div>
                <div class="form-group">
                    <label>Account Number</label><input type="text" id="acc" class="form-control" value="EMPTY" readonly>
                </div>
                <div class="form-group">
                    <label>Photo</label><br>
                    <img id ="photo" style="width:540px;height:213px" src="../css/null.png">
                </div>
        </div>
    </div>
    <div style="text-align:left">
        <div class="wrapper col-sm-5">
            <br>
                <div class="form-group">
                    <label>Last Name</label><input type="text" id="lastname" class="form-control" value="EMPTY" readonly>
                </div>
                <div class="form-group">
                    <label>Email</label><input type="text" id="email" class="form-control" value="EMPTY" readonly>
                </div>
                <div class="form-group">
                    <label>Address</label><input type="text" id="address" class="form-control" value="EMPTY" readonly>
                </div>
                <div class="form-group">
                    <label>Nationality</label><input type="text" id="nation" class="form-control" value="EMPTY" readonly>
                </div>
                <div class="form-group">
                    <label>Status</label><input type="text" id="verif" class="form-control" value="EMPTY" readonly>
                </div>
        </div>
    </div>
</body>
</html>

<script type="text/javascript">
    function settext(x){
        var table       = document.getElementById('data');
        var getFirst    = table.rows[x].cells[0].innerHTML;
        var getLast     = table.rows[x].cells[1].innerHTML;
        var getRek      = table.rows[x].cells[2].innerHTML;
        var getEmail    = table.rows[x].cells[3].innerHTML;
        var getDob      = table.rows[x].cells[4].innerHTML;
        var getAdd      = table.rows[x].cells[5].innerHTML;
        var getNat      = table.rows[x].cells[6].innerHTML;
        var getAcc      = table.rows[x].cells[7].innerHTML;
        var getPho      = "data:image/jpeg;base64,"+table.rows[x].cells[8].innerHTML;
        var getVerif    = table.rows[x].cells[9].innerHTML;

        document.getElementById('firstname').value  = getFirst;
        document.getElementById('lastname').value   = getLast;
        document.getElementById('norek').value      = getRek;
        document.getElementById('email').value      = getEmail;
        document.getElementById('dob').value        = getDob;
        document.getElementById('address').value    = getAdd;
        document.getElementById('acc').value        = getAcc;
        document.getElementById('nation').value     = getNat;
        document.getElementById('photo').src        = getPho;
        document.getElementById('verif').value        = getVerif;
    }
</script>