<php
include("../databse.php");
else{
                    $var_CrtSes = "INSERT INTO tbl_session (Time_startted,appointment_id,status)
                    VALUES('$var_crrntTime',$var_appid,'$var_status')";
                    $var_Squery = mysqli_query($var_conn, $var_CrtSes);
                    if ($var_Squery) {
                        $var_response = "0";
                    }
                   
                    break;
                }