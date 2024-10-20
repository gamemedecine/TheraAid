
<?php
include("databse.php");
// Inputs
$var_days = [ 'Wed', 'Fri']; // Example dynamic days
$var_SelectedStartDate = '2024-10-11'; // Example start date
$NumofMeeting = 10; // Example number of meetings
$var_CurrentDate = "2024-10-18"; // Example "Current Date"

// Array to hold the generated dates
$future_dates = [];

// Convert the start date into a DateTime object
$startDate = new DateTime($var_SelectedStartDate);

// While loop until we get the required number of meetings
while (count($future_dates) < $NumofMeeting) {
    // Get the current day of the week (0=Sun, 1=Mon, ..., 6=Sat)
    $currentDay = $startDate->format('D'); // Get the three-letter abbreviation
    
    // Check if the current day is one of the selected days
    if (in_array($currentDay, $var_days)) {
        // Add the current date to the list of future dates
        $future_dates[] = $startDate->format('Y-m-d');
    }
    
    // Move to the next day
    $startDate->modify('+1 day');
}

// Output the future dates for reference
print_r($future_dates);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<script>
<?php 
    // Compare all future dates with the current date
if (in_array($var_CurrentDate, $future_dates)) {
    echo "alert('You have a Meeting Today')";
} else {
    echo "alert('Yout have no meetings for today')";
}

?>

</script>
</body>
</html>
