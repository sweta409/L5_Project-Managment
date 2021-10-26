<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
    {
        box-sizing: border-box;
        font-family: sans-serif;
    }


.flex-container {
  display: flex;
  width: 90%;
  margin:  0 auto;
  background-color: white;
  justify-content: center;
  flex-direction:row; 
  border: 2px solid #089E21;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
}

.product-image{
flex:50%;
text-align: center;
padding: 20px;
}

.product-image img{
    max-width: 450px;
    height: 300px;
}

.product-detail{
flex:50%;
padding: 20px;
}

.product-detail h2{
    color: #EFB126;
}

.product-detail p{
    color: #089E21;
}

.button2{
    display: inline;
    width: 25%;
    background: #EFB126;
    padding: 10px 0;
    text-transform: uppercase;
    text-decoration: none;
    cursor: pointer;
    margin: 8px;
    border-radius:15px;
}

.button2 a{
    text-decoration: none;
    color:black;
}
</style>
</head>
<body>

<?php
include "connection.php";
$id=$_SESSION['id'];
        $query="SELECT * FROM PRODUCT WHERE user_id='$id'"; 
        $result = oci_parse($connection,$query);
        oci_execute($result);
        echo '<center><h2 style="color: green; text-decoration:underline;">Products</h2></center>';
        while($row = oci_fetch_assoc($result)){
  echo '<div class="flex-container">';
  echo '<div class="product-image">';
      echo '<img src= "../Products/images/'.$row['PRODUCT_IMAGE'].'">';
    echo '</div>';
  echo '<div class="product-detail">';
  echo '<h2>'. $row['PRODUCT_NAME'].'</h2>';
  echo'<p>Product Category: '.$row['PRODUCT_CATEGORY'].'</p>';
  echo'<p>Product Price: '.$row['PRODUCT_PRICE'].'</p>';
  echo'<p>Product Quantity: '.$row['PRODUCT_QUANTITY'].'</p>';
  echo'<p>Product Description: '.$row['PRODUCT_DESCRIPTION'].'</p>';
  echo'<p>Product Allergy: '.$row['PRODUCT_ALLERGY'].'</p>';
  echo '<button class="button2">'.'<a href="updateProduct.php?id='. $row['PRODUCT_ID'].'">Update</a>'.'</button>';
  echo '<button class="button2">'.'<a href="deleteProduct.php?id='. $row['PRODUCT_ID'].'">Delete</a>'.'</button>'.'<br />';
  echo '</div>';
 echo'</div>';
 echo '<br />';
    }

?>

</body>
</html>