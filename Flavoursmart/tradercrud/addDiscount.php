<?php

include 'connection.php';
session_start();
//check to see if form has been submitted
if(isset($_POST['submitDiscount'])){

    //gather data from form
    $productname=$_POST['productname'];
    $discount=$_POST['discountpercent'];
    $dis_type=$_POST['dis_type']; 

    $id=$_SESSION['id'];
    $subject = "Request to add";
    $message = "Product Name: $productName\n Discount Percent: $discount\n Discount Type: $dis_type";
    $sender = "From: noreply@flavoursmart2021";
    if(mail('flavoursmart2021@gmail.com', $subject, $message, $sender)){
        $info = "Product Detail";
        $_SESSION['info'] = $info;
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;
        header('location: trader.php');
        exit();
    }
        ?>
        <script type="text/javascript">
        alert("Product Added Successfully.");
        window.location = "trader.php";
         </script>
         <?php 
}            
?>

   
