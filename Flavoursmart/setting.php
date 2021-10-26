<?php
  include 'connection.php';
  session_start();
  if(!$_SESSION['logged_in']){
  header("location: ./Registration/login.php");
  }

  $id=$_SESSION['id'];
  $query="SELECT * FROM  USERS WHERE user_id='$id'";
  $result=oci_parse($connection, $query);
  oci_execute($result);
  $row=oci_fetch_assoc($result);
  ?>



<!DOCTYPE html>
<html lang="en-US">
  <head>
  <title>Customer Setting</title>
  <link rel="stylesheet" href="./css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--font Awesome CDN-->   
  <script src="https://kit.fontawesome.com/462694daf9.js" crossorigin="anonymous"></script>
  </head>

  <body>
<?php
include 'header.php';
?>

  
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
            window.location = "setting.php";
        </script>
        <?php
             }               
?>


<?php
if(isset($_POST['updatePassword'])){

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
            </body>

      </html>