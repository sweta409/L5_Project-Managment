<?php
$connection = oci_connect('flavoursmart', 'flavoursmart', '//localhost/xe');
$errors=array();
session_start();
if(isset($_POST['submit'])){
        $_SESSION['info'] = "";
        ////
        $otp_code = $_POST['otp'];
        $check_code = oci_parse($connection,"SELECT * FROM USERS WHERE user_code = $otp_code");
        oci_execute($check_code);
        $fetch_data = oci_fetch_assoc($check_code);
        $row=oci_num_rows($check_code);
        if($row){

            $fetch_code = $fetch_data['USER_CODE'];
            $email = $fetch_data['USER_EMAIL'];
            $code = 0;
            $status = 'verified';
            $update_otp = oci_parse($connection,"UPDATE USERS SET user_code = $code, user_status = '$status' WHERE user_code = $fetch_code");

            //$update_res = oci_fetch($connection, $update_otp);
            oci_execute($update_otp);
            if($update_otp){
                $_SESSION['name'] = $name;
                $_SESSION['user_email'] = $email;

                header('location: login.php');
                exit();
            }else{
                $errors['otp-error'] = "Failed while updating code!";
            }
        }else{
            $errors['otp-error'] = "You've entered incorrect code!";
        }
    }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Code Verification</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="otp.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form">
                <form action="otp.php" method="POST" autocomplete="off">
                    <h2 class="text-center">Code Verification</h2>
                    <?php 
                    if(isset($_SESSION['info'])){
                        ?>
                        <div class="alert alert-success text-center">
                            <?php echo $_SESSION['info']; ?>
                        </div>
                        <?php
                    }
                    ?>
                    <?php
                    if(count($errors) > 0){
                        ?>
                        <div class="alert alert-danger text-center">
                            <?php
                            foreach($errors as $showerror){
                                echo $showerror;
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="form-group">
                        <input class="form-control" type="number" name="otp" placeholder="Enter verification code" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control button" type="submit" name="submit"  value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </div>   
</body>
</html>