

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="trader.css">
    <script src="script.js"></script>
    <title>Document</title>
</head>
<body>
<div class="sidebar">
  <img src="pp.png">
  <p>Profile name</p>
  <a href="#home">Home</a>
  <a href="#addproduct">Account Setting</a>
  <a href="#news">Total No. of Orders</a>
  <a href="#contact">Total No.of Products</a>
  <a href="#about">Reports</a>
</div>

<div class="container2">
 <div class="header">
  <img src="Logo.png">
</div>

  <nav class="navbar">
    <div class="navbar-container">
      <ul>
        <a href="#addshop">Add Shop</a>
        <a>View Shop</a>
        <a href="#addproduct">Add Product</a>
        <a>View Product</a>
        <a href="#adddiscount">Add Discount</a>
        <a>Orders Delivered</a>
      </ul>
</div>
</nav>

<center id="home"><h2>Recently added Products</h2></center>

<?php
include 'connection.php';
$query="SELECT * FROM products";
$result=mysqli_query($connection, $query);
echo '<table>';
  echo '<tr>';
    echo '<th>Name</th>';
    echo '<th>Price</th>';
    echo '<th>Image</th>';
    echo '<th>Amend</th>';
    echo '<th>Delete</th>';
  echo '</tr>';

  while ($row=mysqli_fetch_assoc($result)){
    echo '<tr>';
    echo '<td>'.$row['ProductName'].'  '.'</td>';
    echo '<td>'.$row['ProductPrice'].'  '.'</td>';
    echo '<td>'.'<img src="./images/' . $row['ProductImageName'] . '" />'.'  '.'</td>';
  echo '</tr>';
  }
echo '</table>';

?>

<div id="addshop" class="txt">
  <h3>Enter the Shop Details</h3>
<form method="post" action="addShop.php">
  <label for="fname">Shop Name:</label><br>
  <input type="text" autocomplete="off" id="fname" name="shopname" value=" " required><br>

  <label for="tname">Trader Name:</label><br>
  <input type="text" autocomplete="off" id="tname" name="tradername" value=" " required><br>

  <label for="lname">Shop Location:</label><br>
  <input type="text" autocomplete="off" id="location" name="location" value=" " required><br>

  <button type="submit" value="Submit" name="submitShop"></button>
  <button type="clear" value="Clear"></button>
  <button type="Cancel" value="Cancel"></button>
</form>
     </div>

     <?php
     include 'viewshop.php';
     ?>


  <div id="addproduct" class="txt">
  <h3>Enter the Product Details</h3>
<form method="post" action="addProduct.php">
  <label for="fname">Product Name:</label><br>
  <input type="text" id="fname" name="productname" value=" " required><br>

  <label for="lname">Product Category:</label><br>
  <input type="text" id="category" name="category" value=" " required><br>

  <label for="lname">Price:</label><br>
  <input type="text" id="price" name="price" value=" " required><br>

  <label for="lname">Quantity:</label><br>
  <input type="text" id="quantity" name="quantity" value=" " required><br>

  <label for="lname">Description:</label><br>
  <input type="text" id="desc" name="description" value=" " required><br>

  <label for="lname">Discount(%):</label><br>
  <input type="text" id="discount" name="discount" value=" " required><br>

  <label for="lname">Stock Availability:</label><br>
  <input type="text" id="available" name="stock" value=" " required><br>

  <label for="lname">Product Image:</label><br>
  <input type="text" id="image" name="image" value=" " required><br>

  <button type="submit" value="submit" name="submitProduct"></button>
  <button type="clear" value="Clear"></button>
  <button type="Cancel" value="Cancel"></button>
</form>
     </div>

     <?php
     include 'viewProduct.php';
     ?>

     <div id="adddiscount" class="txt">
  <h3>Enter Discount Details</h3>
<form method="post" action="addDiscount.php">
  <label for="fname">Product Name:</label><br>
  <input type="text" id="fname" name="product_name" value=" "><br>

  <label for="lname">Discount(%)</label><br>
  <input type="text" id="dis" name="discount" value=" "><br>

  <label for="lname">Discount Type:</label><br>
  <input type="text" id="disType" name="dis_ype" value=" "><br>

  <button type="submit" value="submit" name="submitShop"></button>
  <button type="clear" value="Clear"></button>
  <button type="Cancel" value="Cancel"></button>
</form>
     </div>
     </div>
      <script src="script.js"></script> 
</body>
</html>
