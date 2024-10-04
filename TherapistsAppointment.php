<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Therapists List Of Appointment</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        .table {
            border: 1px solid black;
            border-collapse: collapse; /* Ensures borders don't double up */
        }
        .table th, .table td {
            border: 1px solid black; /* Adds borders to table headers and cells */
            padding: 8px; /* Adds some padding inside cells */
            text-align: left; /* Aligns text to the left (optional) */
        }
    </style>
</head>
<body>
    <a style="font-size:30px;color: red;" href="TherapistsHomePage.php"><=Back</a>
    <?php
    include("databse.php");
    session_start();

    if(isset($_POST["PatientProf"])){
        $_SESSION["sess_PID"]=$_POST["PatientProf"];
        $_SESSION["sess_ApntmntId"]=$_POST["appointment_id"];
        header("location: PTPatientview.php");
    }
    $var_filter = "P"; // Default filter is Pending

    // Handle form submission for filtering
    if (isset($_POST["BtnFilter"])) {
        $var_filter = $_POST["response"];
    }

    // SQL query based on the selected filter
    $var_sclt = "SELECT * FROM tbl_appointment 
        WHERE therapists_id = " . $_SESSION["sess_PTID"] . " 
        AND status LIKE '" . $var_filter . "%'";

    $var_qry = mysqli_query($var_conn, $var_sclt);
    ?>

    <form method="POST" action="TherapistsAppointment.php">
        <label>
            <input type="radio" name="response" value="P" <?php if ($var_filter == "P") echo "checked"; ?>> Pending
        </label>
        <label>
            <input type="radio" name="response" value="R" <?php if ($var_filter == "R") echo "checked"; ?>> Responded
        </label>
        <label>
            <input type="radio" name="response" value="O" <?php if ($var_filter == "O") echo "checked"; ?>> Ongoing
        </label>
        <input type="submit" name="BtnFilter" value="Filter">
    </form>

    <table class="table">
        <tr>
            <th>Number Of Session</th>
            <th>Payment Type</th>
            <th>Start Date</th>
            <th>Status</th>
            <th>Date Created</th>
            <th>Rate</th>
            <?php if ($var_filter == "P") : ?>
                <th>Patient Profile</th>
            <?php endif; ?>
            <?php if ($var_filter == "R") : ?>
                <th>Action</th>
            <?php endif; ?>
        </tr>
        
        <?php if ($var_qry && mysqli_num_rows($var_qry) > 0): ?>
            <?php while ($var_rec = mysqli_fetch_array($var_qry)) : ?>
                <tr>
                    <td><?php echo $var_rec["num_of_session"]; ?></td>
                    <td><?php echo $var_rec["payment_type"]; ?></td>
                    <td><?php echo $var_rec["start_date"]; ?></td>
                    <td><?php echo $var_rec["status"]; ?></td>
                    <td><?php echo $var_rec["Date_creadted"]; ?></td>
                    <td><?php echo $var_rec["rate"]; ?></td>
                    <?php if ($var_filter == "R"){ ?>
                        <td>
                            <form method="POST" action="TherapistsAppointment.php">
                                <button type="submit" name="Cancel Respond" value="<?php echo $_SESSION["sess_PTID"]; ?>">Cancel Respond</button>
                            </form>
                        </td>
                    <?php } ?>
                    
                    <?php if ($var_filter == "P"){ ?>
                        <td>
                            <form method="POST" action="TherapistsAppointment.php">
                                <input type="hidden" name="appointment_id" value="<?php echo $var_rec['appointment_id']; ?>">
                                <button type="submit" name="PatientProf" value="<?php echo $var_rec['patient_id']; ?>">Visit Profile</button>
                            </form>
                        </td>
                    <?php } ?>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="<?php echo ($var_filter == "P" ? 7 : 6); ?>">No records found.</td>
            </tr>
        <?php endif; ?>
    </table>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
