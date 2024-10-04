<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="TherapistsDesign/TherapistsHomePage.css">

    <title>TheraAid</title>
</head>
<?php
include("databse.php");
session_start();

echo  "therapists ID".$_SESSION["sess_PTID"]."\n";
echo "Patient ID".$_SESSION["sess_PtntID"]."\n";


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
                            <p id="ID"></p>

                            <p>Rating: </p>
                        </div>
                        <div class="TherapistScghed">
                            <div id="TimeBTN" class="TimeBTN">
                                <button id="BtnAM">AM</button>
                                <button id="BtnPM">PM</button>
                            </div>
                            <div class="AM" id="AM-schedule">
                                <div class="SchedButton">
                                    <div id="AM"></div>
                                </div>
                            </div>
                            <div class="PM" id="PM-schedule" style="display: none;">
                                <div class="SchedButton">
                                    <!-- PM Schedule content goes here -->
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!---->


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

            async function PTProf() {
                try {
                    const response = await fetch("./PatientViewAPI/TherapistsProfAPI.php", {
                        method: "POST",
                        body: JSON.stringify({
                            'ID': "<?php echo $_SESSION["sess_PTID"]; ?>"
                        })
                    });
                    const data = await response.json();
                    const fullname = `${data.fname} ${data.mname.charAt(0)}. ${data.lname}`;
                    document.getElementById("fllname").innerText = "Name :" + fullname;
                    document.getElementById("ProfPic").src = `ProfilePic/${data.ProfPic}`;
                    document.getElementById("case_handled").innerText = "Case Handled :" + data.case;
                    document.getElementById("City").innerText = "City :" + data.city;
                    document.getElementById("Radius").innerText = "Radius :" + data.radius;
                    // Assign therapist's ID to the global variable
                    TherapID = data.therapitst_id;
                    // Now call GetSched with the therapist's ID
                    GetSched(TherapID);

                } catch (error) {
                    console.error('Error:', error);
                }
            }

            async function GetSched(TherapID) {
                try {
                    const SchedRes = await fetch("./HomePageAPI/TherapistsSchedAPI.php", {
                        method: "POST",
                        body: JSON.stringify({
                            "TID": TherapID
                        }),
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    });

                    const scheddata = await SchedRes.json();
                    const amElement = document.getElementById("AM");
                    amElement.innerHTML = "";

                    if (scheddata.message) {
                        amElement.innerHTML = scheddata.message;
                    } else {
                        scheddata.forEach(schedule => {
                            var SchedID = schedule.Sched_id;
                            var SchedDay = schedule.Day;
                            var SchedDay = schedule.Day;
                            var Stime = schedule.Start_ime;
                            var Etime = schedule.End_Time;
                            var Note = schedule.Note;
                            const scheduleHTML = `
                            <button class="schedule-btn" value="${SchedID}">${schedule.Day}<br>
                            ${Stime}/${Etime}<br>${Note}
                            </button>
                        `;
                            amElement.innerHTML += scheduleHTML;
                            const buttons = amElement.querySelectorAll('.schedule-btn');
                            buttons.forEach(function(button) {
                                button.addEventListener('click', function() {
                                    var SlctedID = this.value;
                                    SessionSched(SlctedID); 
                                });
                            })

                        });
                    }

                } catch (error) {
                    console.error('Error:', error);
                    document.getElementById("AM").innerHTML = "An error occurred while fetching schedules.";
                }
            }
            function  SessionSched(SlctedID){
                fetch("./PatientViewAPI/SelectedDateAPI.php",{
                    method: "POST",
                    body: JSON.stringify({
                        SchedID:SlctedID
                    })
                });
                window.location.href = "PatAppointment.php";

            }


            // Call suway() when the page is fully loaded
            PTProf();
        });
    </script>

</body>

</html>