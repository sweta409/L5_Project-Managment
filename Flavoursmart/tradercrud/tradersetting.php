<!DOCTYPE html>
<html lang="en-US">
  <head>
  <title>Customer Setting</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--font Awesome CDN-->   
  <script src="https://kit.fontawesome.com/462694daf9.js" crossorigin="anonymous"></script>

<style>
    

/*navbar csss*/

body {
  margin: 0;
  font-family: sans-serif;
  background-color: #EFB126 ;
}

/*setting profile*/
.header{
	display: block;
	text-align: center;
	height: auto;

}

.header img{
	display: block;
	margin: 0 auto;
	padding: 10px;
}

.header h3{
	display: inline;
	font-size: 30px;
	padding-bottom: 10px;
}

.header p{
	display: inline;
	font-size: 20px;
	color: #089E21;
	padding-bottom: 10px;
}
.container{
	width: 60%;
	max-width: 1100px;
	background: #f1f1f1 ;
	position: absolute;
	left: 50%;
	transform: translate( -50%);
	margin-top: 10px;
	padding: 30px 40px;
	box-sizing: border-boxx;
	border-radius: 2px;
  color: #089E21;
	box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
}

.txtb{
	border: 1px solid #EFB126;
	margin: 8px 0;
	padding: 10px 10px;
	border-radius:15px;
}

.txtb label{
	color:#333;
	text-transform: uppercase;
	font-size: 14px;
}

.txtb input,.txtb textarea{
	width: 40%;
	background: none;
	font-size: 14px;
	border: 1px solid gray;
	margin: 8px 0;
	padding: 7px 7px;
	border-radius: 4px;

}

 .button{
	width: 15%;
  height: 50px;
	display: block;
	background: #EFB126;
	padding: 10px 0;
	color: black;
	text-transform: uppercase;
	cursor: pointer;
	margin-top: 8px;
	border-radius:15px;
}

.container1{
    display: flex;
    flex-direction: row;
    background-color: black;
}

.box{
    padding: 10px;
    height: auto;
    width: 50%;
    color: white;
}

.box1{
    float: right;
    width:50%;
    margin-top: 15px;
    font-size: 10px;
    float: right;
    padding: 10px;
    height: auto;
    color: white;
    text-align:center;
}

.box1 a{
    text-decoration:none;
    color: red;
}

    </style>
  </head>
  <?php
  include 'connection.php';
  session_start();
  $id=$_SESSION['id'];
  $query="SELECT * FROM  USERS WHERE user_id='$id'";
  $result=oci_parse($connection, $query);
  oci_execute($result);
  $row=oci_fetch_assoc($result);
  ?>
  <body>

  <div class="container1">
    <div class="box">
        <h2>My Profile Setting</h2>
</div>

<div class="box1">
        <h2><a href="trader.php">Home</a>/Setting</h2>
</div>
</div>

<div class="header">
	<img src="pp.png">
    <h3>My Profile</h3>
    <p>Setting</p>
</div>

<div class="container">


	<h3>Personal Information</h3>
    <div class="txtb">
<form method="post">
  <label>Full name:</label>
  <input type="text" id="fname" name="fname" value="<?php echo $row['USER_FULLNAME']; ?>"><br>

  <label>Address:</label>
  <input type="text" id="address" name="address" value="<?php echo $row['USER_ADDRESS']; ?>"><br>

  <label>Contact:</label>
  <input type="text" id="contact" name="contact" value="<?php echo $row['USER_CONTACT']; ?>"><br>

  <label>Gender:</label>
  <input type="text" id="gender" name="gender" value="<?php echo $row['USER_GENDER']; ?>"><br>

  <button class="button" type="submit" value="Update" name="updateInfo" >Update</button>
</form>
</div>


<h3>Email Address</h3>
<div class="txtb">
<form>
  <label>Your Current Email:</label>
  <input type="text" id="email" name="email" value="<?php echo $row['USER_EMAIL']; ?>"><br>
  
</form>
</div>


<h3>Password</h3>
<div class="txtb">
<form  name="frmChange" method="post"  action="" onSubmit="return validatePassword()">
  <label>Current Password:</label>
  <input type="password" id="currentPassword" name="currentPassword" value="" class="required"><br>

  <label>New Password:</label>
  <input type="password" id="newPassword" name="newPassword" value="" class="required"><br>

  <label>Confirm Password:</label>
  <input type="password" id="confirmPassword" name="confirmPassword" value="" class="required"><br>

  <button class="button" type="submit" value="Update" name="updatePassword">Update</button>

</form>
</div>
 </div>  
 </body>
      </html>

      <?php
      if(isset($_POST['updateInfo'])){
        $fullname = $_POST['fname'];
        $address = $_POST['address'];
        $contact = $_POST['contact'];
        $gender = $_POST['gender'];
      $query = "UPDATE USERS 
                      SET 
                           user_fullName = '$fullname',
                           user_address = '$address', 
                           user_contact = $contact,
                           user_gender = '$gender'

                      WHERE user_id = '$id'";
                    $result = oci_parse($connection, $query) or die(oci_error($connection));
                    oci_execute($result)
                    ?>
                    <script type="text/javascript">
            alert("Update Successfull.");
            window.location = "tradersetting.php";
        </script>
        <?php
             }               
?>


<?php
if(isset($_POST['updatePassword'])){
$id=$_SESSION["user_id"];
include 'connection.php';

if (count($_POST) > 0) {
    $result = oci_parse($connection, "SELECT *from USERS WHERE user_id='$id'");
    oci_execute($result);
while($row = oci_fetch_array($result))
{
    if ($_POST["currentPassword"] == $row["USER_PASSWORD"]) {
       $update= oci_parse($connection, 
        "UPDATE USERS set user_password='" . $_POST["newPassword"] . "' WHERE user_id='$id'");
        oci_execute($update);
    }
  }
}
?>
  <script type="text/javascript">
    alert("Password Changed Successfully.");
    window.location = "setting.php";
     </script>
        <?php
             }               
?>





