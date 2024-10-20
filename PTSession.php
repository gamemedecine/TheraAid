<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
    include("databse.php");
    session_start();
    echo $_SESSION["sess_PATID"];
    $var_appid =  $_SESSION["sess_PATID"];
    date_default_timezone_set('Asia/Manila'); // Change to your timezone
    $var_crrntTime =date("h:i:sa");
    //$var_currntDate = date("Y-m-d");
    $var_currntDate = "2024-10-18";
    echo $var_currntDate."<br>";
    echo  $var_crrntTime;

    
    $var_sessionList = "SELECT * FROM tbl_session  WHERE appointment_id =".$var_appid;
    $var_Slist = mysqli_query($var_conn,$var_sessionList);

    
       

    
    

    
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="patientDesign/PHomepage.css">
    <title>TheraAid</title>

</head>


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
        <div class="collapse navbar-collapse mt-5" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a href="TherapistsAppointment.php" class="nav-link">Appointment</a></li>
                <li class="nav-item"><a class="nav-link">History</a></li>
                <li class="nav-item"><a class="nav-link" href="TherapistsReminder.php">Reminder</a></li>
                <li class="nav-item"><a class="nav-link">Notification</a></li>
                <li class="nav-item"><a class="nav-link">Chat</a></li>
                <a href="TherapistsProfilePage.php" class="nav-link">Profile</a>
                <ul class="logout">
                    <li><a href="logout.php">Logout</a></li>
                </ul>
                </li>
            </ul>
        </div>
    </nav>
    <form method="POST" action="PTSession.php">
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
                                <p id ="sess">hellos</p>

                            </div>
                        </div>
                        <div class="hi">
                            <div id="Therapists" style="padding-left: 20px; padding-top: 50px;">
                                <div class="SessionList">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Session">
                                        +
                                    </button>
                                   
                                </div>
                                <div id="sessions">
                                <p id="check"></p>
                                
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

            </div>


        </div>


        <!-- Modal -->
        <div class="modal fade" id="Session" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Session</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <button type="button" id="StartSession" class="btn btn-primary">Start Session</button>
                        <!-- <label>Note:</label><br>
                        <textarea  style="height:100px; width: 100%;" name="TxtDuration" ></textarea> -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                       
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Edit Session-->
        <div class="modal fade" id="Editsess" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Session</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label>Note:</label><br>
                        <textarea  style="height:100px; width: 100%;" name="TxtDuration" ></textarea>
                        <input type="file" name="SessPhotos" multiple>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="StartSession" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                       
                    </div>
                </div>
            </div>
        </div>
    </form>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let city;
            let caseDesc;
            let PtntID;
            let AppntmntId;
            async function GETPatient() {
                try {
                    const response = await fetch("./PTSESSIONAPI/PTsessionAPI.php", {
                        method: "POST",
                        body: JSON.stringify({
                            "PTID": "<?php echo $_SESSION["sess_PATID"]; ?>"
                        })
                    });
                    const data = await response.json();
                    const fullname = `${data.fname} ${data.mname.charAt(0)}. ${data.lname}`;
                    document.getElementById("fllname").innerText = "Name :" + fullname;
                    document.getElementById("ProfPic").src = `ProfilePic/${data.profPic}`;
                    document.getElementById("case").innerText = "Case :" + data.case;
                    document.getElementById("City").innerText = "City :" + data.city;
                    document.getElementById("sess").innerText = "Session:" + data.Session;
                    AppntmntId = data.APID;
                    city = data.city;
                    caseDesc = data.case;
                    PtntID = data.PtntID;


                } catch (error) {
                    console.error('Error:', error);
                }
            }

          

            GETPatient();
            document.getElementById("StartSession").addEventListener("click",() => {
                checkSession(AppntmntId);});

            async function checkSession(AppntmntId){
                try{
                    const response = await fetch("./PTSESSIONAPI/PTcheckSession.php",{
                        method:"POST",
                        body:JSON.stringify({
                            "appId":AppntmntId
                        })
                    })
                    const res =await response.text();
                    if(res == "1"){
                        alert(AppntmntId+"  "+"You have already started a session!");
                    }
                    else if(res =="2"){
                        alert(AppntmntId+"  "+"You dont Have a session today!");
                    }
                    else if(res =="0"){
                        alert(AppntmntId+"  "+"New session have been added!");
                    }
                  
                }
               
            catch (err){
                console.error(err.message);

            }
        }
    
            
    });
    
    </script>









    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>
<style>
    .SessionList button {
        font-size: 50px;
        background-color: blanchedalmond;
        width: 70px;
        height: 70px;
        text-align: center;
        border-radius: 50px;
        color: black;
    }
    .sessions,button{
        width: 100%;
        background-color: azure;
        font-size:20px;
        border-radius:25px;
        height: 60px;
    }
  
</style>