<?php
include("databse.php");
session_start();




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Document</title>
</head>

<style>
    * {
        margin: 0;
        padding: 0;
    }

    body {
        background-color: #6666FF;
    }


    .nav-item:hover .logout {
        display: block;
    }

    .container {
        /* Added container for layout */
        display: flex;
        /* Use flexbox to align children */
        gap: 20px;
        /* Add space between the divs */
        padding: 20px;
        /* Added padding around the container */
        margin-left: 80px;
        margin-right: 0;
    }

    .basicInfo {
        margin-left: 5px;
        margin-top: 5px;
        ;
        background-color: white;
        height: 400px;
        width: 300px;
        border-radius: 10px;
        padding: 0;
    }

    .basicInfo img {
        margin-top: 10px;
        margin-left: 11%;
        box-shadow: 0 5px 8px 1px;
        height: 45%;
    }

    .basicInfo p {
        margin-top: 0;
        padding: 0;
        text-align: center;
        font-size: 15px;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
    }

    .basicInfo button {
        text-align: center;
        margin-left: 38%;
        width: 20%;
    }

    .AddInfo {
        margin-top: 5px;
        margin-right: 0;
        ;
        width: 900px;
        height: 400px;
        border-radius: 10px;
        background-color: white;
    }
</style>
<?php
$var_APid =   $_SESSION["sess_APID"];
$var_qry = "SELECT  
                A.num_of_session,
                A.payment_type,
                A.start_date,
                A.date_accepted,
                A.status, 
                A.rate, 
                A.Date_creadted,
                S.day,
                S.shed_id,
                S.start_time, 
                S.end_time, 
                P.P_case,
                P.case_desc,
                P.case_desc,
                CONCAT(U.Fname, ' ', U.Mname, ' ', U.Lname) AS patient_fllname, 
                CONCAT(P.City,' ',street) AS patient_address,
                U.ContactNum,
                U.Bday,
                U.ContactNum,
                U.E_wallet AS PtntE_wallet,
                U.Email,
                U.User_id AS PtntID,
                CONCAT( UT.Lname,' ',UT.Fname,' ',UT.Mname) AS PT_fllname,
                UT.Bday AS PT_Bday,
                UT.Email AS PT_Email,
                UT.ContactNum AS PT_CntctNum,
                UT.User_id AS PTID,
                UT.E_wallet AS PTE_wallet,
                T.case_handled,
                T.city
FROM tbl_appointment A 
JOIN tbl_sched S ON S.shed_id  = A.schedle_id 
JOIN tbl_patient P ON P.patient_id = A.patient_id 
JOIN tbl_user U ON P.user_id = U.User_id 
JOIN tbl_therapists T ON T.therapist_id = A.therapists_id
JOIN tbl_user UT ON T.user_id = UT.User_id
WHERE A.appointment_id=" . $var_APid;
$var_chk = mysqli_query($var_conn, $var_qry);
$var_get = mysqli_fetch_array($var_chk);
$var_PTAge = "";
$var_rate = $var_get["rate"];
$var_PtntE_wallet = floatval($var_get["PtntE_wallet"]);
$VAR_PTNTID = $var_get["PtntID"];

$var_PTID = $var_get["PTID"];
$var_PTE_wallet = floatval($var_get["PTE_wallet"]);
$var_BY = date('Y', strtotime($var_get["PT_Bday"]));
$var_currDate = date("Y");
$var_PTAge = $var_currDate - $var_BY;
$var_Rate = "";
$var_Sdate = $var_get["start_date"];
$var_NumofSession = $var_get["num_of_session"];
$data_day = $var_get["day"];

if (isset($_POST["BTNsubmit"])) {
    $var_Rate = intval($_POST["TxtRate"]);
    $var_status = "Responded";

    $var_update = "UPDATE tbl_appointment SET
                         rate=$var_Rate,
                         status='$var_status' 
                         WHERE appointment_id=" . $var_AppID;
    $var_upqry = mysqli_query($var_conn, $var_update);

    if ($var_upqry) {
        $var_type = "Therapists Have Responded to your request";
        $var_notif = "INSERT INTO tbl_notifications(user_id,appointment_id,type)
        VALUES($var_UID,$var_APID,'$var_type')";
        mysqli_query($var_conn, $var_notif);
        header("location: TherapistsAppointment.php");
    } else {
        "error";
    }
}
//Decline Code
if (isset($_POST["BTNDecline"])) {
    $var_status = "declined"; // Set status to "declined"

    // Update the status in the database
    $var_update = "UPDATE tbl_appointment SET
                         status='$var_status' 
                         WHERE appointment_id=" . $var_AppID;
    $var_upqry = mysqli_query($var_conn, $var_update);

    if ($var_upqry) {
        $var_type = "Therapists Have Declined to your request";
        $var_notif = "INSERT INTO tbl_notifications(user_id,appointment_id,type)
        VALUES($var_UID,$var_APID,'$var_type')";
        mysqli_query($var_conn, $var_notif);
        header("location: TherapistsAppointment.php");
    } else {
        echo "Error: Could not decline the appointment.";
    }
}
$var_ammnt = "";
if (isset($_POST["BtnSubmit"])) {
    $var_ammnt = floatval($_POST["TxtAmount"]);

    if ($var_ammnt !=  $var_get["rate"]) {
        echo "Please enter the proper amount";
    }
    if ($var_get["rate"] > $var_PtntE_wallet) {
        echo "Insufecient valance Please Top-up";
    } else {
        $var_Payment = "INSERT INTO tbl_payment (appointment_id,amount,status)
        VALUES ('$var_APid','$var_ammnt','Paid')";
        $var_Pqry = mysqli_query($var_conn, $var_Payment);

        if ($var_Pqry) {
            //update therapists E-wallet Account PtntID
            $var_UpdtE_wallet = $var_ammnt + $var_PTE_wallet;
            //echo $var_UpdtE_wallet;
            $var_Tupdate = "UPDATE tbl_user SET E_wallet=   $var_UpdtE_wallet WHERE User_id = $var_PTID";
            $var_TupdatePT = mysqli_query($var_conn, $var_Tupdate);

            //UPDATE THE E WALLET OF THE PATIENT "DEDUCT"
            $var_deductE_wallet = $var_PtntE_wallet - $var_ammnt;
            //echo  $var_deductE_wallet;
            $var_TupdatePaatient = "UPDATE tbl_user SET E_wallet= $var_deductE_wallet WHERE User_id =$VAR_PTNTID";
            $var_TupdatePTNT = mysqli_query($var_conn, $var_TupdatePaatient);

            //UPDATE SCHED STATUS TO ONGOING/IN USED
            $var_SchedUpdate = "UPDATE tbl_sched SET status = 'On-Going' WHERE shed_id =" . $var_get["shed_id"];
            $var_SchedUpdtQRY = mysqli_query($var_conn, $var_SchedUpdate);

            //UPDATE APPOINTMENT STATUS TO ONGOING/IN USED
            $var_AppntmntUpdate = "UPDATE tbl_appointment SET status = 'On-Going' WHERE appointment_id =" . $var_APid;
            $var_AppntmntUpdtQRY = mysqli_query($var_conn, $var_AppntmntUpdate);

            if ($var_SchedUpdtQRY) {
                //CREATE A REMINDER
                SetReminder($var_APid, $var_Sdate, $data_day, $var_NumofSession, $var_conn);
            }
        }
    }
}
?>

