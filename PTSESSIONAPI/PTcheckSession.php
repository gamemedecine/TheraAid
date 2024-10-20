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
                    WHERE AP.appointment_id = $var_appid";
    $var_sesquery = $var_conn->query($var_session);

    if (mysqli_num_rows($var_sesquery) > 0) {
        $var_Srec = mysqli_fetch_array($var_sesquery);

        $var_SessDate = explode(",", $var_Srec["reminder_date"]);

        if (!in_array($var_currntDate, $var_SessDate)) {

            $var_response = "2";
        } else {
            $sql = "SELECT 
	                SS.Date_creadted, RM.reminder_date
                FROM tbl_session SS 
                JOIN tbl_appointment AP 
                ON AP.appointment_id = SS.appointment_id 
                JOIN tbl_reminder RM 
                ON RM.appointment_id = AP.appointment_id 
                WHERE AP.appointment_id = $var_appid;";

            $results = $var_conn->query($sql);

            foreach ($results as $result) {
                $dateCreated = $result["Date_creadted"];

                if ($dateCreated  ==$var_currntDate  ){
                    $var_response = "1";
                    break;
                }
            }
            
          
        }
        // // 


        // }
    } else {
        $var_response = "5";
    }

    echo $var_response;
}
