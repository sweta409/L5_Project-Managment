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
				$shop=$_POST['shop'];
				$productType=$_POST['productType'];
                $contact=$_POST['contact'];

        $email_check = "SELECT * FROM USERS WHERE user_email = '$email'";
        $res = oci_parse($connection, $email_check);
        oci_execute($res);
        if(oci_num_rows($res) > 0){
            $errors['email'] = "Email that you have entered is already exist!";
        }
     else{
                                   $subject = "Trader Registration Request";
                                   $message = "Name: $name\n Address: $address\n Email : $email\n Contact : $contact\n Shop : $shop\n productType : $productType";
                                   $sender = "From: noreply@flavoursmart21";
                                   if(mail('flavoursmart21@gmail.com', $subject, $message, $sender)){
                                       $info = "Traders Detail";
                                       $_SESSION['info'] = $info;
                                       $_SESSION['email'] = $email;
                                       $_SESSION['password'] = $password;
                                       ?>

                                       <script type="text/javascript">
                                            alert("Your request is sent to admin.");
                                            window.location = "../index.php";
                                            </script>
                                    <?php
                                       exit();
                                   }

                               }
                    }
		else
		{
			echo "Please enter valid email address";
		}
}   
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trader Registration</title>
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <div class="main">
        <div class="register">
            <div class="logo">
                <a href=""><img src="Logo2_c7227282.png" alt=""></a>
            </div>
            <h2>Trader Registration</h2>
            <form id="register" method="post">
                <label>Full Name </label>
                <br>
                <input type="text" name="fullName" id="name" placeholder="Enter Your Full Name" required>
                <br><br>

                <label>Email Address </label>
                <br>
                <input type="email" name="emailAddress" id="name" placeholder="Enter Your Valid EmailAdress" required>
                <br><br>

                <label>Address</label>
                <br>
                <input type="text" name="address" id="name" placeholder="Enter Your Address Here" required>
                <br><br>

                <label>Shop</label>
                <br>
                <input type="text" name="shop" id="name" placeholder="Enter Your Shop Name Here" required>
                <br><br>

                <label>Product Type</label>
                <br>
                <input type="text" name="productType" id="name" placeholder="Enter Your Product Type" required>
                <br><br>

                <label>Contact No.*</label>
                <br>
                <input type="number" name="contact" id="name" placeholder="Enter Your number" required>
                <br><br>

                <input id="checkbox" type="checkbox" required>
                <label> I agree with <a href="#" style="text-decoration:none"> Terms and Conditions </a></label>
                <br><br>

                <button class="button" type="submit" name="submit" value="Submit">Submit</button>
                <br><br>
                <button class="button" type="reset" name="clear" value="clear">Clear</button>
                <br><br>

                <label>Already have an account?<a href="login.php" style="text-decoration:none"> Login </a></label>


            </form>
        </div>
        <!--end register--->
    </div>
    <!---end main-->
</body>
<footer>
    <p>Copyright &copy; FlavoursMart 2021</p>
    <p style="float: right;">All Right Reserved</p>
</footer>

</html>