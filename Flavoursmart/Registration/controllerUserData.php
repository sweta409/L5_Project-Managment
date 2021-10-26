<?php 
session_start();
require "connection.php";
$email = "";
$name = "";
$errors = array();

    

    //if user click continue button in forgot password form
    if(isset($_POST['check-email'])){
        $email = $_POST['email'];
        $check_email = oci_parse($connection,"SELECT * FROM USERS WHERE user_email='$email'");
        //$run_sql = oci_parse($connection, $check_email);
        oci_execute($check_email);
        $fetch_data= oci_fetch_assoc($check_email);
        $run_sql= oci_num_rows($check_email);
        

        if($run_sql ){
            $code = rand(999999, 111111);
            $insert_code = "UPDATE USERS SET USER_CODE = $code WHERE user_email = '$email'";
            $run_query =  oci_parse($connection, $insert_code);
            oci_execute($run_query);

            if($run_query){
                $subject = "Password Reset Code";
                $message = "Your password reset code is $code";
                $sender = "From: flavoursmart2021@gmail.com";
                if(mail($email, $subject, $message, $sender)){
                    $info = "We've sent a passwrod reset otp to your email - $email";
                    $_SESSION['info'] = $info;
                    $_SESSION['email'] = $email;
                    header('location: reset-code.php');
                    exit();
                }else{
                    $errors['otp-error'] = "Failed while sending code!";
                }
            }else{
                $errors['db-error'] = "Something went wrong!";
            }
        }else{
            $errors['email'] = "This email address does not exist!";
        }
    }

    //if user click check reset otp button
    if(isset($_POST['check-reset-otp'])){
        $_SESSION['info'] = "";
        $otp_code = $_POST['otp'];
        $check_code =oci_parse($connection, "SELECT * FROM USERS WHERE USER_CODE = $otp_code");
        oci_execute($check_code);
        //$code_res = oci_parse($connection, $check_code);
        $fetch_data= oci_fetch_assoc($check_code);
        $run_sql= oci_num_rows($check_code);

        if($run_sql){
            //$fetch_data = oci_fetch_assoc($code_res);
            $email = $fetch_data['USER_EMAIL'];
            $_SESSION['email'] = $email;
            $info = "Please create a new password that you don't use on any other site.";
            $_SESSION['info'] = $info;
            header('location: new-password.php');
            exit();
        }else{
            $errors['otp-error'] = "You've entered incorrect code!";
        }
    }

    //if user click change password button
    if(isset($_POST['change-password'])){
        $_SESSION['info'] = "";
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];
        if($password !== $cpassword){
            $errors['password'] = "Confirm password not matched!";
        }else{
            $code = 0;
            $email = $_SESSION['email']; //getting this email using session
            $encpass = $_POST['password'];
            $update_pass = "UPDATE USERS SET user_code = $code, user_password = '$encpass' WHERE user_email = '$email'";
            $run_query = oci_parse($connection, $update_pass);
            oci_execute($run_query);
            if($run_query){
                $info = "Your password changed. Now you can login with your new password.";
                $_SESSION['info'] = $info;
                header('Location: password-changed.php');
            }else{
                $errors['db-error'] = "Failed to change your password!";
            }
        }
    }
    
   //if login now button click
    if(isset($_POST['login-now'])){
        header('Location: login.php');
    }
?>