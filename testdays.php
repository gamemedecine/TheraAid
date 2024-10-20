<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MWF Date Generator</title>
</head>
<body>
    <h1>MWF Date Generator</h1>
    <form method="post">
        <label for="start_date">Select Start Date:</label>
        <select id="start_date" name="start_date" required>
            <?php
            // Generate MWF dates for the current month
            $currentMonth = date('m'); // Current month
            $currentYear = date('Y'); // Current year

            // Loop through the days of the month
            for ($day = 1; $day <= 31; $day++) {
                $dateString = sprintf('%04d-%02d-%02d', $currentYear, $currentMonth, $day);
                $date = DateTime::createFromFormat('Y-m-d', $dateString);
                
                // Check if the date is valid and is MWF
                if ($date && $date->format('m') == $currentMonth) {
                    $dayOfWeek = $date->format('N'); // Get the day of the week (1 = Monday, ..., 7 = Sunday)
                    if ($dayOfWeek == 1 || $dayOfWeek == 3 || $dayOfWeek == 5) { // Check for M, W, F
                        echo "<option value='" . $date->format('Y-m-d') . "'>" . $date->format('Y-m-d') . "</option>";
                    }
                }
            }
            ?>
        </select>
        <br><br>
        <input type="submit" value="Generate MWF Dates">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        function generateMWFDates($startDate, $totalSessions) {
            // Create an array to hold the MWF dates
            $mwfDates = [];
            
            // Convert the start date to a DateTime object
            $date = new DateTime($startDate);
            $sessionsGenerated = 0;

            // Loop until the desired number of sessions is generated
            while ($sessionsGenerated < $totalSessions) {
                // Check if the day is Monday, Wednesday, or Friday
                if ($date->format('N') == 1 || $date->format('N') == 3 || $date->format('N') == 5) {
                    $mwfDates[] = $date->format('Y-m-d');
                    $sessionsGenerated++;
                }
                // Move to the next day
                $date->modify('+1 day');
            }
            
            return $mwfDates;
        }

        // Get the user input
        $startDate = $_POST['start_date'];
        $totalSessions = 7; // Fixed number of sessions

        // Generate MWF dates
        $mwfDates = generateMWFDates($startDate, $totalSessions);

        // Display the generated MWF dates
        echo "<h2>Generated MWF Dates:</h2>";
        echo "<ul>";
        foreach ($mwfDates as $date) {
            echo "<li>" . htmlspecialchars($date) . "</li>";
        }
        echo "</ul>";
    }
    ?>
</body>
</html>
