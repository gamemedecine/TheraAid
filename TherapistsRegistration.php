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
        margin-top: 2px;
        margin-left:  25%;
        width: 200px;
        margin-bottom: 11px;
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
    .basicInfo input{
        margin-left: 145px;
        margin-bottom: 10px;
        margin-top: 5px;
        width: 100px;
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
    $var_Case="";
    $var_City="";
    $var_CityRadius="";
    $var_Street="";
    $fileDestination ="";
    $var_km = false;
    $var_img="";
    $var_folder="";
    $var_ProfPic="";
    if(mysqli_num_rows($var_chk)>0){
        $var_get=mysqli_fetch_array($var_chk);

        $var_Fname=$var_get["Fname"];
        $var_Lname=$var_get["Lname"];
        $var_Mname=$var_get["Mname"];
        $var_Date=$var_get["Bday"];
        $var_CntctNum=$var_get["ContactNum"];
        $var_Email=$var_get["Email"];
        $var_ProfPic=$var_get["profilePic"];
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
        $var_City=trim($_POST["TxtCity"]);
        $var_CityRadius=trim($_POST["TxtRadius"]);
        $var_Errors="";
        if(ValTxt($var_Case) || ValTxt($var_City))
        {
            $var_Errors="Errors";
        }
        if(!is_numeric($var_CityRadius)){
            $var_km = true;
        }
        
       
        /////////UPLOAD PHOTOS
        
        $var_img = $_FILES['Medpic'];
        $var_fileName = $_FILES['Medpic']['name'];
        $var_fileTmpName = $_FILES['Medpic']['tmp_name'];
        $var_fileSize = $_FILES['Medpic']['size'];
        $var_fileError = $_FILES['Medpic']['error'];
        $var_filetype = $_FILES['Medpic']['type'];
        $fileExt = explode('.', $var_fileName);
        $fileActualExt = strtolower(end($fileExt));
        

        $allowed = array('jpg', 'jpeg', 'png', 'pdf');
        
        if(in_array($fileActualExt,$allowed))
        {
            if($var_fileError === 0 ){
                if($var_fileSize < 1000000 ){
                    $fileNewName = uniqid('',true).".".$fileActualExt;
                    
                    
                    $fileDestination = 'MedicalLicense/'.$fileNewName;
                    

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
        else{
            $var_sql = "INSERT INTO tbl_therapists(user_id, case_handled, city, Radius, license_img) 
            VALUES ('$var_Uid', '$var_Case', '$var_City', ' $var_CityRadius', '$fileNewName')";
            $var_qry = mysqli_query ($var_conn,$var_sql);
            if($var_qry){
                echo "Saved";
                header("location: TherapistsHomePage.php");
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
    <form action="TherapistsRegistration.php" method="POST" enctype="multipart/form-data">
    <div class="container">
        <div class="basicInfo">
            <img class="rounded-circle" src="ProfilePic/<?php echo $var_ProfPic?>" alt="Profile Pic" ><br>
            <p><?php echo $var_Fname." ".$var_MI.". ".$var_Lname;?></p>
            <p><?php echo $var_Age;?></p>
            <p><?php echo $var_CntctNum;?></p>
            <p><?php echo $var_Email;?></p>
            <button>Edit</button>
        </div> 
            <div class="AddInfo">
                <div class="Case row">
                    <div class="col-md-5">
                        <input type="text" <?php if(is_numeric($var_Case)) echo 'style="border-color:red;border-style: solid; border-width: 2px;"'; ?> value="<?php echo isset($var_Case) ? $var_Case : ''; ?>" name="TxtCase" placeholder="Case" class="form-control" ><br>
                        <input type="text" <?php if(is_numeric($var_City)) echo 'style="border-color:red;border-style: solid; border-width: 2px;"'; ?> value="<?php echo isset($var_City) ? $var_Case : ''; ?>" name="TxtCity" placeholder="City" class="form-control" ><br>
                        <input type="text" <?php if($var_km) echo 'style="border-color:red;border-style: solid; border-width: 2px;" '; ?> value="<?php echo isset($var_CityRadius) ? $var_CityRadius : ''; ?>" name="TxtRadius" placeholder="Radius (km)" class="form-control">
                        
                    </div>
                   
                </div>
                 
                <div class="mt-3">
                    <label>License</label><br>
                    <input type="file" value="<?php echo $var_img;?>" name="Medpic" class="form-control" placeholder="Profile Pic">
               </div>
                <div class="mt-3 text-center">
                    <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                </div>
            </div>
        </form>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
