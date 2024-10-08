<?php
include("../databse.php");
session_start();

$JSNDATA = file_get_contents(filename:"php://input");

$DcodeJSON = json_decode($JSNDATA,true);
// CHECK THE STATUS IF THE PATIENT HAVE A PENDING/RESPONDED/ON-GOING STATUS
if(isset($DcodeJSON["PATID"])){
    $var_patId= $DcodeJSON["PATID"];
    $var_chck = "SELECT
    S.status
    FROM tbl_appointment A 
    JOIN tbl_sched S ON A.schedle_id  = S.shed_id 
    JOIN tbl_patient P ON A.patient_id = P.patient_id
    WHERE A.patient_id = ".$var_patId."
    AND (A.status LIKE '%Pending'
    OR A.status LIKE '%Responded'
    OR A.status LIKE '%On-Going')";

    $var_chkqry = mysqli_query($var_conn,$var_chck);
    $var_validate;
    if(mysqli_num_rows($var_chkqry)>0){
        $var_validate=1;   
    }
    else{
        $var_validate=0; 
    }
    echo $var_validate;
}else{
    echo "Input is empty, Please try again";
}