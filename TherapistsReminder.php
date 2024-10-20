<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Therapists Reminder</title>
</head>
<?php
include("databse.php");
session_start();

$var_UserId=$_SESSION["sess_id"];
$var_crrntDate = "2024-10-14";
echo $var_crrntDate;//chnage it to a static value for testing 
$var_Rmndr = "SELECT RM.reminder_date,
                    RM.reminder_messsage,
                    RM.reminder_status,
                    AP.num_of_session,
                    AP.payment_type,
                    AP.start_date,
                    AP.start_date,
                    AP.appointment_id,
                    SC.start_time,
                    SC.day,
                    SC.end_time,
                    SC.note,
                    CONCAT(U.Fname,' ',U.Mname,' ',U.Lname) AS Pat_fllname,
                    U.profilePic,
                    P.patient_id,
                    PT.case_handled
                    FROM tbl_reminder RM 
					JOIN tbl_appointment AP ON AP.appointment_id = RM.appointment_id
					JOIN tbl_patient P ON AP.patient_id = P.patient_id
					JOIN tbl_therapists PT ON AP.therapists_id = PT.therapist_id
					JOIN tbl_user U ON U.User_id = P.user_id
					JOIN tbl_sched SC ON AP.schedle_id = SC.shed_id
					WHERE  PT.user_id =$var_UserId";
$var_rmndrqry = mysqli_query($var_conn,$var_Rmndr);
$var_data = "";
$var_listDate = [];
$_SESSION["sess_PATID"] = "";
if(isset($_POST["BtnSession"])){
    $_SESSION["sess_PATID"] = $_POST["BtnSession"];

    header("location: PTSession.php");
}


?>
<body>
    <h1 style="text-align:center;">Appointment for today!</h1>
    <form method="POST" action="TherapistsReminder.php">
    <div class="box">
        <table  style="width:100%;" >
            <tr >
            <?php
                if(mysqli_num_rows($var_rmndrqry)>0){
                    while($var_Rget = mysqli_fetch_array($var_rmndrqry)){
                        $var_listDate = explode(",",$var_Rget["reminder_date"]);

                        if(in_array($var_crrntDate,$var_listDate)){
                            echo "<td><button name='BtnSession' value='".$var_Rget["appointment_id"]."'>"."<img src='ProfilePic/".$var_Rget["profilePic"]."'style='width:80px;
                            height:80px;border-radius:50px; padding:0'>".$var_Rget["Pat_fllname"]." ".$var_Rget["day"]." 
                            ".$var_Rget["start_time"]."-".$var_Rget["end_time"]."</bitton></td>";
                        }
                       
                }
                }
            ?>
            </tr>
        </table>
    </div>
    </form>


</body>

</html>
<style>
.box{
    margin-left: 0;
    margin-top: 2%;
    width: 90%;
    height: 700px;
    border: 4px solid black;
}
.box th, td {
  border: 1px solid black;
  border-radius: 50px;
  height:40%;
}
.box button{
    width: 100%;
    height: 100px;
    border-radius: 25px;
    text-align: left;
}
</style>