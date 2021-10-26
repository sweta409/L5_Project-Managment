<?php

include 'connection.php';

$id=$_GET['id'];

// setcookie("myfav[$id]",$id, time()+(60*60*24*30), "/");

if(count($_COOKIE['cart']) < 20) {
    setcookie("cart[$id]",$id, time()+(60*60*24*30), "/");
    $message = 'Product added to cart!';
}else{
    $message = 'Cart Full!';
}
header('Location:AllProducts.php?message='. urlencode($message));
?>



