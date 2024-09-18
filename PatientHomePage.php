<!DOCTYPE html>
<html lang="en">

<head>
    <?php session_start();
    $_SESSION["sess_id"];
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>TheraAid</title>
    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            background-color: #6666FF;
        }

        .white-box {
            background-color: white;
            padding: 0;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            margin-top: 10px;
        }

        .full-height {
            height: 100vh;
            /* Full viewport height */
        }

        .Details-box {
            width: 200px;
            height: 800px;
            margin-left: 0;
            padding: 0;
        }
        .box{
            display: flex;              /* Make the container a flexbox */
            width: 100%;                /* Set the width of the entire container */
            height: 800px;              /* Set the height of the outer box */
            border: 1px solid #000; 
            column-gap: 200px; 
        }

        .TherapistInfo {
            height: 400px;
            width: 400px;
            border-style: solid;
            border-width: 2px;
            /* Adjust thickness */
            border-color: black;
          
        }

        .TherapistScghed {
            height: 400px;
            width: 400px;
            border-style: solid;
            border-width: 2px;
            /* Adjust thickness */
            border-color: black;
           
        }

        .profile img {
            margin-left: 70px;
            margin-top: 10px;
        }

        .TimeBtn input {
            width: 190px;
            height: 70px;
            margin-left: 4px;
            padding: 0;
        }

        .AM p,
        .PM p {
            width: 300px;
            height: 100px;
            text-align: center;
            margin-top: 15px;
            margin-left: 11%;
            background-color: aquamarine;
            border-radius: 20px;
            font-size: 50px;
        }

       

        .Patients {
            /* Adjust width and height as needed */
            width: 100%;
            height: 800px;
            /* Set height if needed */
            border-style: solid;
            border-width: 2px;
            /* Adjust thickness */
            border-color: black;
            /* Set border color to black */
            margin: 0;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .Searchbar {
                width: 90%;
                /* Make the entire search bar narrower on smaller screens */
                margin-left: 5%;
                /* Center it more naturally */
                margin-top: 20px;
                /* Reduce the top margin */
            }

            .Searchbar input,
            .Searchbar button {
                width: 70%;
                /* Adjust widths to fit the screen better */
                margin-left: 0;
                /* Remove the extra margin */
            }

            .Searchbar button {
                width: 28%;
                /* Keep the button smaller */
            }


        }

        .logout {
            width: 100%;
            background: thistle;
            position: absolute;
            z-index: 999;
            display: none;
            list-style: none;
            /* Remove default list styling */
            padding: 0;
            /* Remove default padding */
            margin: 0;
            /* Remove default margin */
        }

        .logout li {
            padding: 10px;
            /* Add padding for better clickability */
        }

        .logout li a {
            text-decoration: none;
            /* Remove underline from links */
            color: black;
            /* Set text color */
        }

        .nav-item:hover .logout {
            display: block;
        }
        .hi{
            height: 800px;
            width: 1500px;
            border-style: solid;
            border-width: 2px;
            /* Adjust thickness */
            border-color: black;
            /* Set border color to black */
           
        }
       
        
    </style>
</head>
<?php


if (!isset($_SESSION["sess_id"])) {
    header("location: landingPage.php");
    exit();
}
$var_Fname = "";
$var_Lname = "";
$var_Mname = "";
$var_CaseHndld = "";
$var_City = "";
$var_Radius = "";
$var_id = $_SESSION["sess_id"];
$var_conn = mysqli_connect("localhost", "root", "", "theraaid");
$var_getTherapists = "SELECT U.User_id,
                                 U.Fname,
                                 U.Lname,
                                 U.Mname,
                                 P.P_case,
                                 P.case_desc,
                                 P.City,
                                 P.street,
                                 P.assement_photo,
                                 P.mid_hisotry_photo
                                FROM tbl_patient P JOIN tbl_user U 
                                ON P.user_id = U.User_id WHERE P.user_id =" . $var_id;
$var_qry = mysqli_query($var_conn, $var_getTherapists);
if ($var_qry) {
    $var_rec = mysqli_fetch_array($var_qry);

    $var_Fname = $var_rec["Fname"];
    $var_Lname = $var_rec["Lname"];
    $var_Mname = $var_rec["Mname"];
    $var_CaseHndld = $var_rec["P_case"];
    $var_City = $var_rec["City"];
    $var_Radius = $var_rec["street"];
} else {
    echo "Error";
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
        <div class="collapse navbar-collapse mt-5" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a href="Appointment.php" class="nav-link">Appointment</a></li>
                <li class="nav-item"><a class="nav-link">History</a></li>
                <li class="nav-item"><a class="nav-link">Reminder</a></li>
                <li class="nav-item"><a class="nav-link">Notification</a></li>
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

                        </div>
                        <div class="TherapistScghed">

                        </div>
                    </div>
                    <div class="hi">
                            <h1>Hi</h1>
                    </div>
                </div>

            </div>

        </div>


    </div>


    <script>
        document.getElementById('BtnAM').addEventListener('click', function() {
            document.getElementById('AM-schedule').style.display = 'block';
            document.getElementById('PM-schedule').style.display = 'none';
        });

        document.getElementById('BtnPM').addEventListener('click', function() {
            document.getElementById('AM-schedule').style.display = 'none';
            document.getElementById('PM-schedule').style.display = 'block';
        });
    </script>







    <!--   <div class="Searchbar">
                <input type="text" name="TxtLocation"  placeholder="Search Locationn">
                <button type="button" name="TxtSearch">Search</button>
        </div> -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>