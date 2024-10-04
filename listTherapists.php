<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
<?php
include("databse.php"); // Ensure the filename is correct

// Check if connection was successful
if (!$var_conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Prepare the SQL statement to prevent SQL injection
$appointment_id = 24; // This should come from a secure source, e.g., user input
$var_scltt = "SELECT 
    A.*,
    UT.Fname AS therapist_fname,
    UP.Fname AS patient_fname
FROM tbl_appointment A
JOIN tbl_therapists T ON A.therapists_id = T.therapist_id 
JOIN tbl_user UT ON T.user_id = UT.User_id  
JOIN tbl_user UP ON A.patient_id = UP.User_id  
WHERE A.appointment_id = ?;";

$stmt = mysqli_prepare($var_conn, $var_scltt);
mysqli_stmt_bind_param($stmt, "i", $appointment_id); // Bind the parameter
mysqli_stmt_execute($stmt);
$var_qry = mysqli_stmt_get_result($stmt);

// Check if any rows were returned
if (mysqli_num_rows($var_qry) > 0) {
    echo "Success\n";
    while ($row = mysqli_fetch_assoc($var_qry)) {
        // Process your data here, for example:
        echo "Therapist: " . $row['therapist_fname'] . " - Patient: " . $row['patient_fname'] . "\n";
    }
} else {
    echo "No data";
}

// Close the statement and connection
mysqli_stmt_close($stmt);
mysqli_close($var_conn);




    //      $var_slct = " SELECT * FROM tbl_appointment WHERE appointment_id = 24";
    //      $var_qry = mysqli_query($var_conn, $var_slct);

    //     if (mysqli_num_rows($var_qry)>0) {
    //         echo "Success 1 \n";
    //     } else {
    //         echo "Error";
    //     }

    //     //////////////////////////////////////////
    //     $var_slct2= "SELECT * FROM tbl_sched WHERE shed_id =
    //      (SELECT schedle_id FROM tbl_appointment WHERE appointment_id = 24)";
    //      $var_qry2 = mysqli_query($var_conn, $var_slct2);
    //      if (mysqli_num_rows($var_qry2)>0) {
    //         echo "Success 2\n";
    //     } else {
    //         echo "Error";
    //     }
    // ////////////////////////////////////////
    //     $var_slct3="SELECT * FROM tbl_therapists WHERE therapist_id =
    //     (SELECT therapists_id FROM tbl_appointment WHERE appointment_id = 24);";
    //      $var_qry3 = mysqli_query($var_conn, $var_slct3);
    //      if (mysqli_num_rows($var_qry3)>0) {
    //         echo "Success 3 \n";
    //     } else {
    //         echo "Error";
    //     }
    // /////////////////////////////////////////////
    //     $var_slct4="SELECT * FROM tbl_patient WHERE user_id = 
    //     (SELECT patient_id FROM tbl_appointment WHERE appointment_id = 24);";
    //     $var_qry4 = mysqli_query($var_conn, $var_slct4);
    //     if (mysqli_num_rows($var_qry4)>0) {
    //        echo "Success 4 \n";
    //    } else {
    //        echo "Error";
    //    }
    //SELECT 
    //             S.day,
    //             S.start_time,
    //             S.end_time,
    //             S.note,
    //             A.num_of_session,
    //             A.payment_type,
    //             A.start_date,
    //             A.date_accepted,
    //             A.therapists_id,
    //             A.patient_id,
    //             A.rate,
    //             A.Date_creadted,
    //             -- Therapist Information
    //             UT.Fname AS therapist_fname,
    //             UT.Lname AS therapist_lname,
    //             UT.Mname AS therapist_mname,
    //             UT.profilePic AS therapist_profilePic,
    //             -- Patient Information from tbl_user
    //             UP.Fname AS patient_fname,
    //             UP.Lname AS patient_lname,
    //             UP.Mname AS patient_mname,
    //             UP.Bday AS patient_bday,
    //             UP.ContactNum AS patient_contact,
    //             UP.Email AS patient_email,
    //             UP.profilePic AS patient_profilePic,
    //             -- Patient Case Information from tbl_patient
    //             P.P_case,
    //             P.case_desc,
    //             P.City AS patient_city,
    //             P.street AS patient_street,
    //             P.assement_photo,
    //             P.mid_hisotry_photo,
    //             -- Therapist Case Handled Information
    //             T.case_handled,
    //             T.city AS therapist_city,
    //             T.Radius
    //         FROM tbl_appointment A
    //         JOIN tbl_sched S ON S.shed_id = A.schedle_id 
    //         JOIN tbl_therapists T ON A.therapists_id = T.therapist_id 
    //         JOIN tbl_user UT ON T.user_id = UT.User_id  -- Therapist's User Info
    //         JOIN tbl_user UP ON A.patient_id = UP.User_id  -- Patient's User Info
    //         JOIN tbl_patient P ON A.patient_id = P.user_id  -- Patient's Case Info
    //         WHERE A.appointment_id  = 24";


    ?>

</body>

</html>
<style>
    table {
        border: 1px solid black;
        border-collapse: collapse;
        /* Ensures borders don't double up */
    }

    table th,
    .table td {
        border: 1px solid black;
        /* Adds borders to table headers and cells */
        padding: 8px;
        /* Adds some padding inside cells */
        text-align: left;
        /* Aligns text to the left (optional) */
    }
</style>