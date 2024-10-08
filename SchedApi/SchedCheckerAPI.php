<?php
include("../databse.php");

$JSONDATA = file_get_contents("php://input");
$DCodeJSON = json_decode($JSONDATA, true);

if (isset($DCodeJSON["day"]) && isset($DCodeJSON["start_time"]) && isset($DCodeJSON["therapists_id"])) {
    $days = $DCodeJSON["day"];
    $start_time = $DCodeJSON["start_time"];
    $therapists_id = intval($DCodeJSON["therapists_id"]);
    $formattedStartTime = date_format(date_create($start_time), "H:i:s");

    // Query to select schedules including status check
    $var_SchedChk = "SELECT * FROM `tbl_sched` WHERE `therapists_id` = $therapists_id AND `status` != 'Done';"; 

    $results = mysqli_query($var_conn, $var_SchedChk);
    $isMatched = 0;

    if ($results) {
        foreach ($results as $result) {
            $databaseDays = explode(",", $result["day"]);
            $databaseStartTime = $result["start_time"];
            $databaseEndTime = $result["end_time"];
            $scheduleStatus = $result["status"]; // Get the status of the schedule

            // Convert times to 24-hour format for easier comparison
            $var_Stime = date("H:i:s", strtotime($databaseStartTime)); // Start time
            $var_Etime = date("H:i:s", strtotime($databaseEndTime));   // End time
            $var_Inputtedtime = date("H:i:s", strtotime($formattedStartTime)); // Inputted time

            // Check if inputted day matches any of the stored days
            $var_chekDays = array_intersect($databaseDays, $days);

            if (!empty($var_chekDays)) {
                // Check if the schedule is available based on status
                if ($scheduleStatus == 'pending' || $scheduleStatus == 'ongoing') {
                    // If the status is pending or ongoing, mark the time as unavailable
                    $isMatched = 3; 
                    break;
                }

                // Check if inputted time falls within the existing schedule range
                if ($var_Inputtedtime > $var_Stime && $var_Inputtedtime <= $var_Etime) {
                    $isMatched = 2; 
                    break;
                }

                if ($var_Inputtedtime == $var_Stime) {
                    $isMatched = 1; 
                    break;
                }
            }
        }

        echo $isMatched; 
        // isMatched:
        // 0 -> No conflict
        // 1 -> Time matches exactly
        // 2 -> Time falls within the range
        // 3 -> Schedule status is 'pending' or 'ongoing', time not available
    } else {
        echo "Something went wrong while fetching the database.";
    }
} else {
    echo "Inputs must not be empty, Please try again.";
}
?>
