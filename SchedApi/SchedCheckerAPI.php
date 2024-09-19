<?php
include("../databse.php");

$JSONDATA = file_get_contents(filename: "php://input");

$DCodeJSON = json_decode(json: $JSONDATA, associative: true);

if (isset($DCodeJSON["day"]) && isset($DCodeJSON["start_time"]) && isset($DCodeJSON["therapists_id"])) {
    $days = $DCodeJSON["day"];
    $start_time = $DCodeJSON["start_time"];
    $therapists_id = intval($DCodeJSON["therapists_id"]);
    $formattedStartTime = date_format(date_create($start_time), "H:i:s");

    
    $var_SchedChk = "SELECT * FROM `tbl_sched`
     WHERE `therapists_id` = $therapists_id AND `start_time` = '$formattedStartTime';";

    $results = mysqli_query($var_conn,  $var_SchedChk);
    $isMatched = 0;

    if ($results) {
        foreach ($results as $result) {
            $databaseDays = explode(",",$result["day"]);
            $databaseStartTime = $result["start_time"];
            $databaseTherapistId = $result["therapists_id"];
            $var_chekDays = array_intersect($databaseDays,$days);
            if ($var_chekDays !="" && $databaseStartTime == $formattedStartTime) {
                $isMatched = 1;
                break;
            }
        }

        echo $isMatched;
    } else {
        echo "Something went wrong while fetching the database.";
    }
} else {
    echo "Inputs must not be empty, Please try again.";
}
?>