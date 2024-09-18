<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Step 2</title>
</head>
<?php
    $var_conn =mysqli_connect("localhost","root","","theraaid");
    $var_Errors="";
  
?>
<style>
    *{
        margin: 0;
        padding: 0;
    }
    body{
        background-color: #6666FF;
    }
    .container{
        display: flex;
        gap: 20px;
        padding: 0;
        margin-left: 80px;
        margin-right: 0;
        margin-top: 20px;
    }
    .basicInfo{
        margin-left: 5px;
        margin-top: 5px;
        background-color: white;
        height: 420px;
        width: 500px;
        border-radius: 10px;
        padding: 0;
    }
    .basicInfo img{
        margin-top: 10px;
        margin-left:  8%;
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
        margin-top: 4px;
        margin-right: 0;
        width: 900px;
        height: 420px;
        border-radius: 10px;
        background-color: white;
        padding: 20px;
    }
    .Case input{
        border-style: solid;
        border-color: black;
        border-radius: 10px;
        padding: 5px;
        margin-bottom: 10px;
    }
    .Description{
        width: 100%;
        height: 120px;
    }
</style>
<?php 
    session_start();
    $_SESSION["sess_Utype"];
    $var_Uid = ($_SESSION["sess_id"]);
    $var_profid =intval($_SESSION["sess_id"]);
    $var_conn =mysqli_connect("localhost", "root", "", "theraaid");
    $var_rec = "SELECT * FROM tbl_user WHERE User_id = $var_profid";
    $var_chk = mysqli_query($var_conn,$var_rec);
    $var_Fname="";
    $var_Lname="";
    $var_Mname="";
    $var_MI="";
    $var_Age="";
    $var_CntctNum="";
    $var_Email="";
    $var_img="";
    $var_medrec="";
    $var_folder="";
    $var_Case="";
    $var_CaseDesc="";
    $var_City="";
    $var_Street="";
    $fileDestination ="";
    $assessmentActualExt="";
    if(mysqli_num_rows($var_chk)>0){
        $var_get=mysqli_fetch_array($var_chk);

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
    }
    else{
        echo "No records found";
    }
    function ValTxt($var_Text){
        if(is_numeric($var_Text)){
            return true;
        }
       }
      
      
    //-------------INPUT----------------//
    if(isset($_POST['submit'])){
        $var_Case=trim($_POST["TxtCase"]);
        $var_CaseDesc=trim($_POST["TxtCaseDscrpt"]);
        $var_City=trim($_POST["TxtCity"]);
        $var_Street=trim($_POST["TxtStreet"]);
        $var_Errors="";
        if(ValTxt($var_Case) || ValTxt($var_CaseDesc) || ValTxt($var_City) || ValTxt($var_Street))
        {
            $var_Errors="Errors";
        }
        
       
        /////////UPLOAD PHOTOS
        
        $var_img = $_FILES['Medpic'];
        $var_fileName = $_FILES['Medpic']['name'];
        $var_fileTmpName = $_FILES['Medpic']['tmp_name'];
        $var_fileSize = $_FILES['Medpic']['size'];
        $var_fileError = $_FILES['Medpic']['error'];
        $var_filetype = $_FILES['Medpic']['type'];
        $var_assessment = $_FILES['MedAssessment'];
        $var_assessmentName = $_FILES['MedAssessment']['name'];
        $var_assessmentTmpName = $_FILES['MedAssessment']['tmp_name'];
        $var_assessmentSize = $_FILES['MedAssessment']['size'];
        $var_assessmentError = $_FILES['MedAssessment']['error'];
        $var_assessmentType = $_FILES['MedAssessment']['type'];
       
        $fileExt = explode('.', $var_fileName);
        $fileActualExt = strtolower(end($fileExt));

        $assessmentExt = explode('.', $var_assessmentName);
        $assessmentActualExt = strtolower(end($assessmentExt));
        $allowed = array('jpg', 'jpeg', 'png', 'pdf');
        
        if(in_array($fileActualExt,$allowed) && in_array($assessmentActualExt, $allowed))
        {
            if($var_fileError === 0 && $var_assessmentError === 0){
                if($var_fileSize < 1000000 && $var_assessmentSize < 1000000){
                    $fileNewName = uniqid('',true).".".$fileActualExt;
                    $assessmentNewName = uniqid('',true).".".$assessmentActualExt;
                    
                    $fileDestination = 'medrec/'.$fileNewName;
                    $assessmentDestination = 'medrec/'.$assessmentNewName;

                    move_uploaded_file($var_fileTmpName, $fileDestination);
                    move_uploaded_file($var_assessmentTmpName, $assessmentDestination);
                    
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
        else{
            $var_sql = "INSERT INTO tbl_patient (user_id, P_case, case_desc, city, Street,mid_hisotry_photo, assement_photo) 
            VALUES ('$var_Uid', '$var_Case', '$var_CaseDesc', '$var_City', '$var_Street', '$fileNewName', '$assessmentNewName')";
            $var_qry = mysqli_query ($var_conn,$var_sql);
            if($var_qry){
                echo "Saved";
                header("location: PatientHomePage.php");
            }
            else{
                echo "Error";
            }
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
    </nav>
    <div class="container">
        <div class="basicInfo">
            <img class="rounded-circle" src="photos/profile.jpg" alt="Profile Pic"><br><br>
            <p><?php echo $var_Fname." ".$var_MI.". ".$var_Lname;?></p>
            <p><?php echo $var_Age;?></p>
            <p><?php echo $var_CntctNum;?></p>
            <p><?php echo $var_Email;?></p>
            <button>Edit</button>
        </div> 
        <form action="PatientRegistrationPrt2.php" method="POST" enctype="multipart/form-data">
            <div class="AddInfo">
                <div class="Case row">
                    <div class="col-md-6">
                        <input type="text" <?php if(is_numeric($var_Case)) echo 'style="border-color:red;border-style: solid; border-width: 2px;"'; ?> value="<?php echo isset($var_Case) ? $var_Case : ''; ?>" name="TxtCase" placeholder="Case" class="form-control" ><br>
                        <textarea  <?php if(ValTxt($var_CaseDesc)) echo 'style="border-color:red;border-style: solid; border-width: 2px;"'; ?> class="form-control Description" name="TxtCaseDscrpt" placeholder="Description"><?php echo isset($var_CaseDesc) ? $var_CaseDesc : ''; ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label>Address:</label><br>
                        <input type="text" <?php if(ValTxt($var_City)) echo 'style="border-color:red;border-style: solid; border-width: 2px;"'; ?> value="<?php echo isset($var_City) ? $var_City : ''; ?>" name="TxtCity"  placeholder="City" class="form-control mb-2">
                        <input type="text" <?php if(ValTxt($var_Street)) echo 'style="border-color:red;border-style: solid; border-width: 2px;"'; ?> value="<?php echo isset($var_Street) ? $var_Street : ''; ?>" name="TxtStreet" placeholder="Barangay/Street" class="form-control">
                    </div>
                </div>
                 
                <div class="mt-3">
                    <label>Medical History</label><br>
                    <input type="file" value="<?php echo $var_img;?>" name="Medpic" class="form-control">
               </div>
                <div class="mt-3">
                    <label>Medical Assessment</label><br>
                    <input type="file" value="<?php echo $var_assessment;?>" name="MedAssessment" class="form-control">
                </div> 
                <div class="mt-3 text-center">
                    <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                </div>
            </div>
        </form>

    </div>
    <script src="js/bootstrap.bundle.min.js" ></script>
</body>
</html>
