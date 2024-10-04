<?php

include("../databse.php");
session_start();
$JSNDATA =file_get_contents(filename:"php://input");

$DcodeJSON = json_decode($JSNDATA,true);

if(isset($DcodeJSON["SchedID"])){

    $_SESSION["sess_SchedID"]=$DcodeJSON["SchedID"];

   
}