<?php
include("databse.php");

$var_pID=7;

if(isset($_POST["BtnSubmit"])){
    $var_Session = trim($_POST["TxtSession"]);
    $var_Ptype = trim($_POST["TxtPaymentType"]);
    $var_Date = trim($_POST["TxtDate"]);
    $var_radBtn = $_POST["is_agreed"];

    $PID = 7;
    $TID = 3;
    $schedID = 80;

    $var_insrt = "INSERT INTO tbl_appointment (num_of_session, payment_type, 
    time_selected,is_aggreed,therapists_id,patient_id,sched_id)
    VALUES('$var_Session','$var_Ptype','$var_Date','$var_radBtn',$TID,$PID,$schedID)";
    $var_qry = mysqli_query($var_conn,$var_insrt);
    if( $var_qry){

    }
    else{
        echo "Error";
    }



}

?>
<html>
    <head>
        <title>Patient Appointment</title>
    </head>
    <body>
        <form method="POST" action="patientAppointment.php">
           <label>Number Of Session: </label><input type="text" name="TxtSession"> <br><br>
           <label>Payment Type: </label><input type="text" name="TxtPaymentType"> <br><br>
           <label>Date: </label><input type="text" name="TxtDate"> <br><br>
           <input type="radio" name="is_agreed" value="Agreed" /> <label>Agree</label>

            <input type="submit" value="submit" name="BtnSubmit">

        </form>
    </body>
</html>