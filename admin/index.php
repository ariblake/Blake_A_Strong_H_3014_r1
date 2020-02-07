<?php
    require_once '../load.php';

    // set the timezone to the one we're in
    date_default_timezone_set("America/Toronto");

    // find the current hour in 24-hour format
    $currentHour = date("H");

    // if the hour is before 12pm, say "Good Morning!"
    if($currentHour < 12) {
        $message = "Good Morning!";
    // if the hour is before 6pm, say "Good Afternoon!"
    }elseif($currentHour < 18) {
        $message = "Good Afternoon!";
    // if the hour is before or equal to 12am, say "Good Evening!"
    }elseif($currentHour <= 24) {
        $message = "Good Evening!";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
</head>
<body>
    <!-- Welcome message based on the current time -->
    <h1><?php echo !empty($message)? $message: ''; ?></h1>

    <h3> Your last successful login was: <?php echo "";?></h3>
</body>
</html>