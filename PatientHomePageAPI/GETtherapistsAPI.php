<?php
include("../databse.php");

$JSNDATA =file_get_contents(filename:"php://input");

$DcodeJSON=json_decode($JSNDATA,true);

if(isset($DcodeJSON["city"])
    & isset($DcodeJSON["case"])
){

    $var_city = $DcodeJSON["city"];
    $var_case = $DcodeJSON["case"];

    $var_slctTherapists = "SELECT   U.Fname,
                                    U.Mname,
                                    U.Lname,
                                    T.case_handled,
                                    T.city,
                                    T.therapist_id
                                    FROM tbl_therapists T
                                    JOIN tbl_user U
                                    ON U.User_id = T.user_id
                                    WHERE T.city= '$var_city'";

    $var_qry = mysqli_query($var_conn,$var_slctTherapists);
    
    if(mysqli_num_rows($var_qry)>0){
            while($var_rec = mysqli_fetch_array($var_qry)){
                $var_strdcase = explode(",",$var_rec["case_handled"]);

                if (in_array($var_case,$var_strdcase)) {
                    $var_therapists[]=[
                        "fname" => $var_rec["Fname"],
                        "lname" => $var_rec["Lname"],
                        "mname" => $var_rec["Mname"],
                        "case" => $var_rec["case_handled"],// spine injury,stroke
                        "city" => $var_rec["city"],
                        "TID" => $var_rec["therapist_id"]
                        
                    ];
                }
                
            }

          echo json_encode( $var_therapists);
    }else{
        echo json_encode(["message"=>"No Record Found"]);
    }

}
?>