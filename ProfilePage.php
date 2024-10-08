<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Document</title>
</head>
<?php
    include("databse.php");
?>
<style>
    *{
        margin: 0;
        padding: 0;
    }
    body{
        background-color: #6666FF;
    }
    .logout {
            width: 100%;
            background: thistle;
            position: absolute;
            z-index: 999;
            display: none;
            list-style: none; /* Remove default list styling */
            padding: 0; /* Remove default padding */
            margin: 0; /* Remove default margin */
    }

    .logout li {
        padding: 10px; /* Add padding for better clickability */
    }

    .logout li a {
        text-decoration: none; /* Remove underline from links */
        color: black; /* Set text color */
    }

    .nav-item:hover .logout {
        display: block;
    }
    .container{ /* Added container for layout */
        display: flex; /* Use flexbox to align children */
        gap: 20px; /* Add space between the divs */
        padding: 20px; /* Added padding around the container */
        margin-left: 80px;
        margin-right: 0;
    }
    .basicInfo{
        margin-left: 5px;
        margin-top: 5px;;
        background-color: white;
        height: 400px;
        width: 300px;
        border-radius: 10px;
        padding: 0;
    }
    .basicInfo img{
        margin-top: 10px;
        margin-left: 11%;
        box-shadow: 0 5px 8px 1px;
        height: 45%;
    }
    .basicInfo p{
        margin-top: 0;
        padding: 0;
        text-align: center;
        font-size: 15px;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
    }
    .basicInfo button{
        text-align: center;
        margin-left: 38%;
        width: 20%;
    }
    .AddInfo{
        margin-top: 5px;
        margin-right: 0;;
        width: 900px;
        height: 400px;
        border-radius: 10px;
        background-color: white;
    }
</style>
<?php 
    session_start();
    if(!isset($_SESSION["sess_id"])){
        header("location: landingPage.php");
        exit();
    }
    $var_profid =intval($_SESSION["sess_id"]);
    echo $var_profid;
    $var_conn =mysqli_connect("localhost", "root", "", "theraaid");
    $var_qry="SELECT u.User_id,
                     u.Fname, 
                     u.Lname, 
                     u.Mname, 
                     u.Bday,
                     u.E_wallet,
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
                    p.User_id ='$var_profid';";
     $var_chk=mysqli_query($var_conn,$var_qry);
    $var_Fname="";
    $var_Lname="";
    $var_Mname="";
    $var_MI="";
    $var_Age="";
    $var_CntctNum="";
    $var_Email="";
    $var_Case ="";
    $var_CaseDesc ="";
    $var_City ="";
    $var_Stret ="";
    $var_Medpic="";
    $var_Assesment="";
   
    if(mysqli_num_rows($var_chk)>0){
        $var_get=mysqli_fetch_array($var_chk);
        $var_Case=$var_get["P_case"];
        $var_CaseDesc =$var_get["case_desc"];
        $var_City =$var_get["City"];
        $var_Medpic=$var_get["mid_hisotry_photo"];
        $var_Assesment=$var_get["assement_photo"];
        $var_Street =$var_get["street"];
        $var_Fname=$var_get["Fname"];
        $var_Lname=$var_get["Lname"];
        $var_Mname=$var_get["Mname"];
        $var_Date=$var_get["Bday"];
        $var_CntctNum=$var_get["ContactNum"];
        $var_Email=$var_get["Email"];
        $var_year=date("Y");
        $var_MI = substr($var_Mname ,0,1);   
        $var_byear=substr($var_Date,0,4);    
        $var_Age = $var_year-$var_byear;
        $var_Balance =  $var_get["E_wallet"];

    }
    else{
        echo "No records found";
    }
    
    if(isset($_POST["BtnSubmit"])){
        $var_ammnt = floatval($_POST["TxtMoney"]);
        $var_UpdE_wallet = $var_ammnt+$var_Balance;
        
        $var_updt = "UPDATE tbl_user SET E_wallet= $var_UpdE_wallet WHERE User_id =  $var_profid ";
        $var_upqry = mysqli_query($var_conn,$var_updt);
    }
?>
<body>
    <form method="POST" action="ProfilePage.php">
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
                
                <li class="nav-item"><a href="PatientHomePage.php" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="Appointment.php" class="nav-link">Appointment</a></li>
                <li class="nav-item"><a class="nav-link">History</a></li>
                <li class="nav-item"><a class="nav-link">Reminder</a></li>
                <li class="nav-item"><a class="nav-link">Notification</a></li>
                <li class="nav-item"><a class="nav-link">Chat</a></li>
                <li class="nav-item">
                    <a href="ProfilePage.php" class="nav-link">Profile</a>
                    <ul class="logout">
                        <li><a href="#">Logout</a></li>
                    </ul>
                </li>
            </ul> 
        </div>
    </nav>
    <div class="container"> <!-- Added container for layout -->
        <div class="basicInfo">
            <img class="rounded-circle" src="photos/profile.jpg" alt="Profile Pic"><br><br>
            <p><?php echo $var_Fname." ".$var_MI.". ".$var_Lname;?></p>
            <p><?php echo $var_Age;?></p>
            <p><?php echo $var_CntctNum;?></p>
            <p><?php echo $var_Email;?></p>
            <button>Edit</button>
        </div>
        <div class="AddInfo">
            <div class="Case row">
                        <div class="col-md-6">
                            <p>Case : <?php echo $var_Case;?></p><br>
                            <h2>Balance ₱<?php echo $var_Balance;?></h2>
                            <p>Description : <?php echo $var_CaseDesc;?></p>
                        </div>
                        <div class="col-md-6">
                            <label>Address:</label><br>
                            <p>City : <?php echo $var_City;?></p><br>
                            <p>Barangay/Street : <?php echo $var_Street;?></p>                            
                        </div>
            </div>
            <div class="MedHistory mt-3">
                    <label>Medical History</label><br>
                    <img src="medrec/<?php echo $var_Medpic?>" alt="Medical History">
                    </div>
                <div class="Asessment mt-3">
                    <label>Medical Assessment</label><br>
                    <img src="medrec/<?php echo $var_Assesment?>" alt="Medical Asessment">
                </div> 
               
        </div>   
    </div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Launch demo modal
</button>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">E_wallet</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h3>Balance: <?php echo $var_Balance?></h3>
            <label>Top up</label><input type="text" name="TxtMoney" placeholder="₱" required>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="BtnSubmit" class="btn btn-primary">Top-up</button>
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
    width: 200px; /* Adjust width as needed */
    height: auto; /* Keep the aspect ratio */
    object-fit: cover; /* Fit image inside the box */
    border-radius: 10px; /* Rounded corners */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Optional box shadow */
}

.MedHistory, 
.Asessment {
    margin-top: 15px;
}

</style>