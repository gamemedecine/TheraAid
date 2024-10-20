<!DOCTYPE html>
<html lang="en">

<head>
    <?php session_start();
   echo $_SESSION["sess_id"];
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="patientDesign/PHomepage.css">
    <title>TheraAid</title>

</head>
<?php
include("databse.php");
$var_rrminder;
  /// QEUERY RHE REMINDER USING THE SESSIONED USER_ID "sess_id"
  $var_remind = 
  "SELECT TB.reminder_date, 
  TB.reminder_messsage,
   TB.reminder_status 
  FROM tbl_reminder TB 
  JOIN tbl_appointment AP ON AP.appointment_id = TB.appointment_id JOIN tbl_patient P ON P.patient_id = AP.patient_id 
  JOIN tbl_user U ON U.User_id = P.user_id WHERE P.user_id=".$_SESSION["sess_id"];
  $var_Rqry = mysqli_query($var_conn,$var_remind);
  $var_message ="";

  $var_sampleDate = "2024-10-12";// EXAMPLE
  $var_currentDate = date($var_sampleDate);//date('Y-m-d');
 echo "current Date ".$var_currentDate."<br>";
  if(mysqli_num_rows($var_Rqry)>0){
    $var_Rrec = mysqli_fetch_array($var_Rqry);
    $var_Date = explode(",",$var_Rrec["reminder_date"]);
    echo "Upcoming Date";
    print_r($var_Date);
    if(in_array($var_currentDate,$var_Date)){
        $var_message= $var_Rrec["reminder_messsage"];
    }   
    else{
        $var_message= "No Session for today";
    }
   
  
  }else{
    $var_message= "";
  }
  
  
?>

<body>
    <?php
        if($var_Rqry){
            echo "<h1>".$var_message."</h1>";
          }
    ?>
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
        <div class="collapse navbar-collapse mt-5" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a href="PATAppointmentList.php" class="nav-link">Appointment</a></li>
                <li class="nav-item"><a class="nav-link">History</a></li>
                <li class="nav-item"><a class="nav-link">Reminder</a></li>
                <li class="nav-item"><a href="PATnotif.php" class="nav-link">Notification</a></li>
                <li class="nav-item"><a class="nav-link">Chat</a></li>
                <li class="nav-item">
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
                        <div class="TherapistInfo">
                            <img id="ProfPic" class="border rounded-circle" style="width: 200px; height: 180px;" src="" alt="profile Picture">
                            <br><br>
                            <p id="fllname"></p>
                            <p id="case"></p>
                            <p id="City"></p>

                        </div>
                    </div>
                    <div class="hi">
                        <div id="Therapists" style="padding-left: 20px; padding-top: 50px;">
                            <div id="PT">

                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>


    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let city;
            let caseDesc;
            let PtntID;
            async function GETPatient() {
                try {
                    const response = await fetch("./PatientHomePageAPI/PatientInfoAPI.php", {
                        method: "POST",
                        body: JSON.stringify({
                            "PID": "<?php echo $_SESSION["sess_id"]; ?>"
                        })
                    });
                    const data = await response.json();
                    const fullname = `${data.fname} ${data.mname.charAt(0)}. ${data.lname}`;
                    document.getElementById("fllname").innerText = "Name :" + fullname;
                    document.getElementById("ProfPic").src = `ProfilePic/${data.profPic}`;
                    document.getElementById("case").innerText = "Case :" + data.case;
                    document.getElementById("City").innerText = "City :" + data.city;

                    city = data.city;
                    caseDesc = data.case;
                    PtntID = data.PtntID;
                   
                    SessionPNTID(PtntID);
                    GETtherapists(city, caseDesc);
                  
                } catch (error) {
                    console.error('Error:', error);
                }
            }

            GETPatient();

            async function GETtherapists(city, caseDesc) {
                try {
                    const therapists = await fetch("./PatientHomePageAPI/GETtherapistsAPI.php", {
                        method: "POST",
                        body: JSON.stringify({
                            "city": city,
                            "case": caseDesc
                        })
                    });

                    const ThrpstData = await therapists.json();
                    const PTElement = document.getElementById("PT");

                    // Clear previous results
                    PTElement.innerHTML = '';

                    if (ThrpstData.message) {
                        PTElement.innerHTML = ThrpstData.message; // Fixed the element reference
                    } else {
                        ThrpstData.forEach(therapist => {
                            const fullname = `${therapist.fname} ${therapist.mname.charAt(0)}. ${therapist.lname}`;
                            const PTBTN = document.createElement('button'); // Create button element
                            PTBTN.value = therapist.TID; // Set the button value
                            PTBTN.innerHTML = `${fullname}<br>Case Handled: ${therapist.case}<br>City: ${therapist.city}`;

                            // Add event listener for button click
                            PTBTN.addEventListener('click', function() {
                                var SlctedID = this.value;
                                SessionID(SlctedID); 
                                //  alert(SlctedID+"  "+PtntID);
                            });

                            PTElement.appendChild(PTBTN); // Append button to PTElement
                        });
                    }
                } catch (error) {
                    console.log('Error:', error);
                }
            }
            function  SessionID(id){
                fetch("./PatientHomePageAPI/SessionAPI.php",{
                    method: "POST",
                    body: JSON.stringify({
                        PTID: id,
    
                    })
                });
                window.location.href = "PatientView.php";

            }
            function  SessionPNTID(PtntID){
                fetch("./PatientHomePageAPI/SessionPID.php",{
                    method: "POST",
                    body: JSON.stringify({
                        PNTID: PtntID,
                    })
                });
              
            }
        });
       
        
    </script>









    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>