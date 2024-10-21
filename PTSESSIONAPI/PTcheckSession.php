<?php
include("../databse.php");
session_start();

$JSONDATA = file_get_contents(filename: "php://input");

$DcodeJSON = json_decode($JSONDATA, true);
date_default_timezone_set('Asia/Manila'); // Change to your timezone
$var_crrntTime = date("h:i:sa");
//$var_currntDate = date("Y-m-d");
$var_currntDate = "2024-10-18";
$var_status = "ongoing";
$var_response = "";

if (isset($DcodeJSON["appId"])) {
    $var_appid = $DcodeJSON["appId"];
    $var_session = " SELECT SS.Date_creadted,
                    RM.reminder_date
                    FROM tbl_session SS
                    JOIN tbl_appointment AP ON AP.appointment_id = SS.appointment_id
                    JOIN tbl_reminder RM ON RM.appointment_id = AP.appointment_id
                    WHERE AP.appointment_id = $var_appid AND SS.Date_creadted = '$var_currntDate'";
    $var_sesquery = $var_conn->query($var_session);

    if (mysqli_num_rows($var_sesquery) > 0) {//CHECK IF THERES ANY DUPLICATE SESSION
        $var_response = "1";
    } else {
        $var_remnider = " SELECT  RM.reminder_date
                    FROM tbl_reminder RM
                    JOIN tbl_appointment AP  ON RM.appointment_id = AP.appointment_id
                    WHERE AP.appointment_id = $var_appid";
        $var_RMqry = mysqli_query($var_conn, $var_remnider);
        $var_Srec = mysqli_fetch_array($var_RMqry);

        $var_SessDate = explode(",", $var_Srec["reminder_date"]);

        if (!in_array($var_currntDate, $var_SessDate)) { //CHECK OF THERES A SESSION FO TODAY

            $var_response = "2";
        } else {
            $var_status = "On-Going";
            $var_insrt ="INSERT INTO `tbl_session`(`status`, `Time_startted`, `appointment_id`,`Date_creadted`) 
            VALUES ('$var_status','$var_crrntTime', $var_appid,'$var_currntDate')";
            $var_sessquery = mysqli_query($var_conn,$var_insrt);
            if($var_sessquery){
                $var_response = "0";
            }
           else{
                $var_response = "error";
           }
            
          
        }
      
    }

    echo $var_response;
}
