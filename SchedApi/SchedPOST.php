<?php
include("../databse.php");

$JSONDATA = file_get_contents(filename:"php://input");

$DCodeJSON = json_decode(json: $JSONDATA, associative: true );


if( isset($DCodeJSON["therapists_id"]) &&
    isset($DCodeJSON["day"]) &&
    isset($DCodeJSON["start_time"]) &&
    isset($DCodeJSON["end_time"]) &&
    isset($DCodeJSON["note"]) &&
    isset($DCodeJSON["status"])){ 

    $var_Tid=$DCodeJSON["therapists_id"];
    $var_Day=$DCodeJSON["day"];
    $var_Stime=$DCodeJSON["start_time"];
    $var_Etime=$DCodeJSON["end_time"];
    $var_Note=$DCodeJSON["note"] ;
    $var_Status=$DCodeJSON["status"];
    
    
    echo $var_Tid."<br>";
    echo implode($var_Day)."<br>";
    $var_EMPDays = implode($var_Day);
    echo $var_Stime."<br>";
    echo $var_Etime."<br>";
    echo $var_Note."<br>";
    echo $var_Status."<br>";
    $var_INSERT = "INSERT INTO `tbl_sched`(`therapists_id`, `day`,
                                 `start_time`, `end_time`,
                                  `note`, `status`)
                             VALUES ('$var_Tid','$var_EMPDays',
                             '$var_Stime','$var_Etime',
                             '$var_Note','$var_Status')";
    $var_qry =mysqli_query($var_conn,$var_INSERT);
    
    
    }


?>