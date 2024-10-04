<?php
include("../databse.php");

$JSONDATA = file_get_contents("php://input");
$DcodeJSON = json_decode($JSONDATA, true);

if (isset($DcodeJSON["TID"])) {
    $var_TID = $DcodeJSON["TID"];
    $var_slctSched = "SELECT * FROM tbl_sched WHERE therapists_id=$var_TID";
    $var_schedQry = mysqli_query($var_conn, $var_slctSched);

    $schedules = []; // Create an array to store schedules

    if (mysqli_num_rows($var_schedQry) > 0) {
        while ($var_rec = mysqli_fetch_array($var_schedQry)) {
            // Add each record to the schedules array
            $schedules[] = [
                "Sched_id" => $var_rec["shed_id"],
                "Day" => $var_rec["day"],
                "Start_ime" => $var_rec["start_time"],
                "End_Time" => $var_rec["end_time"],
                "Note" => $var_rec["note"],
                "Status" => $var_rec["status"],
                "Date_Created" => $var_rec["date_created"],
                "Sched_id" => $var_rec["shed_id"]
            ];
        }

        // Send the entire schedules array as JSON
        echo json_encode($schedules);
    } else {
        echo json_encode(["message" => "No Record found"]);
    }
}
?>
