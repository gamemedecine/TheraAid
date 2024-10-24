<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php

include("databse.php"); // Include the database connection
$var_remind = "
  SELECT TB.reminder_date, 
    TB.reminder_messsage,
    TB.reminder_status,
    AP.num_of_session,
    SC.day
  FROM tbl_reminder TB 
  JOIN tbl_appointment AP ON AP.appointment_id = TB.appointment_id 
  JOIN tbl_patient P ON P.patient_id = AP.patient_id 
  JOIN tbl_user U ON U.User_id = P.user_id 
  JOIN tbl_sched SC ON SC.shed_id = AP.schedle_id 
  WHERE P.user_id = 40"; // Adjust the user_id as needed
$var_Rqry = mysqli_query($var_conn, $var_remind);

// Fetch the result into an associative array
$var_Rrec = mysqli_fetch_array($var_Rqry);

//CHEKING IF THE POSPOTPONED REMINDER/SESSION IS ADVANCE OR THE CURRENT DATE
if (isset($_POST["TxtSubmit"])) {

    $givenDate = '2024-10-23'; //"this just an example this will be chnage to current date"example of current date for before and on the date of the session or reminder 
    echo "Example of Postponed Date " . $givenDate . "<br>";
    $var_cnvrtDate = strtotime($givenDate);

    // Get the current date AND COMPARE THE DATE ON THE DATABASE 
    $var_DateDB = explode(",", $var_Rrec["reminder_date"]);
    print_r($var_DateDB);
    $var_same = in_array($givenDate, $var_DateDB);
    echo  "<br>" . $var_same . "<br>";
    if (!in_array($givenDate, $var_DateDB)) {
        /*STEP 2 GET THE PAST DATE AND STOME IT AND CANGE THE UPCOMMING DATE DATE
         INTO THE NEXT SESSION THISI IS A ADVANCE POSTPONED CODE */
        echo "The given date is before the current date.";

        //GETTING THE PAST DATES
        $var_count  = count($var_DateDB);
        $found = []; // Initialize an empty array to hold the found values


        $var_postponeddate;
        $var_ResumeDate = "";
        foreach ($var_DateDB as $value) {
            if ($givenDate > $value) {
                $found[] = $value; // Append smaller values to the $found array

            } elseif ($givenDate == $value) {
                $var_postponeddate = $value;
                foreach ($var_DateDB as $var_date) {
                    if ($var_postponeddate < $var_date) {
                        $var_ResumeDate = $var_date;
                        break;
                    }
                }
                break; // Stop looping once we find a value greater than $givenDate
            }
        }
        //RESULTS
        echo "<br>Postponed Date    " . $var_postponeddate . "<br>";
        echo "Resume Date" . $var_ResumeDate;
        $var_days_array = explode(",", $var_Rrec["day"]); // Days from the record, e.g. ["Mon", "Wed"]
        print_r($var_days_array);
        echo "<br>";

        print_r($found); // Print the array of found values
        echo $var_count; // Assuming $var_count is defined somewhere earlier in your code
        $var_successDate = count($found);
        print "<br>" . $var_successDate;
        echo "<br>";

        $var_remainingDate = $var_count - $var_successDate;
        echo "Remaining session: " . $var_remainingDate;

        // Map days to numeric values for the DateTime::format('N') function
        $daysMap = [
            'Mon' => 1, // Monday
            'Tue' => 2, // Tuesday
            'Wed' => 3, // Wednesday
            'Thu' => 4, // Thursday
            'Fri' => 5, // Friday
            'Sat' => 6, // Saturday
        ];
        // Convert postponed or resume date to DateTime object
        $currentDate = new DateTime($var_ResumeDate); // Assume this is the resume date or postponed date

        // Create an array to store the generated dates
        $generated_dates = [];

        // Get the numeric representation of days based on $daysMap
        $daysOfWeek = [];
        foreach ($var_days_array as $day) {
            if (isset($daysMap[$day])) {
                $daysOfWeek[] = $daysMap[$day];  // Convert 'Mon', 'Wed', etc. to numeric values
            }
        }


        // Loop until you generate the required number of remaining sessions
        while (count($generated_dates) < $var_remainingDate) {
            // Get the current day of the week as a numeric value (1 = Mon, 7 = Sun)
            $dayOfWeek = $currentDate->format('N');

            // Check if the current day matches one of the days in the array
            if (in_array($dayOfWeek, $daysOfWeek)) {
                // If it's a match, add the date to the array
                $generated_dates[] = $currentDate->format('Y-m-d');
            }

            // Move to the next day
            $currentDate->modify('+1 day');
        }
    } else {
        echo "The given date is the same as the current date.";
        
        //GETTING THE PAST DATES
        $var_count  = count($var_DateDB);
        $found = []; // Initialize an empty array to hold the found values


        $var_postponeddate;
        $var_ResumeDate = "";
        foreach ($var_DateDB as $value) {
            if ($givenDate > $value) {
                $found[] = $value; // Append smaller values to the $found array

            } elseif ($givenDate == $value) {
                $var_postponeddate = $value;
                foreach ($var_DateDB as $var_date) {
                    if ($var_postponeddate < $var_date) {
                        $var_ResumeDate = $var_date;
                        break;
                    }
                }
                break; // Stop looping once we find a value greater than $givenDate
            }
        }
        //RESULTS
        echo "<br>Postponed Date    " . $var_postponeddate . "<br>";
        echo "Resume Date" . $var_ResumeDate;
        $var_days_array = explode(",", $var_Rrec["day"]); // Days from the record, e.g. ["Mon", "Wed"]
        print_r($var_days_array);
        echo "<br>";

        print_r($found); // Print the array of found values
        echo $var_count; // Assuming $var_count is defined somewhere earlier in your code
        $var_successDate = count($found);
        print "<br>" . $var_successDate;
        echo "<br>";

        $var_remainingDate = $var_count - $var_successDate;
        echo "Remaining session: " . $var_remainingDate;

        // Map days to numeric values for the DateTime::format('N') function
        $daysMap = [
            'Mon' => 1, // Monday
            'Tue' => 2, // Tuesday
            'Wed' => 3, // Wednesday
            'Thu' => 4, // Thursday
            'Fri' => 5, // Friday
            'Sat' => 6, // Saturday
        ];
        // Convert postponed or resume date to DateTime object
        $currentDate = new DateTime($var_ResumeDate); // Assume this is the resume date or postponed date

        // Create an array to store the generated dates
        $generated_dates = [];

        // Get the numeric representation of days based on $daysMap
        $daysOfWeek = [];
        foreach ($var_days_array as $day) {
            if (isset($daysMap[$day])) {
                $daysOfWeek[] = $daysMap[$day];  // Convert 'Mon', 'Wed', etc. to numeric values
            }
        }


        // Loop until you generate the required number of remaining sessions
        while (count($generated_dates) < $var_remainingDate) {
            // Get the current day of the week as a numeric value (1 = Mon, 7 = Sun)
            $dayOfWeek = $currentDate->format('N');

            // Check if the current day matches one of the days in the array
            if (in_array($dayOfWeek, $daysOfWeek)) {
                // If it's a match, add the date to the array
                $generated_dates[] = $currentDate->format('Y-m-d');
            }

            // Move to the next day
            $currentDate->modify('+1 day');
    }
        echo "Generated Dates: <br>";
        print_r($generated_dates);
}
    // // Format both dates to 'Y-m-d' to compare only the date part
    // $givenDateFormatted = $givenDateTime->format('Y-m-d');
    // $currentDateFormatted = $currentDateTime->format('Y-m-d');

    // echo "Current date: " . $currentDateFormatted . "<br>";


    // // Check if the given date is before, on, or after the current date
    // if ($givenDateFormatted < $currentDateFormatted) {
    //     echo "The given date is before the current date.";
    // } elseif ($givenDateFormatted == $currentDateFormatted) {
    //     echo "The given date is the same as the current date.";
    // } else {
    //     echo "The given date is after the current date.";
    // }
}







