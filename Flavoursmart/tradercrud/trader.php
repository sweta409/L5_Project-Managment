<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="trader.css">
    <script src="script.js"></script>
    <title>Flavours Mart</title>
    <style>
    * {
  font-family:sans-serif;
}


/* Column container */
.row {  
  display: flex;
  flex-wrap: wrap;
}

/* Create two unequal columns that sits next to each other */
/* Sidebar/left column */

/* Main column */
.side {
  flex: 15%;
  flex-direction: column;
  /*background-color: #80ff80;*/
  background-color:#EFB126;
}

.sidenav{
  position:fixed;
  display: flex;
  width:15%;
  height: 100%;
  flex-direction: column;
  text-align: center;
}

.sidenav a{
  padding: 15px;
  text-decoration:none;
  font-size: 18px;
  color:black;
}

.sidenav img{
width: 100px;
height:100px;
margin-left: 60px;
margin-top: 20px;
}

.sidenav a:active {
  background-color: #089E21;
  color: #333;
}

.sidenav a:hover:not(.active) {
  background-color: #089E21;
  color: #333;
}
.main{
  flex: 85%;
  background-color: white;
  flex-direction: column;
  justify-content: center;
}

.logo{
  position:fixed;
  width:85%;
  top:-1%;
  background-color:white;
  padding: 20px;
  text-align: center;
}

.nav{
position:fixed;
width: 85%;
top: 18%;
display: flex;
flex-direction: row;
justify-content: center;
background-color:#EFB126;
}

.nav a{
  text-align: center;
  text-decoration:none;
  padding:30px;
  font-size: 20px;
  color: black;
}

.nav a:hover:not(.active) {
  background-color: #089E21;
  color: #fff;
}

.items{
  margin-top: 200px;
  background-color: #f1f1f1;
  padding: 10px;
}

</style>

</head>
<body>
        <div class="row">
             <div class="side">
                 <div class="sidenav">
                 <img src="pp.png">
                 <br/>

                 <?php
include 'connection.php';
session_start();
$id=$_SESSION['id'];

$query=oci_parse($connection,"SELECT USER_FULLNAME FROM USERS where user_id='$id'");
oci_execute($query);

            ?>
  <a href="trader.php">Home</a>
  <a href="tradersetting.php">Account Setting</a>
  <a href="http://127.0.0.1:8080/apex/f?p=102:LOGIN_DESKTOP:11500243730901:::::">Dashboard</a>
  <a href="#about">Reports</a>
  <a href="traderlogout.php">Logout</a>
</div>
</div>

<div class="main">
  <div class="logo">
     <a href="../index.php"><img src="Logo.png"></a>
</div>
              <div class="nav">
                 <a href="#addshop">Add Shop</a>
                 <a href="#viewshop">View Shop</a>
                 <a href="#addproduct">Add Product</a>
                 <a href="#viewproduct">View Product</a>
                 <a href="#adddiscount">Add Discount</a>
                 <a href="#viewdiscount">View Discount</a>
              </div>
              <div class="items">
              <?php
include "connection.php";

        $query="SELECT * FROM( SELECT * FROM  PRODUCT WHERE user_id='$id' ORDER BY dbms_random.value) WHERE rownum <=5"; 
        $result = oci_parse($connection,$query);
        oci_execute($result);
        echo '<center><h2 style="color: green; text-decoration:underline; margin-top: 50px;">Recent Products</h2></center>';
        
    echo '<div class="table-wrapper">';
   
        echo '<table class="fl-table">';
        
            echo '<thead>';
            echo '<tr>';
                echo '<th>NAME</th>';
                echo '<th>PRICE</th>';
                echo '<th>IMAGE</th>';
                echo '<th>AMEND</th>';
                echo '<th>DELETE</th>';
            echo'</tr>';
         
            echo'</thead>';
            while($row = oci_fetch_assoc($result)){
            echo '<tbody>';
            echo '<tr>';
            echo '<td>'.$row['PRODUCT_NAME'].'  '.'</td>';
            echo '<td>'.$row['PRODUCT_PRICE'].'  '.'</td>';
            echo '<td>'.'<img src="../Products/images/' . $row['PRODUCT_IMAGE'] . '" />'.'  '.'</td>';
            echo '<td>'.'<a href="updateProduct.php?id='. $row['PRODUCT_ID'].'">Amend</a>'.'  '.'</td>';
            echo '<td>'.'<a href="deleteProduct.php?id='. $row['PRODUCT_ID'].'">Delete</a> <br />'.'</td>';  
            echo '</tr>';
            
            echo '<tbody>';
        }
        echo '</table>';
    echo '</div>';
        ?>


  <div id="addshop" class="txt" style="top:200px;">
  <h3>Enter the Shop Details</h3>
<form method="post" action="addShop.php">
  <label for="fname">Shop Name:</label><br>
  <input type="text" autocomplete="off" id="fname" name="shopname" value=" " required><br>

  <label for="tname">Trader Name:</label><br>
  <input type="text" autocomplete="off" id="tname" name="tradername" value=" " required><br>

  <label for="lname">Shop Location:</label><br>
  <input type="text" autocomplete="off" id="location" name="location" value=" " required><br>

  <button class="button" type="submit" value="Update" name="submitShop" >Add</button>
  <button class="button" type="clear" value="Clear" name="clear" >Clear</button>
</form>
     </div>

     <div id="viewshop" class="txt" style="top:200px;">
     <?php
     include 'viewshop.php';
     ?>
     </div>


  <div id="addproduct" class="txt">
  <h3>Enter the Product Details</h3>
<form method="post" action="addProduct.php" autocomplete="off">
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

  <label for="lname">Product Image:</label><br>
  <input type="text" id="image" name="image" value=" " required><br>

  <button class="button" type="submit" value="Update" name="submitProduct" >Add</button>
  <button class="button" type="clear" value="Clear" name="clear" >Clear</button>
</form>
     </div>

     <div id="viewproduct" class="txt">
     <?php
     include 'viewProduct.php';
     ?>
     </div>

     <div id="adddiscount" class="txt">
  <h3>Enter Discount Details</h3>
<form method="post" action="addDiscount.php" autocomplete="off">

<label for="lname">Product Name</a></label><br>
<input type="text" id="dis" name="productname" value=" ">
           <br>

  <label for="lname">Discount(%)</label><br>
  <input type="text" id="dis" name="discountpercent" value=" "><br>

  <label for="lname">Discount Type:</label><br>
  <input type="text" id="disType" name="dis_type" value=" "><br>

  <button class="button" type="submit" value="Update" name="submitDiscount" >Add</button>
  <button class="button" type="clear" value="Clear" name="clear" >Clear</button>
</form>  
</div>

<div id="viewdiscount" class="txt">
     <?php
     include 'viewDiscount.php';
     ?>
     </div>
      </div>
         </div>
    </div>

</body>
</html>