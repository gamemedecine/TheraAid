<?php

include("../databse.php");
session_start();
$JSNDATA =file_get_contents(filename:"php://input");

$DcodeJSON = json_decode($JSNDATA,true);


if(isset($DcodeJSON["PTID"]) && isset($DcodeJSON["PtntID"])){

    $_SESSION["sess_PTID"]=$DcodeJSON["PTID"];
    $_SESSION["sess_PtntID"]=$DcodeJSON["PtntID"];
   
}