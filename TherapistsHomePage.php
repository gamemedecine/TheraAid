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
include("databse.php");
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
$var_Chk = false;

$var_id = $_SESSION["sess_id"];
$var_Tid = "";
$var_GetSched = "SELECT U.User_id,
                             U.Fname,
                             U.Lname,
                             U.Mname,
                             U.profilePic,
                             T.case_handled,
                             T.city,
                             T.Radius,
                             T.therapist_id 
                        FROM tbl_therapists T 
                        JOIN tbl_user U ON T.user_id = U.User_id 
                        WHERE T.user_id =" . $var_id;
$var_qry = mysqli_query($var_conn, $var_GetSched);
if (mysqli_num_rows($var_qry) > 0) {

    $var_Chk = "true";
    $var_rec = mysqli_fetch_array($var_qry);
    $var_ProfPic =  $var_rec["profilePic"];
    $var_Fname = $var_rec["Fname"];
    $var_Lname =  $var_rec["Lname"];
    $var_Mname =  $var_rec["Mname"];
    $var_CaseHndld =  $var_rec["case_handled"];
    $var_City =  $var_rec["city"];
    $var_Radius =  $var_rec["Radius"];
    $var_Tid = $var_rec["therapist_id"];
    $_SESSION["sess_Tid"] = $var_Tid;
}
echo $_SESSION["sess_Tid"];
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
                <a href="TherapistsProfilePage.php" class="nav-link">Profile</a>
                <ul class="logout">
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </ul>
        </div>
    </nav>
    <div class="container-fluid full-height">
        <div class="white-box">
            <div class="flex-container">
                <div class="box">
                    <div class="Details-box  rounded">
                        <div class="TherapistInfo rounded">
                            <img id="ProfPic" class="border rounded-circle" src="" alt="Profile Picture">
                            <p id="fllname"></p>
                            <p id="case_handled"></p>
                            <p id="City"></p>
                            <p id="Radius"></p>


                            <p>Rating: </p>
                        </div>
                        <div class="TherapistScghed">
                            <div id="TimeBTN" class="TimeBTN">
                                <button id="BtnAM">AM</button>
                                <button id="BtnPM">PM</button>
                            </div>
                            <div class="AM" id="AM-schedule">
                                <div class="SchedButton">
                                    <p id="AM"></p>
                                </div>
                            </div>
                            <div class="PM" id="PM-schedule" style="display: none;">
                                <div class="SchedButton">
                                    <!-- PM Schedule content goes here -->
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnAM = document.getElementById('BtnAM');
            const btnPM = document.getElementById('BtnPM');
            const amSchedule = document.getElementById('AM-schedule');
            const pmSchedule = document.getElementById('PM-schedule');
            let TherapID;
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

            async function suway() {
                try {
                    const response = await fetch("./HomePageAPI/TheraPistsAPI.php", {
                        method: "POST", // Ensure "POST" is in quotes
                        body: JSON.stringify({
                            'ID': "<?php echo $_SESSION["sess_id"]; ?>" // Ensure the PHP value is correctly outputted as a string
                        })
                    });
                    const data = await response.json();
                    const fullname = `${data.fname} ${data.mname.charAt(0)}. ${data.lname}`;
                    document.getElementById("fllname").innerText = fullname;
                    document.getElementById("ProfPic").src = `ProfilePic/${data.ProfPic}`;
                    document.getElementById("case_handled").innerText = data.case;
                    document.getElementById("City").innerText = data.city;
                    document.getElementById("Radius").innerText = data.radius;
                    TherapID=data.therapitst_id;

                } catch (error) {
                    console.error('Error:', error); // Log any errors
                }
            }
            async function GetSched(TherapID) {
    try {
        const SchedRes = await fetch("./HomePageAPI/TherapistsSchedAPI.php", {
            method: "POST",
            body: JSON.stringify({
                "TID": TherapID // Therapist ID sent in the request
            }),
            headers: {
                'Content-Type': 'application/json' // Ensure correct content type
            }
        });

        // Parse the response as JSON
        const scheddata = await SchedRes.json();

        // Target the <p id="AM"></p> element
        const amElement = document.getElementById("AM");

        // Clear the content of the element before appending new data
        amElement.innerHTML = "";

        // Check if the response contains a message or schedules
        if (scheddata.message) {
            amElement.innerHTML = scheddata.message; // Display the "No Record found" message
        } else {
            // Loop through each schedule and append its details to the HTML element
            scheddata.forEach(schedule => {
                const schedId = schedule.Sched_id;
                const day = schedule.Day;
                const startTime = schedule.Start_ime;  // Typo: Start_ime in the PHP data
                const endTime = schedule.End_Time;
                const note = schedule.Note;
                const stat = schedule.Status;

                // Create a string of HTML for each schedule
                const scheduleHTML = `
                    <p>Schedule ID: ${schedId}</p>
                    <p>Day: ${day}</p>
                    <p>Start Time: ${startTime}</p>
                    <p>End Time: ${endTime}</p>
                    <p>Note: ${note}</p>
                    <p>Status: ${stat}</p>
                    <hr>
                `;

                // Append the schedule information to the element
                amElement.innerHTML += scheduleHTML;
            });
        }

    } catch (error) {
        console.error('Error:', error);
        document.getElementById("AM").innerHTML = "An error occurred while fetching schedules.";
    }
}
    

            suway(); // Call suway() when the page is fully loaded
            GetSched(TherapID);
        });
    </script>
</body>

</html>