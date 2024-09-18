<!DOCTYPE html>
<html lang="en">
<?php
    session_start();
    $_SESSION["sess_Utype"];
    $var_conn = mysqli_connect("localhost", "root", "", "theraaid");
    $var_Fname = "";
    $var_Lname = "";
    $var_Mname = "";
    $var_Date = "";
    $var_Uname = "";
    $var_password = "";
    $var_CnfrmPass = "";
    $var_CntctNum = "";
    $var_Email = "";
    $dateFormatted = "";
    $var_yyyy = "";
    $var_mm = "";
    $var_dd = "";
    $var_Errors="";
    $var_valdte = false;
    $var_chk=false;
    $var_len=false;
    $var_usr=false;
    $var_ProfilePic="";
    $var_filePath="";

    function Validatetext($var_text) {
       
        if(is_numeric($var_text))
       
        return True;
    }
 

    // --------------------------- PHP --------------------------------
    if (isset($_POST["BtnSubmit"])) {
        $var_Fname = trim($_POST["TxtFname"]);
        $var_Lname = trim($_POST["TxtLname"]);
        $var_Mname = trim($_POST["TxtMname"]);
        $var_Date = trim($_POST["DateBday"]);
        $var_Uname = trim($_POST["TxtUsrname"]);
        $var_password = $_POST["TxtPassword"];
        $var_CnfrmPass = $_POST["TxtConfirmPassword"];
        $var_CntctNum = trim($_POST["TxtCntctNum"]);
        $var_Email = trim($_POST["TxtEmail"]);
        $dres = explode('-', $var_Date);
        $var_yyyy = $dres[0];
        $var_mm = $dres[1];
        $var_dd = $dres[2];
        $var_newdate = $var_yyyy . "-" . $var_mm . "-" . $var_dd;

        echo $var_password." ".$var_CnfrmPass;
        if($var_password != $var_CnfrmPass){
            echo "Pass not matched";
            $var_chk=true;
        }
        if(strlen($var_password) < 8 ){
            $var_len = true;
        }
        if(!is_numeric($var_CntctNum) || strlen($var_CntctNum) != 11){ 
            $var_valdte = True;  $var_Errors = "Error";
        } 
        

        if(Validatetext($var_Fname) || Validatetext($var_Lname) || Validatetext($var_Mname) || Validatetext($var_Email)){
            $var_Errors = "Errors";
        }
        $var_chkusr = "SELECT * FROM tbl_user WHERE UserName ='".$var_Uname."'" ;
        $var_usrchk = mysqli_query($var_conn,$var_chkusr);
        if(mysqli_num_rows($var_usrchk)>0){
            $var_usr= True;
            $var_Errors = "Error";
        }
        $var_img = $_FILES['ProfilePic'];
        $var_fileName = $_FILES['ProfilePic']['name'];
        $var_fileTmpName = $_FILES['ProfilePic']['tmp_name'];
        $var_fileSize = $_FILES['ProfilePic']['size'];
        $var_fileError = $_FILES['ProfilePic']['error'];
        $var_filetype = $_FILES['ProfilePic']['type'];
        $fileExt = explode('.', $var_fileName);
        $fileActualExt = strtolower(end($fileExt));
        

        $allowed = array('jpg', 'jpeg', 'png', 'pdf');
        
        if(in_array($fileActualExt,$allowed))
        {
            if($var_fileError === 0 ){
                if($var_fileSize < 1000000 ){
                    $fileNewName = uniqid('',true).".".$fileActualExt;
                    
                    
                    $fileDestination = 'ProfilePic/'.$fileNewName;
                    

                    move_uploaded_file($var_fileTmpName, $fileDestination);
                    
                }
                else{
                    echo "One or more files are too big!";
                    $var_Errors="Errors";
                    
                }
            }
            else{
                echo "There was an error uploading one or more files!";
                $var_Errors="Errors";
            }
        }
        else{
            echo "Invalid file type format!";
            $var_Errors="Errors";
        }
        if($var_Errors != "")
        {
            echo "Errors";
        }
        if($var_Errors == ""){
            echo "Proceed";
            $var_Utype = $_SESSION["sess_Utype"];
            $var_encryptPass = md5($var_password);
            $var_insrt = "INSERT INTO tbl_user(Fname,Lname,Mname,Bday,UserName,Password,ContactNum, Email,user_type,profilePic)
                           VALUES('$var_Fname','$var_Lname','$var_Mname','$var_newdate', '$var_Uname','$var_encryptPass','$var_CntctNum','$var_Email','$var_Utype','$fileNewName')";
            $var_qry = mysqli_query($var_conn, $var_insrt);
            $var_Uid = $var_conn->insert_id;
            $_SESSION["sess_id"]=$var_Uid;
           
            if($var_qry){
                if($_SESSION["sess_Utype"] == "P"){
                    header("location: PatientRegistrationPrt2.php");
                    exit;
                }
                if($_SESSION["sess_Utype"] == "T"){
                    header("location: TherapistsRegistration.php");
                    exit;
                }
            }
            else{
                echo "Submission Error!";
            }
            
        }   
        
    }
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Patient Registration</title>
</head>
<body>
    <div class="top">
        <div class="logo">
            <img src="Photos/Logo.jpg" alt="TheraAid Logo" class="rounded-circle mb-0 d-inline-block align-top">
            <h1>TheraAid</h1>
        </div>
    </div> 
    
    <form action="UserRegistration.php" method="POST" enctype="multipart/form-data">
        <div class="card"> 
            <div class="white-section">
                <div class="PersonalInfo">
                    <h5>Personal Information</h5>
                    <input type="text"  name="TxtFname"  <?php if(Validatetext($var_Fname)) echo 'class="error"';?> value="<?php echo $var_Fname;?>"placeholder="Firstname"> 
                    <?php if(Validatetext($var_Fname)) echo '<p class="promt">Please Enter A Proper Name</p>'?>
                    <input type="text" name="TxtLname"   <?php if(Validatetext($var_Lname)) echo 'class="error"'; ?> value="<?php echo $var_Lname;?>"placeholder="Lastname"> 
                    <?php if(Validatetext($var_Lname)) echo '<p class="promt">Please Enter A Proper Last Name</p>'?>
                    <input type="text" name="TxtMname" <?php if(Validatetext($var_Mname)) echo 'class="error"';?> value="<?php echo $var_Mname;?>"placeholder="Middlename"> 
                    <?php if(Validatetext($var_Mname)) echo '<p class="promt">Please Enter A Proper Last Middleame</p>'?>
                    <label>Birthdate</label><br>
                    <input type="date" value="<?php echo $var_Date;?>" name="DateBday" required/>
                    <input type="text" value="<?php echo $var_Uname; ?>" <?php if($var_usr) echo 'class="error"';?> name="TxtUsrname" placeholder="Username">
                    <?php  if($var_usr) echo '<p class="promt">Username Already Exist..</p>';?>
                    <input type="password" <?php if($var_chk || $var_len){ echo 'class="error"';}?> name="TxtPassword"  value="<?php echo $var_password?>"placeholder="Password">
                    <?php  if($var_len) echo '<p class="promt">Password too weak</p>';?>
                    <input type="password" <?php if($var_chk) echo 'class="error"';?> name="TxtConfirmPassword"   value="<?php echo $var_CnfrmPass?>" placeholder="Confirm Password">
                    <?php if($var_chk) echo '<p class="promt">Password dont match</p>'?><br>
                    <a>Profile Photo</a>
                    <input type="file" value="<?php echo $var_ProfilePic;?>" name="ProfilePic" class="form-control" placeholder="Profile Pic">
                    <br>
                    <br>    
                </div>
            </div>
            <div class="purple-section">
                <div class="Contact">
                    <h5>Contact And Address Details</h5>
                    <input type="text" <?php if($var_valdte) echo 'class="error"';?>name="TxtCntctNum"  value="<?php echo $var_CntctNum;?>"placeholder="Contact Number" maxlength="11"> 
                    <?php if($var_valdte) echo '<p class="promt">Please Enter A Proper Contact Numbere / Contact number should be 11 numbers</p>'?>
                    <input type="text"  <?php if(Validatetext($var_Email)) echo 'class="error"';?>name="TxtEmail"  value="<?php echo $var_Email;?>"placeholder="Email">
                    <?php if(Validatetext($var_Email)) echo '<p class="promt">Please Enter A Proper Last Middleame</p>'?>
                    <br>
                </div>
                <input class="submit" type="submit" name="BtnSubmit" value="Submit"><br><br>
                <a>Already have an account? <a href="landingPage.php">Login</a></a>
            </div>
        </div>
    </form>
  
    <script defer src="javascript/bootstrap.min.js"></script>
