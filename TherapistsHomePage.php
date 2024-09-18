<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>TheraAid</title>
    <link rel="stylesheet" href="TherapistsDesign/TherapistsHomePage.css">
</head>
<?php
session_start();


echo $_SESSION["sess_id"];

$var_ProfPic = "";
$var_Fname = "";
$var_Lname = "";
$var_Mname = "";
$var_CaseHndld = "";
$var_City = "";
$var_Radius = "";
$var_Error = "";
$var_Invalidnote = false;
$var_Status = "";

$var_id = $_SESSION["sess_id"];
$var_Tid = "";

if ($var_qry) {
    $var_rec = mysqli_fetch_array($var_qry);
    $var_Fname = $var_rec["Fname"];
    $var_Lname = $var_rec["Lname"];
    $var_Mname = $var_rec["Mname"];
    $var_CaseHndld = $var_rec["case_handled"];
    $var_City = $var_rec["city"];
    $var_Radius = $var_rec["Radius"];
    $var_ProfPic = $var_rec["profilePic"];
    $var_Tid = $var_rec["therapist_id"];
    $_SESSION["sess_Tid"] = $var_Tid;
} else {
    echo "Error";
}

echo  $_SESSION["sess_Tid"];
function ChkNum($value)
{
    return is_numeric($value);
}
?>

<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark mb-0">
        <!-- Navbar brand with logo -->
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="Photos/Logo.jpg" alt="TheraAid Logo" style="width:80px;" class="rounded-circle mb-0 d-inline-block align-top">
            <span class="fs-2 ms-2">TheraAid</span>
        </a>
        <!-- Navbar toggle button for mobile view -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Collapsible menu -->
        <div class="collapse navbar-collapse mt-5 d-flex justify-content-end mt-5" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a href="Appointment.php" class="nav-link">Appointment</a></li>
                <li class="nav-item"><a class="nav-link">History</a></li>
                <li class="nav-item"><a class="nav-link">Reminder</a></li>
                <li class="nav-item"><a class="nav-link">Notification</a></li>
                <li class="nav-item"><a class="nav-link">Chat</a></li>
                <a href="ProfilePage.php" class="nav-link">Profile</a>
                <ul class="logout">
                    <li><a href="logout.php">Logout</a></li>
                </ul>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container-fluid full-height">
        <div class="white-box">
            <div class="flex-container">
                <div class="box">
                    <div class="Details-box  rounded">
                        <div class="TherapistInfo rounded">
                            <img class="border rounded-circle" src="ProfilePic/<?php echo $var_ProfPic; ?>" alt="Profile Picture">
                            <?php

                            echo "<p>Name: " . $var_Lname . " " . $var_Fname . " " . $var_Mname . "</p>";
                            echo "<p>Area Covered: " . $var_City . " City Within " . $var_Radius . " Km</p>";
                            echo "<p>Specialized in: " . $var_CaseHndld . "</p>";
                            ?>
                            <p>Rating: </p>
                        </div>
                        <div class="TherapistScghed">
                            <?php
                            $var_schdSelect = "SELECT `shed_id`, `therapists_id`, `day`,
                               `start_time`, `end_time`, `note`,
                               `status`, `date_created`
                                FROM `tbl_sched`
                                WHERE `therapists_id` = " . intval($var_Tid) . " 
                                ORDER BY `start_time` ASC";
                            $var_schdqry = mysqli_query($var_conn, $var_schdSelect);
                            ?>
                            <h3 class="text-center">Available Schedule</h3>
                            <div class="TimeBtn">
                                <input type="button" name="BtnAM" value="AM" id="BtnAM">
                                <input type="button" name="BtnPM" value="PM" id="BtnPM">
                            </div>
                            <?php
                            $var_PSched = "SELECT `shed_id`, `therapists_id`, `day`,
                                        `start_time`, `end_time`, `note`,
                                        `status`, `date_created`
                                        FROM `tbl_sched`
                                        WHERE `therapists_id` = $var_Tid
                                        ORDER BY `start_time` ASC";
                            $var_Schdqry = mysqli_query($var_conn, $var_PSched);

                            ?>
                            <div class="AM" id="AM-schedule">
                                <div class="SchedButton">
                                    <?php
                                    if (mysqli_num_rows($var_Schdqry) > 0) {
                                        while ($var_schdrec = mysqli_fetch_array($var_Schdqry)) {
                                            if (date('G', strtotime($var_schdrec["end_time"])) < 12) {
                                                echo '<button value="' . $var_schdrec["shed_id"] . '">'
                                                    . $var_schdrec["day"] . '<br>' .
                                                    date('g A', strtotime($var_schdrec["start_time"])) . ' / ' .
                                                    date('g A', strtotime($var_schdrec["end_time"])) . '<br>' .
                                                    $var_schdrec["note"] . '
                                                </button>';
                                            }
                                        }
                                    } else {
                                        echo "<p>No Schedule Available</p>";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="PM" id="PM-schedule" style="display: none;">
                                <div class="SchedButton">
                                    <?php
                                    // Reset the result pointer to fetch data again if necessary
                                    mysqli_data_seek($var_Schdqry, 0);

                                    if (mysqli_num_rows($var_Schdqry) > 0) {
                                        while ($var_schdrec = mysqli_fetch_array($var_Schdqry)) {
                                            // Check for PM times (12 PM or later)
                                            if (date('G', strtotime($var_schdrec["end_time"])) >= 12) {
                                                echo '<button type="button" 
                                                    value="' . $var_schdrec["shed_id"] . '">'
                                                    . $var_schdrec["day"] . '<br>' .
                                                    date('g A', strtotime($var_schdrec["start_time"])) . ' / ' .
                                                    date('g A', strtotime($var_schdrec["end_time"])) . '<br>' .
                                                    $var_schdrec["note"] . '
                                                    </button>';
                                            }
                                        }
                                    } else {
                                        echo "<p>No Schedule Available</p>";
                                    }
                                    ?>
                                </div>
                            </div>
                            <a style="width: 500px; height:200px;" href="TherapistsSched.php">
                                ADD SCHEDULE
                                </a>


                        </div>
                    </div>

                    <div class="hi">
                        <select name="Slct_Kilometers">
                            <option value="">--- Filter Distance ----</option>
                            <?php
                            for ($var_i = 100; $var_i <= $var_Radius; $var_i += 100) {
                                echo "<option value='$var_i'>" . $var_i . "</option>";
                            }
                            ?>
                        </select>
                    </div>


                </div>

            </div>

        </div>


    </div>
    
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnAM = document.getElementById('BtnAM'); // Ensure this exists
        const btnPM = document.getElementById('BtnPM'); // Ensure this exists
        const amSchedule = document.getElementById('AM-schedule'); // Ensure this exists
        const pmSchedule = document.getElementById('PM-schedule'); // Ensure this exists

        if (btnAM && btnPM && amSchedule && pmSchedule) {
            btnAM.addEventListener('click', function() {
                amSchedule.style.display = 'block';
                pmSchedule.style.display = 'none';
            });

            btnPM.addEventListener('click', function() {
                amSchedule.style.display = 'none';
                pmSchedule.style.display = 'block';
            });
        }
       
    });
        async function suway(){
            const response  = await fetch("./HomePageAPI/TheraPistsSched,php",{
                method: POST,
                body: JSON.stringify({
                    'ID' : <?php echo $_SESSION["sess_id"];?>  
                })
            })
        }
</script>
</html>
