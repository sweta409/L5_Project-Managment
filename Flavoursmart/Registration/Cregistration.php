<?php
include "connection.php";
session_start();
    $name="";
    $address="";
    $email="";
    $gender="";
    $contact="";
    $errors=array();

if (isset($_POST['submit'])) 
{	
		if (filter_var($_POST['emailAddress'], FILTER_VALIDATE_EMAIL)) {

				$name=$_POST['fullName'];
                $address=$_POST['address'];
				$email=$_POST['emailAddress'];
				$password1=$_POST['password'];
				$password2=$_POST['confirmPwd'];
                $gender=$_POST['gender'];
                $contact=$_POST['contact'];


                $email_check = "SELECT * FROM USERS WHERE user_email = '$email'";
                $res = oci_parse($connection, $email_check);
                oci_execute($res);
                if(oci_num_rows($res) > 0){
                    $errors['email'] = "Email that you have entered is already exist!";
                }
                
             else{

			if ($password1 == $password2) 
			{
			        if (strlen($_POST["password"]) <= '6') 
			        {
			            echo "Your Password Must Contain At Least 6 Characters!";
			        }
			        elseif(!preg_match("#[0-9]+#",$password1)) 
			        {
			            echo "Your Password Must Contain At Least 1 Number!";
			        }
			        elseif(!preg_match("#[A-Z]+#",$password1)) 
			        {
			            echo "Your Password Must Contain At Least 1 Capital Letter!";
			        }
			        elseif(!preg_match("#[a-z]+#",$password1))
			         {
			            echo "Your Password Must Contain At Least 1 Lowercase Letter!";
			        } else 
			        {
                            	if ($password1 == $password2) {
                                    
                            		$encrypt=$_POST['password'];
                                    $code=rand(9999,1111);
                                    $status="not verfied";
                            			$query = "INSERT INTO USERS 
										(user_fullName, user_address, user_email, user_password, user_code, user_status,
                                         user_gender, user_role, user_type, user_contact)
											VALUES 
												('$name','$address','$email','$encrypt','$code','$status',
                                                '$gender', 'Customer', ' ', '$contact')";
							   
                               $data_check = oci_parse($connection, $query);
                               oci_execute($data_check);
                   
                               if($data_check){
                                   //gmail configuration
                                   //ini_set('SMTP', 'myserver');
                                   //ini_set('smtp_port',587);
                   
                                   $subject = "Email Verification Code";
                                   $message = "Your verification code is $code";
                                   $sender = "From: noreply@flavoursmart2021";
                                   if(mail($email, $subject, $message, $sender)){
                                       $info = "We've sent a verification code to your email - $email";
                                       $_SESSION['info'] = $info;
                                       $_SESSION['email'] = $email;
                                       $_SESSION['password'] = $password;
                                       header('location: otp.php');
                                       exit();
                                   }
                                   else{
                                       $errors['otp-error'] = "Failed while sending code!";
                                   }
                               }
                               else{
                                   $errors['db-error'] = "Failed while inserting data into database!";
                               }
                    }
			    }
			}
			else
			{
			echo "Two password are not matching";
			}
        }	
		}
		else
		{
			echo "Please enter valid email address";
		}

}
   
    if(isset($_POST['check'])){
        $_SESSION['info'] = "";
        ////
        $otp_code = oci_real_escape_string($connection, $_POST['otp']);
        $check_code = "SELECT * FROM USERS WHERE user_code = $otp_code";
        $code_res = oci_parse($connection, $check_code);
        oci_execute($code_res);
        if(oci_num_rows($code_res) > 0){
            $fetch_data = oci_fetch_assoc($code_res);
            $fetch_code = $fetch_data['user_code'];
            $email = $fetch_data['user_email'];
            $code = 0;
            $status = 'verified';
            $update_otp = "UPDATE USERS SET user_code = $code, user_status = '$status' WHERE user_code = $fetch_code";
            $update_res = oci_fetch($connection, $update_otp);
            oci_execute($update_res);
            if($update_res){
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="main">
<div class="register">
    <div class="logo">
        <a href=""><img src="Logo2_c7227282.png" alt=""></a>
    </div>
    <h2>Customer Registration</h2>
    <form id="register"method="post">
       <label>Full Name </label>
       <br>
       <input type="text" name="fullName" id="name" placeholder="Enter Your Full Name" required>
       <br><br>

       <label>Email Address </label>
       <br>
       <input type="text" name="emailAddress" id="name" placeholder="Enter Your Valid EmailAdress" required>
       <br><br>

       <label>Address</label>
       <br>
       <input type="text" name="address" id="name" placeholder="Enter Your Address Here" required>
       <br><br>

       <label>Password</label>
       <br>
       <input type="password" name="password" id="name" placeholder="Enter Password Here" required>
       <br><br>

       <label>Confirm Password</label>
       <br>
       <input type="password" name="confirmPwd" id="name" placeholder="Enter Confirm Password Here" required>
       <br><br>
       
       <label>Gender </label>
       <br>
       <input type="radio" name="gender" id="male" value="Male" required>
       <span id="male">Male</span>
       &nbsp;
       <input type="radio" name="gender" id="female" value="Female" required>
       <span id="female">Female</span>
       &nbsp;
       <input type="radio" name="gender" id="others" value="Others" required>
       <span id="others">Others</span>
       <br><br>

       <label>Contact No.*</label>
       <br>
       <input type="text" name="contact" id="name" placeholder="Enter Your Address Here">
       <br><br>

       <input id="checkbox" type="checkbox">
       <label> I agree with <a href="#" style="text-decoration:none"> Terms and Conditions</a></label>
       <br><br>

       <button class="button" type="submit" name="submit" value="Submit">Submit</button>
       <br><br>
       <button class="button" type="reset" name="clear" value="clear">Clear</button>
       <br><br>

       <label>Already have an account?<a href="login.php" style="text-decoration:none"> Login </a></label>
    
    
     </form>
</div><!--end register--->
</div><!---end main--> 
</body>
<footer>
    <p>Copyright &copy; FlavoursMart 2021</p>
    <p style="float: right;">All Right Reserved</p>
</footer>
</html>