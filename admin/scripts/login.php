<?php

function login($username, $password, $ip){
    $pdo = Database::getInstance()->getConnection();
    
    //Check existence
    $check_exist_query = 'SELECT COUNT(*) FROM tbl_user WHERE user_name= :username'; //:username is a placeholder for preventing SQL injection
    $user_set = $pdo->prepare($check_exist_query);
    $user_set->execute(
        array(
            ':username' => $username,
        )
    );

    if($user_set->fetchColumn()>0){
        // check in my user table if there is a row that matches username and password
        $get_user_query = 'SELECT * FROM tbl_user WHERE user_name = :username';
        $get_user_query .= ' AND user_pass = :password';
        $user_check = $pdo->prepare($get_user_query);
        $user_check->execute(
            array(
                ':username'=>$username,
                ':password'=>$password
            )
        );
        
        // if the username and password are right, log in
        while($found_user = $user_check->fetch(PDO::FETCH_ASSOC)){
            $id = $found_user['user_id'];
            // Logged in!
            $message = 'You just logged in!';

            // update last_login to be the user_date before we update the user_date to the current login time
            // this will make last_login be the time that the user last logged in
            $update_lastLogin = 'UPDATE tbl_user SET last_login = user_date WHERE user_id = :id';
            $update_set = $pdo->prepare($update_lastLogin);
            $update_set->execute(
                array(
                    ':id'=>$id
                )
            );

            // $getLastLogin = 'SELECT last_login FROM tbl_user WHERE user_id = :id';
            // $lastLoginCheck = $pdo->query($getLastLogin);
            // $lastLoginCheck->execute(
            //     array(
            //         ':id'=>$id
            //     )
            // );
            // return $lastLoginCheck;
            
            // update user_date to be the current time as the user is logging in
            $update_timestamp = 'UPDATE tbl_user SET user_date = NOW() WHERE user_id = :id';
            $update_set = $pdo->prepare($update_timestamp);
            $update_set->execute(
                array(
                    ':id'=>$id
                )
            );

            // update user ip
            $update_query = 'UPDATE tbl_user SET user_ip = :ip WHERE user_id = :id'; 
            $update_set = $pdo->prepare($update_query);
            $update_set->execute(
                array(
                    ':ip'=>$ip,
                    ':id'=>$id
                )
            );
        }

        // redirect to the welcome page
        if(isset($id)){
            redirect_to('admin/index.php');
        }

    }else{
        //User does not exist
        $message = 'User does not exist';
    }

    //Log user in
    return $message;
}