</body>
<style> 
    *{
        padding: 0;
        margin: 0;
    }
    body {
        background-color: #6666FF; /* 1: Background color for the entire page */
    }
    
    .top {
        display: flex; /* 2: Flexbox for aligning logo and text */
        align-items: center;
        padding: 20px; /* Added padding for spacing */
    }
    .logo {
        display: flex;
        align-items: center;
    }
    .logo img {
        margin-right: 10px; /* 3: Space between logo image and text */
        width: 150px;
    }
    .logo h1 {
        margin: 0;
        font-size: 3rem; /* 4: Font size for logo text */
        font-weight: bold;
        color: Black;
    }
    .card {
    width: 100%; /* Full width to be responsive */
    max-width: 800px; /* Maximum width for large screens */
    border-radius: 25px;
    text-align: center;
    margin: 20px auto; /* Centered card with margin */
    box-shadow: 0 10px 10px 2px;
    display: flex;
    flex-direction: row;
    flex-wrap: wrap; /* Allows wrapping of content on smaller screens */
}

.white-section, .purple-section {
    flex: 1; /* Allow sections to grow and shrink equally */
    min-width: 0; /* Ensure sections can shrink below their initial size if needed */
}

.white-section {
    background-color: white;
    border-top-left-radius: 25px;
    border-bottom-left-radius: 25px;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column; /* Center content vertically and horizontally */
}
.PersonalInfo .error, .Contact .error{
    border-style: solid;
    border-color: red;
    border-width: 2px;
}
.PersonalInfo .promt, .Contact .promt{
    color: red;
    margin: 0;
}
.Contact .promt, .Contact .error{
    margin-top: 0;
}

