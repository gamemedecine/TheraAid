<!DOCTYPE html>
<html lang="en">
<head>
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
        #Services,
        #AboutUs {
            min-height: 540px;
            padding: 40px 0;
        }
        #Services {
            background-color: #6633CC;
        }
        #AboutUs {
            background-color: #6699FF;
        }
        .Register-button {
            background-color: #9999CC;
            color: #000;
            padding: 0.5em 1em;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            width: 100px;
            text-align: center;
        }
        .Register-button:hover {
            background-color: #e6b800;
        }
        .login-form {
            max-width: 400px;
            margin-top: 20px;
        }
        .login-form .form-control {
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .login-form .btn {
            width: 100%;
            border-radius: 5px;
        }
        .d-flex {
            display: flex;
            flex-wrap: wrap; /* Ensure wrapping */
        }
        .text-column {
            flex: 1;
            padding-right: 20px;
        }
        .image-column {
            flex: 1;
            max-width: 100%;
        }
        .big-image {
            width: 100%;
            max-width: 800px;
            border-radius: 25px;
        }
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .d-flex {
                flex-direction: column;
                align-items: center;
            }

            .text-column, .image-column {
                width: 100%; /* Full width on smaller screens */
                text-align: center;
                padding: 0;
            }

            .big-image {
                max-width: 100%; /* Prevent overflow */
            }

            .Register-button, .btn {
                width: 100%; /* Full width on mobile */
            }
           
        }
    </style>
</head>
<?php
    session_start();
    
    if(isset($_SESSION["sess_id"])){
        // Redirect based on user type
        if($_SESSION["sess_Utype"] == "P"){
            header("location: PatientHomePage.php");
            exit;
        }
        if($_SESSION["sess_Utype"] == "T"){
            header("location: TherapistsHomePage.php");
            exit;
        }
    }
    

    $var_conn = mysqli_connect("localhost", "root", "", "theraaid");
    $var_Username = "";
    $var_Password = "";
    $var_prompt= false;

    if(isset($_POST["BtnSubmit"])){
        $var_Username = trim($_POST["TxtUsername"]);
        $var_Password = md5($_POST["TxtPassword"]);
    
        $var_chk = "SELECT * FROM tbl_user WHERE UserName = '".$var_Username."' 
                    AND Password='".$var_Password."'";
    
        $var_rec = mysqli_query($var_conn, $var_chk);
        
        if(mysqli_num_rows($var_rec) > 0){
            $var_record = mysqli_fetch_array($var_rec);
            $var_Utype = $var_record["user_type"];
            $_SESSION["sess_Utype"] = $var_Utype;
            $_SESSION["sess_id"] = $var_record["User_id"];
            
            if($var_Utype == "P"){
                header("location: PatientHomePage.php");
                exit;
            }
            if($var_Utype == "T"){
                header("location: TherapistsHomePage.php");
                exit;
            }
        } else {
            $var_prompt = true;
        }
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
        <div class="collapse navbar-collapse d-flex justify-content-end mt-5" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a href="#Services" class="nav-link">Services/Features</a></li>
                <li class="nav-item"><a href="#AboutUs" class="nav-link">About Us</a></li>
                <li class="nav-item"><a href="SelectionPage.php" class="nav-link Register-button">Register</a></li>
            </ul> 
        </div>
    </nav>
   
        <!-- Main content section -->
        <div class="container mt-5 text-light">
            <div class="d-flex align-items-center">
                <!-- Column for text content -->
                <div class="text-column">
                    <p class="display-6 fw-medium">Connecting You to Physical Therapy Care</p>
                    <p class="fw-medium">Connects you to expert, personalized physical therapy care.</p>
                    <!-- Login Form -->
                    <form class="login-form" method="POST" action="landingPage.php">
                        <div class="mb-3">
                            <?php if($var_prompt) echo '<p style="color:red; font-weight: bold;">Incorrect username and password.Please try again.</p>';?>
                            <input type="text" class="form-control" value="<?php echo $var_Username;?>"name="TxtUsername" placeholder="Enter your username">
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="TxtPassword" placeholder="Enter your password">
                        </div>
                        <button type="submit" class="btn btn-primary"  name="BtnSubmit">Login</button>
                    </form>
                </div>
                <div class="image-column">
                    <img src="Photos/Background.jpg" alt="Therapy Image" class="img-fluid rounded big-image">
                </div>
            </div>
        </div>
    
   
    <!-- Services/Features Section -->
    <section id="Services">
        <div class="container">
            <h2 class="text-center text-light">Services/Features</h2>
            <p class="text-light">TheraAid facilitates seamless virtual therapy sessions, connecting patients with licensed physical therapists from the comfort of their homes. This service aims to enhance accessibility to quality healthcare by offering a convenient and flexible alternative to in-person visits.</p>
            <ul class="text-light">
                <li><strong>Credential Verification:</strong> Each therapist is thoroughly vetted and verified for legitimacy and competence, ensuring patients receive care from qualified professionals.</li>
                <li><strong>User-Friendly Platform:</strong> Our intuitive interface makes scheduling and attending sessions straightforward for both patients and therapists.</li>
                <li><strong>Customizable Scheduling:</strong> Patients can choose appointment times that fit their schedules, while therapists can manage their availability with ease.</li>
                <li><strong>Comprehensive Resource Access:</strong> The platform provides patients with access to a range of resources, including exercise plans, educational materials, and progress tracking tools.</li>
                <li><strong>Secure Communication:</strong> Sessions are conducted using encrypted video calls, ensuring privacy and confidentiality during consultations.</li>
                <li><strong>Feedback Mechanism:</strong> Patients and therapists can provide feedback on their experience, helping us continuously improve the service and address any issues promptly.</li>
            </ul>
        </div>
    </section>
   
    <!-- About Us Section -->
    <section id="AboutUs">
        <div class="container">
            <h2 class="text-center text-light">About Us</h2>
            <p class="text-center text-light fs-4">At TheraAid, we recognize the challenges traditional healthcare faced during the COVID-19 pandemic and have developed a solution to meet these needs. Our platform connects patients with licensed physical therapists, offering a convenient way to access high-quality care from the comfort of home. We aim to simplify the process of finding qualified therapists, scheduling appointments, and enhancing communication between patients and therapists. By understanding physicians' perspectives on physical therapy, we ensure better integration and referral practices. TheraAid addresses issues such as internet connectivity and technical support, striving to provide a seamless and supportive experience. Our mission is to improve accessibility, make therapy more personalized, and support better patient outcomes through innovative digital solutions. We are committed to transforming rehabilitation services and making quality care available to everyone.</p>
        </div>
    </section>

    <script src="js/bootstrap.bundle.min.js" ></script>
</body>
</html>
