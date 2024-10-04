<?php
include("databse.php");
session_start();
echo $_SESSION["sess_id"];
echo  $_SESSION["sess_PtntID"];//patient Id
echo $_SESSION["sess_PTID"];//therapoist ID
$var_notif ="SELECT * FROM tbl_notifications WHERE user_id=".$_SESSION["sess_id"];
$var_qry = mysqli_query($var_conn,$var_notif);
$var_slctdID="";


?>
<html>
    <head>
        <title>Notification</title>
    </head>
    <body>
        <a href="PatientHomePage.php"><=BACK</a>
        <form method="POST" action="PATnotif.php">
        <table style="border:1px solid black;border-collapse:collapse">
            <tr>
                <th>Notification</th>
            </tr>
            
            <?php
                while($var_rec= mysqli_fetch_array($var_qry)){
                   
                    ?>
                    <tr>
                    <td style="border: 1px solid black;">
                        <?php echo "<button type='submit' name='BtnPatView' value='".$var_rec["appointment_id"]."
                        '"." ;\">"
                        .$var_rec["type"]."</button>";?>
                    </tr>
                    <?php
                    
                }
                if(isset($_POST["BtnPatView"])){
                    $_SESSION["sess_APID"] = $_POST["BtnPatView"];
                   
                    header("location: PATPTprofview.php");
                }
            ?>
          
        </table>
        </form>
    </body>
</html>