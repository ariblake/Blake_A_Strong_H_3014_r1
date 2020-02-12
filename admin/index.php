<?php
    require_once '../load.php';

    $time = time();

    // Set the timezone to the one we're in
    date_default_timezone_set('America/Toronto');

    // Find the current hour in 24-hour format
    $currentHour = date("H");

    // If the hour is before 12pm, say "Good Morning!"
    if($currentHour < 12) {
        echo "Good Morning! Have a fantastic day. <br><br>";
    // If the hour is before 6pm, say "Good Afternoon!"
    }elseif($currentHour < 18) {
        echo "Good Afternoon! Is it lunch time yet? <br><br>";
    // If the hour is before or equal to 12am, say "Good Evening!"
    }elseif($currentHour <= 24) {
        echo"Good Evening! Time to rest up! <br><br>";
    }

    // Last successful login
    setcookie('lastLogin', date("G:i - m/d/y"));

    // Use a cookie to store the user data of date and time in the last login field
    if(isset($_COOKIE['lastLogin'])){

        // If the cookie is traced, show the date and time
        $showdatetime = $_COOKIE['lastLogin'];
        echo "Your last successful login was: ".$showdatetime;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/main.css">
    <title>Dashboard</title>
</head>
<body>
    <h2>Hello, welcome!</h2>

</body>
</html>