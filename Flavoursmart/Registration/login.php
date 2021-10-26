<?php
include 'connection.php';
session_start();
if(isset($_POST['login'])){
    $Email= $_POST['user_email'];
    $pass= $_POST['user_password'];
    $user =$_POST['user'];

    $email_search="SELECT * FROM USERS WHERE user_email ='$Email'";
    $query=oci_parse($connection,$email_search);
    oci_execute($query);
    $fetchdata=oci_fetch_assoc($query);
    $email_count=oci_num_rows($query);

    if($email_count){
        $_SESSION['id']=$fetchdata['USER_ID'];
        $_SESSION['EMAIL']=$Email;
        $_SESSION['logged_in']=TRUE;
        if(isset($_POST['user'])){
        if ($fetchdata['USER_ROLE']==$_POST['user']) {
            switch($_POST['user']){
                case 'Customer':
                    header('location: ../index.php');
                break;
                case 'Trader':
                    header('location: ../tradercrud/trader.php');
                break;
                default:
                break;
            }
        }
        else{ ?>
             <script type="text/javascript">
    alert("Please select the correct user role");
     </script>
        <?php
             }
            } 
        }             
         
    else{?>
        <script type="text/javascript">
    alert("Invalid username/password");
     </script>
    <?php
    }
}
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
<div class="main">
<div class="register">
    <div class="logo">
        <a href=""><img src="img/Logo2_c7227282.png" alt=""></a>
    </div>
    <h2>Login</h2>
    <form id="register" method="post" action="login.php" name="form" >
       <label>Email or Username</label>
       <br>
       <input type="text" name="user_email" id="name" placeholder="Enter Your Email or Username" required>
       <br><br>
       <label>Password</label>
       <br>
       <input type="password" name="user_password" id="name" placeholder="Enter Password Here" required>
       <br><br>
        <input type="radio" name="user" value="Customer">
        <span>Customer</span>
        &nbsp;
        <input type="radio" name="user" value="Trader">
        <span>Trader</span>
        <br><br>
        <label><a href="forgot-password.php" style="text-decoration:none">forgot your password?</a></label>
       <br><br>
       <button class="button" type="submit" name="login" value="login">Login </button>
       <br><br>
       <label>Not a member Yet? <a href="select.php" style="text-decoration:none; text-align: center" > Registration Here </a></label>
       <br><br>
       
     </form>
</div><!--end register--->
</div><!---end main--> 
</body>
<footer>
    <p>Copyright &copy; FlavoursMart 2021</p>
    <p style="float: right;">All Right Reserved</p>
</footer>
</html>