<body>
    <a style="font-size: 50px; color:red" href="PatientHomePage.php">Back</a>
    <form method="POST" action="PATTherapistView.php">
        </nav>
        <div class="container"> <!-- Added container for layout -->
            <div class="basicInfo">
                <img class="rounded-circle" src="photos/profile.jpg" alt="Profile Pic"><br><br>
                <p><?php echo $var_get["PT_fllname"]; ?></p>
                <p><?php echo $var_PTAge; ?></p>
                <p><?php echo $var_get["PT_CntctNum"]; ?></p>
                <p><?php echo  $var_get["PT_Email"]; ?></p>
                <button>Edit</button>
            </div>
            <div class="AddInfo">
                <div class="Case row">
                    <div class="col-md-6">
                        <h3><?php

                            $formattedData = str_replace(",", "-", $data_day);
                            echo $formattedData . "<br>";

                            echo $var_get["start_time"] . "-" . $var_get["end_time"];
                            ?></h3>
                        <p>Case : <?php echo $var_get["P_case"]; ?></p>
                        <h1>Balance: <?php echo $var_PtntE_wallet; ?></h1>
                        <p>Description : <?php echo $var_get["case_desc"]; ?></p>
                        <p>Type Of Payment : <?php echo $var_get["payment_type"]; ?></p>
                        <p>Start Date : <?php echo $var_Sdate; ?></p>
                        <p>Rate : <?php echo $var_get["rate"]; ?></p>
                        <p>Appointment status : <?php echo $var_get["status"]; ?></p>

                    </div>
                    <div class="col-md-6">
                        <label>Address: <?php echo $var_get["patient_address"]; ?></label><br>
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Pay
                        </button>
                        <p style="color:red;">If payment is not recieved within 24 hours The appointment will be canceled</p>
                    </div>
                </div>


            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Payment</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <p>Rate :<?php echo $var_get["rate"]; ?></p>
                        <label>Amount</label><input type="text" name="TxtAmount" placeholder="₱" required />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit " name="BtnSubmit" class="btn btn-primary">Confirm Payment</button>
                    </div>
                </div>
            </div>
        </div>

    </form>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>
<!--SET REMINDER-->
<?php
function SetReminder($var_APid, $var_Sdate, $data_day, $var_NumofSession, $var_conn)
{
    $future_dates = [];

    // Convert the string of days into an array (e.g., "Mon,Wed,Fri" becomes ["Mon", "Wed", "Fri"])
    $selectedDays = explode(',', $data_day);

    // Convert the start date into a DateTime object
    $startDate = new DateTime($var_Sdate); // Assuming we start from today

    // While loop until we get the required number of meetings
    while (count($future_dates) < $var_NumofSession) {
        // Get the current day of the week (D for 3-letter abbreviation)
        $currentDay = $startDate->format('D');

        // Check if the current day is one of the selected days (e.g., "Mon", "Wed", "Fri")
        if (in_array($currentDay, $selectedDays)) {
            // Add the current date to the list of future dates
            $future_dates[] = $startDate->format('Y-m-d');
        }

        // Move to the next day
        $startDate->modify('+1 day');
    }

    // Convert the array of future dates to a string separated by commas
    $dates_string = implode(',', $future_dates);
    $var_RMessage = "You Have An appointment Today";
    $var_Isread = "unread";
    $var_setReminder = "INSERT INTO tbl_reminder (appointment_id, reminder_date, reminder_messsage, reminder_status)
                    VALUES ('$var_APid', '$dates_string', '$var_RMessage', '$var_Isread')";
    $var_setqry = mysqli_query($var_conn, $var_setReminder);
}





?>
<style>
    .MedHistory img,
    .Asessment img {
        width: 200px;
        /* Adjust width as needed */
        height: auto;
        /* Keep the aspect ratio */
        object-fit: cover;
        /* Fit image inside the box */
        border-radius: 10px;
        /* Rounded corners */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        /* Optional box shadow */
    }

    .MedHistory,
    .Asessment {
        margin-top: 15px;
    }
</style>