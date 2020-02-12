<?php
    require_once 'load.php';

    // Start a session once page loads
    session_start();

    $ip = $_SERVER['REMOTE_ADDR']; // REMOTE_ADDR uses the IP address from the user

    if(isset($_POST['submit'])){
        // Trim cuts off extra space typed
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        // If any are empty, instead of logging the user in, send a message
        if(!empty($username) && !empty($password)){
            // Log user in
            $message = login($username, $password, $ip);
        }else{
            $message = 'Please fill out the required fields';
        }
    }

    echo 'Number of login attempts: '.$_SESSION['login-attempts'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/main.css">
    <title>Login Page</title>
</head>
<body>
    <h2>Login Page</h2>
    <?php echo !empty($message)? $message: ''; ?>
    <form action="index.php" method="post">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="">

        <label for="password">Password</label>
        <input type="password" name="password" id="password" value="">

        <button name="submit">Submit</button>
    </form>


</body>
</html>