<?php
include("databse.php");
session_start();
echo $_SESSION["sess_PID"];
 echo $_SESSION["sess_ApntmntId"];
 $var_APID=$_SESSION["sess_ApntmntId"];
 
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
$var_profid =  $_SESSION["sess_PID"];
$var_qry = "SELECT u.User_id,
                     u.Fname, 
                     u.Lname, 
                     u.Mname, 
                     u.Bday,
                    u.ContactNum, 
                    u.Email, 
                    p.P_case,
                    p.case_desc,
                    p.City, 
                    p.street,
                    p.assement_photo, 
                    p.mid_hisotry_photo 
                    FROM tbl_user u JOIN tbl_patient p ON u.User_id = p.user_id
                    WHERE 
                    p.patient_id  ='$var_profid';";
$var_chk = mysqli_query($var_conn, $var_qry);
$var_Fname = "";
$var_Lname = "";
$var_Mname = "";
$var_MI = "";
$var_Age = "";
$var_CntctNum = "";
$var_Email = "";
$var_Case = "";
$var_CaseDesc = "";
$var_City = "";
$var_Stret = "";
$var_Medpic = "";
$var_Assesment = "";
$var_UID = "";
if (mysqli_num_rows($var_chk) > 0) {
    $var_get = mysqli_fetch_array($var_chk);
    $var_Case = $var_get["P_case"];
    $var_CaseDesc = $var_get["case_desc"];
    $var_City = $var_get["City"];
    $var_Medpic = $var_get["mid_hisotry_photo"];
    $var_Assesment = $var_get["assement_photo"];
    $var_Street = $var_get["street"];
    $var_Fname = $var_get["Fname"];
    $var_Lname = $var_get["Lname"];
    $var_Mname = $var_get["Mname"];
    $var_Date = $var_get["Bday"];
    $var_CntctNum = $var_get["ContactNum"];
    $var_Email = $var_get["Email"];
    $var_year = date("Y");
    $var_MI = substr($var_Mname, 0, 1);
    $var_byear = substr($var_Date, 0, 4);
    $var_UID = $var_get["User_id"];
    $var_Age = $var_year - $var_byear;
} else {
    echo "No records found";
}
$var_Rate="";
if(isset($_POST["BTNsubmit"])){
    $var_Rate=intval($_POST["TxtRate"]);
    $var_status = "Responded";

    $var_update ="UPDATE tbl_appointment SET
                         rate=$var_Rate,
                         status='$var_status' 
                         WHERE appointment_id=".$_SESSION["sess_ApntmntId"];
    $var_upqry=mysqli_query($var_conn,$var_update);

    if($var_upqry){
        $var_type="Therapists Have Responded to your request";
        $var_notif ="INSERT INTO tbl_notifications(user_id,appointment_id,type)
        VALUES($var_UID,$var_APID,'$var_type')";
        mysqli_query($var_conn,$var_notif);
        header("location: TherapistsAppointment.php");
    }else{
        "error";
    }
}
//Decline Code
if (isset($_POST["BTNDecline"])) {
    $var_status = "declined"; // Set status to "declined"

    // Update the status in the database
    $var_update = "UPDATE tbl_appointment SET
                         status='$var_status' 
                         WHERE appointment_id=".$_SESSION["sess_ApntmntId"];
    $var_upqry = mysqli_query($var_conn, $var_update);

    if ($var_upqry) {
        $var_type="Therapists Have Declined to your request";
        $var_notif ="INSERT INTO tbl_notifications(user_id,appointment_id,type)
        VALUES($var_UID,$var_APID,'$var_type')";
        mysqli_query($var_conn,$var_notif);
        header("location: TherapistsAppointment.php");
    } else {
        echo "Error: Could not decline the appointment.";
    }
}
?>

<body>
    <a style="font-size: 50px;" href="TherapistsAppointment.php"><=Back</a>
        
            </nav>
            <div class="container"> <!-- Added container for layout -->
                <div class="basicInfo">
                    <img class="rounded-circle" src="photos/profile.jpg" alt="Profile Pic"><br><br>
                    <p><?php echo $var_Fname . " " . $var_MI . ". " . $var_Lname; ?></p>
                    <p><?php echo $var_Age; ?></p>
                    <p><?php echo $var_CntctNum; ?></p>
                    <p><?php echo $var_Email; ?></p>
                    <button>Edit</button>
                </div>
                <div class="AddInfo">
                    <div class="Case row">
                        <div class="col-md-6">
                            <p>Case : <?php echo $var_Case; ?></p><br>
                            <p>Description : <?php echo $var_CaseDesc; ?></p>
                        </div>
                        <div class="col-md-6">
                            <label>Address:</label><br>
                            <p>City : <?php echo $var_City; ?></p><br>
                            <p>Barangay/Street : <?php echo $var_Street; ?></p>
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Accpet Patient
                            </button>
                            <button type="button" data-bs-toggle="modal" class="btn btn-danger" data-bs-target="#declineModal" >Decline</button>

                        </div>
                    </div>
                    <div class="MedHistory mt-3">
                        <label>Medical History</label><br>
                        <img src="medrec/<?php echo $var_Medpic ?>" alt="Medical History">
                    </div>
                    <div class="Asessment mt-3">
                        <label>Medical Assessment</label><br>
                        <img src="medrec/<?php echo $var_Assesment ?>" alt="Medical Asessment">
                    </div>


                </div>
            </div>
<form method="POST" action="PTPatientview.php">
            <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Accept Patient</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">  
        <?php
            $var_appntmnt ="SELECT * FROM tbl_appointment WHERE appointment_id=".$_SESSION["sess_ApntmntId"];
            $var_Aqry=mysqli_query($var_conn,$var_appntmnt);

            $var_get=mysqli_fetch_array($var_Aqry);
            $var_condition ="";
            if( $var_get["is_aggreed"] ==1){
                $var_condition ="Agreed";
            }else{
                $var_condition ="Disagreed";

            }
            ?>
                <p>Number Of Session: <?php echo $var_get["num_of_session"];?></p>
                <p>Payment Type : <?php echo $var_get["payment_type"] ?></p>
                <p>Start Date : <?php echo $var_get["start_date"] ?><p>
                <p>Date Requested: <?php echo $var_get["Date_creadted"] ?></p>
                <p>Condition: <?php echo $var_condition;?></p> 
                <label>Rate</label><input type="text" name="TxtRate" required>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name ="BTNsubmit" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>
        <!---->
        <div class="modal fade" id="declineModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Accept Patient</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">  
        <?php
            $var_appntmnt ="SELECT * FROM tbl_appointment WHERE appointment_id=".$_SESSION["sess_ApntmntId"];
            $var_Aqry=mysqli_query($var_conn,$var_appntmnt);

            $var_get=mysqli_fetch_array($var_Aqry);
            $var_condition ="";
            if( $var_get["is_aggreed"] ==1){
                $var_condition ="Agreed";
            }else{
                $var_condition ="Disagreed";

            }
            ?>
                <p>Number Of Session: <?php echo $var_get["num_of_session"];?></p>
                <p>Payment Type : <?php echo $var_get["payment_type"] ?></p>
                <p>Start Date : <?php echo $var_get["start_date"] ?><p>
                <p>Date Requested: <?php echo $var_get["Date_creadted"] ?></p>
                <p>Condition: <?php echo $var_condition;?></p> 
                <p style="font-size: 40px;">Are you sure to Decline the request? </p>
          </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name ="BTNDecline" class="btn btn-danger">Confirm</button>
      </div>
    </div>
  </div>
</div>
</form>
            <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>
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