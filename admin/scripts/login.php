<?php

// Set the number of logins to 0
$_SESSION['login-attempts'] = 0;

// For this case, 0 means the user is not locked out of their account and 1 means they have had too many attempts and are locked out of their account
$_SESSION['attempted-login'] = 0;


function login($username, $password, $ip){

    // Add login attempts, 1 means locked out of account
    $_SESSION['login-attempts'] += 1;

    // Establish the database connection
    $pdo = Database::getInstance()->getConnection();
    
    //Check existence
    $check_exist_query = 'SELECT COUNT(*) FROM tbl_user WHERE user_name= :username'; //:username is a placeholder for preventing SQL injection
    $user_set = $pdo->prepare($check_exist_query);
    $user_set->execute(
        array(
            ':username' => $username,
        )
    );

    // Now check to see if the user has attempted and is locked out
    // If the user has attempted too many times ('is 1'), then execute this statement to tell user

    if ($_SESSION['attempted-login'] == 1) {

        $message = "Sorry. You have attempted to log in 3 times. This is the maximum. Please wait and try again.";

            // Fetch the current time (EST) and specifically look at the seconds
            $seconds = substr(date("y-m-d H:i:s"), -2);

            // If the user tried after the required wait time, unlock the users account -> then give them 3 more attempts
            if ($seconds >= 30){

                $_SESSION['login-attempts'] = 0;
                $_SESSION['attempted-login'] = 0;

            }

            // If the user is not locked out yet, check to see how many attempts they have made
            // If the user tried 3 times to log in and was unsuccessful, lock the user out and starts the attempt count again

    }elseif($_SESSION['login-attempts'] > 2){

        // Lock the user out since they attempted too many times
        $_SESSION['attempted-login'] = 1;
        $_SESSION['login-attempts'] = 0;

        $message = "The maximum login attempts have been reached. Please wait 30 seconds before trying again.";
    
    }else{

        // Check to see if the username and password fields are valid --> if they match the database

            if($user_set->fetchColumn()>0){
                // Check in my user table if there is a row that matches username and password
                $get_user_query = 'SELECT * FROM tbl_user WHERE user_name = :username';
                $get_user_query .= ' AND user_pass = :password';
                $user_check = $pdo->prepare($get_user_query);
                $user_check->execute(
                    array(
                        ':username'=>$username,
                        ':password'=>$password
                    )
                );
                
                // If the username and password are right, log in
                while($found_user = $user_check->fetch(PDO::FETCH_ASSOC)){
                    $id = $found_user['user_id'];
                    // Logged in!
                    $message = "You just logged in!";

                    // Update user ip
                    $update_query = 'UPDATE tbl_user SET user_ip = :ip WHERE user_id = :id'; 
                    $update_set = $pdo->prepare($update_query);
                    $update_set->execute(
                        array(
                            ':ip'=>$ip,
                            ':id'=>$id
                        )
                    );
                }

                if(isset($id)){

                    // Record the last successful user login to the database
                    $tm = date("Y-m-d H:i:s");
                    $update_query = 'UPDATE tbl_user SET last_login = :tm WHERE user_id = :id';
                    $update_set = $pdo->prepare($update_query);
                    $update_set->execute(
                        array(
                            ':id'=>$id,
                            ':tm'=> $tm
                        )
                    );

            // Once the user is logged in, reset all timestamps
            $_SESSION['login-attempts'] = 0;
            $_SESSION['attempted-login'] = 0;
            redirect_to('admin/index.php');      
          }
            
        }else{
        
        // User does not exist
        $message = 'User does not exist.';
        }
    }

    // Log user in

    return $message;

    }

?>