.purple-section {
    background-color: #c895ea;
    border-top-right-radius: 25px;
    border-bottom-right-radius: 25px;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}

.PersonalInfo, .Contact {
    width: 80%; /* Input fields take up most of the width */
}
.PersonalInfo label{
    margin-right: 280px;
}

.PersonalInfo input, .Contact input {
    width: 100%; /* Full width of input fields */
    margin-bottom: 10px; /* Spacing between rows */
    padding: 10px;
    box-shadow: 0 3px 1px 0;
    border-radius: 5px;
    border: 1px solid #ccc;
}

.Contact input {
    margin-top: 20px;
}

.Contact h5, .PersonalInfo h5 {
    margin: 20px 0; /* Margin for headings */
}

.purple-section .submit {
    width: 100px; /* Button width */
    height: 40px;
    border-radius: 10px;
    box-shadow: 0 2px 1px 0;
}

.purple-section .submit:hover, .submit:focus, .submit:active {
    box-shadow: 0 0 20px rgba(0,0,0, 20);
    transform: scale(1.1); /* Hover effect for button */
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .card {
        flex-direction: column; /* Stack sections vertically on small screens */
        max-width: 100%; /* Ensure card width adapts to screen */
    }

    .white-section, .purple-section {
        width: 100%; /* Full width on smaller screens */
        height: auto; /* Allow height to adapt */
    }

    .PersonalInfo input, .Contact input {
        width: 90%; /* Wider inputs on smaller screens */
    }

    .logo h1 {
        font-size: 2rem; /* Smaller font size on smaller screens */
    }
}

</style>
</html>
