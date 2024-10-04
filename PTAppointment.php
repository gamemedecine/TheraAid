<?php
include("databse.php");
$var_TID = 3;
$var_SclctAppntment = "SELECT * FROM tbl_appointment WHERE rate = 0 AND
therapists_id=".$var_TID;

$var_Session = "";
$var_Pyment = "";
$var_Time = "";
$var_Agreed = "";
$var_rate="";
$var_AID = "";
$var_PID="";
$var_Rate="";
$var_qry=mysqli_query($var_conn,$var_SclctAppntment);
if(mysqli_num_rows($var_qry)>0){
    while($var_rec = mysqli_fetch_array($var_qry)){
        $var_Session= $var_rec["num_of_session"];
        $var_Pyment= $var_rec["payment_type"];
        $var_Time= $var_rec["time_selected"];
        $var_Agreed= $var_rec["is_aggreed"];
        $var_AID = $var_rec["appointment_id"];
    }

}else{
    echo "Not OK";
}

if(isset($_POST["BtnSubmit"])){
    $var_Rate = trim($_POST["Txtrate"]);

    $var_updte = "UPDATE tbl_appointment SET rate= '$var_Rate' WHERE appointment_id =' $var_AID'";
    $var_updtqry = mysqli_query($var_conn,$var_updte);

    if($var_updtqry){
        echo "Success";
    }
    else{
        echo "Error";
    }
}

?>
<html>
    <head>
        <title>therapists Appointment</title>
    </head>
    <body>
        <form method="POST" action="PTAppointment.php">
            <p>Session :<?php echo $var_Session?></p>
            <p>Payment Type: <?php echo $var_Pyment?></p>
            <p>Time:<?php echo $var_Time?></p>
            <p>Terms: <?php echo $var_Agreed?></p>
            <lalbel>Rate: </lalbel><input type="text" name="Txtrate" value="<?php echo  $var_Rate;?>">
            <br><input type="submit" value="submit" name="BtnSubmit">

        </form>
    </body>
</html>