?>

<body>
    <form method="POST" action="updateSched.php">
        <input type="submit" name="TxtSubmit" value="Postpone and move schedule">
    </form>

</body>

</html>


<?php


/*
 //SQL query to get reminder dates and relevant session details for a specific user

// Execute the query
$var_Rqry = mysqli_query($var_conn, $var_remind);

// Fetch the result into an associative array
$var_Rrec = mysqli_fetch_array($var_Rqry);

// Explode the reminder_date string into an array of dates
$var_chkDate = explode(",", $var_Rrec["reminder_date"]); // E.g., "2024-10-09,2024-10-11,2024-10-14,2024-10-16,2024-10-18"

// Current date (replace this with date("Y-m-d") to use the actual current date)
$var_testCurrentDate = "2024-10-11"; // Example current date, replace with `date("Y-m-d")` in live code

// Create a DateTime object for the current date
$currentDate = new DateTime($var_testCurrentDate);

// Initialize counters for future and past sessions
$sessionsLeft = 0;
$completedSessions = 0;

// Initialize an array to hold postponed dates (for future use)
$postponedMeetings = [];

// Loop through each reminder date
foreach ($var_chkDate as $sessionDate) {
    // Convert each session date to a DateTime object
    $meetingDate = new DateTime($sessionDate);

    // Check if the session date is in the future (greater than the current date)
    if ($meetingDate > $currentDate) {
        $sessionsLeft++; // Increment the counter for future sessions
    } else {
        $completedSessions++; // Increment the counter for completed sessions
    }
}

// Number of total sessions
$totalSessions = count($var_chkDate);

// Handle postponed meeting (let's assume the third meeting was postponed)
$postponedMeetingIndex = 2; // This is an example, adjust based on the logic for detecting postponements
if ($completedSessions < $totalSessions && isset($var_chkDate[$postponedMeetingIndex])) {
    // Get the next available date after postponement
    $postponedDate = $var_chkDate[$postponedMeetingIndex];

    // Find the next available date to postpone the meeting
    for ($i = $postponedMeetingIndex + 1; $i < $totalSessions; $i++) {
        if (new DateTime($var_chkDate[$i]) > $currentDate) {
            // Move the postponed meeting to the next available date
            $postponedMeetings[] = $var_chkDate[$i]; // Store it for future handling
            $var_chkDate[$i] = $postponedDate; // Shift the postponed date
            break;
        }
    }
}

// Output the results
echo "Number of completed sessions: " . $completedSessions . "<br>";
echo "Number of sessions left: " . $sessionsLeft . "<br>";
echo "Postponed meetings moved to new dates: " . implode(",", $postponedMeetings);




// // Loop through each reminder date to calculate the difference
// foreach ($var_chkDate as $reminderDate) {
//     // Convert the dates into DateTime objects
//     $date1 = new DateTime($var_testCurrentDate); // Current date
//     $date2 = new DateTime($reminderDate); // Reminder date

//     // Calculate the difference between the dates
//     $interval = $date1->diff($date2);

//     // Output the number of days remaining
//     echo "Days until $reminderDate: " . $interval->days . " days left<br>";
// }

  
//  echo $var_Rrec["reminder_messsage"];
//  echo $var_Rrec["reminder_status"];

 */
?>