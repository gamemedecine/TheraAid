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
            border-collapse: collapse;
            /* Ensures borders don't double up */
        }

        .table th,
        .table td {
            border: 1px solid black;
            /* Adds borders to table headers and cells */
            padding: 8px;
            /* Adds some padding inside cells */
            text-align: left;
            /* Aligns text to the left (optional) */
        }
    </style>
</head>

<body>
    <a style="font-size:30px;color: red;" href="PatientHomePage.php"><=Back</a>
            <?php
            include("databse.php");
            session_start();

            $var_filter = "P"; // Default filter is Pending

            // Handle form submission for filtering
            if (isset($_POST["BtnFilter"])) {
                $var_filter = $_POST["response"];
            }

            // SQL query based on the selected filter
            $var_slct = "SELECT 
                        S.day,
                        S.start_time,
                        S.end_time,
                        S.note,
                        A.num_of_session,
                        A.payment_type,
                        A.start_date,
                        A.date_accepted,
                        A.therapists_id,
                        A.patient_id,
                        A.rate,
                        A.status,
                        A.Date_creadted
                    FROM tbl_appointment A
                    JOIN tbl_sched S 
                    ON S.shed_id = A.schedle_id 
                    WHERE A.patient_id = " . $_SESSION["sess_PtntID"] . " AND A.status LIKE '" . $var_filter . "%'";

            $var_qry = mysqli_query($var_conn, $var_slct);
            // $var_sclt = "SELECT * FROM tbl_appointment 
            //     WHERE patient_id  = " . . " 
            //     AND status LIKE '" . $var_filter . "%'";

            // $var_qry = mysqli_query($var_conn, $var_sclt);
            ?>

            <form method="POST" action="PATAppointmentList.php">
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
                    <th>Day</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Number Of Session</th>
                    <th>Payment Type</th>
                    <th>Start Date</th>
                    <th>Status</th>
                    <th>Date Created</th>
                    <th>Rate</th>
                    <th>Therapists</th>
                    <?php if ($var_filter == "P") : ?>
                        <th>Action</th>
                    <?php endif; ?>

                </tr>

                <?php if ($var_qry && mysqli_num_rows($var_qry) > 0): ?>
                    <?php while ($var_rec = mysqli_fetch_array($var_qry)) : ?>
                        <tr>
                            <td><?php echo $var_rec["day"]; ?></td>
                            <td><?php echo $var_rec["start_time"]; ?></td>
                            <td><?php echo $var_rec["end_time"]; ?></td>
                            <td><?php echo $var_rec["num_of_session"]; ?></td>
                            <td><?php echo $var_rec["payment_type"]; ?></td>
                            <td><?php echo $var_rec["start_date"]; ?></td>
                            <td><?php echo $var_rec["status"]; ?></td>
                            <td><?php echo $var_rec["Date_creadted"]; ?></td>
                            <td><?php echo $var_rec["rate"]; ?></td>
                            <td><?php echo "<button value='".$var_rec["rate"]."' name='BTNProfile'>Check Profile</button>"; ?></td>


                            <?php if ($var_filter == "P") { ?>
                                <td>
                                    <form method="POST" action="PATAppointmentList.php">
                                        <button type="submit" name="BtnCancel" value="<?php echo $var_rec['patient_id']; ?>">Cancel Request</button>
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