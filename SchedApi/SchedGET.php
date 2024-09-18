<?php
include("../databse.php");
    
$var_Items=$var_conn->query("SELECT * FROM `tbl_sched`");
if($var_Items){
    $data = json_decode("[]");

   foreach($var_Items as $var_Rec){
    $newData = array(
        "day" => $var_Rec["day"],
        "EtartTime" => $var_Rec["start_time"],
        "EndTime" => $var_Rec["end_time"],
        "Note" => $var_Rec["note"],
        "status" => $var_Rec["status"]
    );
    $data[] = $newData;
   }
   echo json_encode($data, JSON_PRETTY_PRINT);
}
?>