<head>
    <title>Patient Appointment</title>
</head>

<body>
<a style="font-size:40px; color:red;"href="PatientHomePage.php"><=</a><br>
<?php
include("databse.php");
session_start();
$var_SchedID = $_SESSION["sess_SchedID"];
$var_PTID = "";
$var_PtntID = "";

$var_Session = "";
$var_Ptype = "";
$var_Date = "";
$var_radBtn = "";

$var_day = "";

echo $_SESSION["sess_PtntID"]; // Patient ID

$var_Apdata = "SELECT * FROM tbl_sched WHERE shed_id=" . $var_SchedID;
$var_schedqry = mysqli_query($var_conn, $var_Apdata);

if (mysqli_num_rows($var_schedqry) > 0) {
    $var_rec = mysqli_fetch_array($var_schedqry);
    $var_day = $var_rec["day"];
    echo "<p>Day Selected: ".$var_rec["day"]."</p>";
    echo "<p>Startinng Time: ".$var_rec["start_time"]."</p>";
    echo "<p>Time Finished: ".$var_rec["end_time"]."</p>";
    echo "<p>Note: ".$var_rec["note"]."</p>";
    echo "Sched_id: " . $var_rec["shed_id"]; // Sched ID
    echo " Therapists: " . $var_rec["therapists_id"]; // Therapist ID
    $var_SchedID = $var_rec["shed_id"];
    $var_PTID = $var_rec["therapists_id"];
    $var_PtntID = $_SESSION["sess_PtntID"];
    $var_status = "Pending";
} else {
    echo "Error";
}




if (isset($_POST["BtnSubmit"])) {
    $var_Session = trim($_POST["TxtSession"]);
    $var_Ptype = $_POST["PaymentType"];
    $var_Date = $_POST["SDate"];
    $var_radBtn = $_POST["Radcntract"];
    $var_type = "Request Appointment";
    $var_status = "Request Appointment";
    echo "session" . $var_Session . " Ptype" . $var_Ptype . " " . $var_Date . " " . $var_radBtn . " " . " " .
        $var_PTID . " " .      $var_PtntID;

    $var_insrt ="INSERT INTO tbl_appointment (num_of_session,payment_type,
    start_date,is_aggreed,therapists_id,patient_id,status,schedle_id)
    VALUES($var_Session,'$var_Ptype','$var_Date','$var_radBtn',$var_PTID,$var_PtntID,'$var_status',$var_SchedID)";

    $var_PuserId ="SELECT user_id  FROM tbl_therapists WHERE therapist_id=".$var_PTID;
    $var_uId = mysqli_query($var_conn,$var_PuserId);
    $var_get = mysqli_fetch_array( $var_uId);
    $var_UID=$var_get['user_id'];
    $var_APqry=mysqli_query($var_conn,$var_insrt);
    if($var_APqry){
        $last_APid = $var_conn->insert_id;

        $var_notif ="INSERT INTO tbl_notifications(user_id,appointment_id,type)
        VALUES($var_UID,$last_APid,'$var_type')";
        mysqli_query($var_conn,$var_notif);
    }else{
        echo "Error";
    }

  

}
?>

<html>



    <form method="POST" action="PatAppointment.php">
        <label>Num Of Session:</label>
        <input type="text" value="<?php echo $var_Session; ?>" name="TxtSession">

        <label>Payment Type:</label>
        <select name="PaymentType" id="color">
            <option value="">--- Choose a payment type ---</option>
            <option value="PS">Per Session</option>
            <option value="PC">Package</option>
        </select>

        <label>Date Start:</label>
        <select name="SDate" id="SDate" required>
        <option value="">--- Select Start Date ---</option>
        <?php
        $selectedDaysString = $var_day; // Example input, this should come from your data
        $selectedDaysArray = explode(',', $selectedDaysString);

        // Map days to numeric values for the DateTime::format('N') function
        $daysMap = [
            'Mon' => 1, // Monday
            'Tue' => 2, // Tuesday
            'Wed' => 3, // Wednesday
            'Thu' => 4, // Thursday
            'Fri' => 5, // Friday
            'Sat' => 6, // Saturday
        ];

        // Use the actual current date
        $today = new DateTime(); 
        $currentMonth = $today->format('m'); // Current month
        $currentYear = $today->format('Y');  // Current year
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);

        // Define how many days in total we want to render
        $totalDaysToRender = 8; 
        $daysRendered = 0; 

        // Function to generate options for a given month and year
        function generateOptions($year, $month, $startDay, $selectedDaysArray, $daysMap, &$daysRendered, $totalDaysToRender, $today) {
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            for ($day = $startDay; $day <= $daysInMonth; $day++) {
                $dateString = sprintf('%04d-%02d-%02d', $year, $month, $day);
                $date = DateTime::createFromFormat('Y-m-d', $dateString);

                if ($date && $date >= $today) {
                    $dayOfWeek = $date->format('N'); // Day of the week as a number (1=Monday, 7=Sunday)
                    
                    // Check if the day of the week matches the selected days
                    foreach ($selectedDaysArray as $selectedDay) {
                        if (isset($daysMap[$selectedDay]) && $dayOfWeek == $daysMap[$selectedDay]) {
                            echo "<option value='" . $date->format('Y-m-d') . "'>" . $date->format('Y-m-d') . "</option>";
                            $daysRendered++;
                            break; // Move to the next date once a match is found
                        }
                    }
                }
                
                // Stop if we have rendered enough days
                if ($daysRendered >= $totalDaysToRender) {
                    return;
                }
            }
        }

        // Render dates for the current month
        generateOptions($currentYear, $currentMonth, $today->format('d'), $selectedDaysArray, $daysMap, $daysRendered, $totalDaysToRender, $today);

        // If there are not enough days left in the current month, render days from the next month
        if ($daysRendered < $totalDaysToRender) {
            $nextMonth = $today->modify('first day of next month');
            generateOptions($nextMonth->format('Y'), $nextMonth->format('m'), 1, $selectedDaysArray, $daysMap, $daysRendered, $totalDaysToRender, $today);
        }
        ?>
    </select>

        <br>

        <input type="radio" name="Radcntract" value="1"><label>Agree</label>
        <input type="radio" name="Radcntract" value="0"><label>Disagree</label>

        <input type="submit" value="Submit" name="BtnSubmit">
    </form>

</body>

</html>