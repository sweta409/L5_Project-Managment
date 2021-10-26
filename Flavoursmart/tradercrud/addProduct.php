<?php

include 'connection.php';

//check to see if form has been submitted
if(isset($_POST['submitProduct'])){

    //gather data from form
    $productName=$_POST['productname'];
    $price=$_POST['price'];
    $quantity=$_POST['quantity'];
    $description=$_POST['description'];
    $discount=$_POST['discount'];
    $image=$_POST['image'];
    $category=$_POST['category'];

    $subject = "Request to add product";
    $message = "Product Name: $productName\n Price: $price\n Quantity : $quantity\n Description : $description\n Discount : $discount\n  Image: $image\n  Category: $category";
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

