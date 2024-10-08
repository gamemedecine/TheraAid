<?php

include("../databse.php");
session_start();
$JSNDATA =file_get_contents(filename:"php://input");

$DcodeJSON = json_decode($JSNDATA,true);


if(isset($DcodeJSON["PNTID"])){

    $_SESSION["sess_PtntID"]=$DcodeJSON["PNTID"];
   
    
}