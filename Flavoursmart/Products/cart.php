<!DOCTYPE html>
<html>


<head>
  <title>Flavoursmart-Cart</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/cart.css">
  <link rel="stylesheet" href="../css/header.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"/>
  <link rel="stylesheet" href="css/header.css">

   <!-- font awesome -->
  <script src="https://kit.fontawesome.com/dbed6b6114.js" crossorigin="anonymous"></script>

</head>
<body>

  <div class="topnav">
    <img class="logo" src="images/Logo.png">
    <a href="../index.php">Home</a>
    <a href="../aboutus.php">About Us</a>
    <a href="AllProducts.php">All Products</a>

    <div class="search-container">
    <form action="Aproduct.php" method="get">
      <input type="text" placeholder="Search.." name="search">
      <button type="submit"><i class="fa fa-search"></i></button>
      </form>
    </div>
    <div class="icon-bar">

      <a href="../Products/cart.php"><i class="fas fa-cart-plus "></i></a>

      <div class="drop">
        <button class="btn"><a href=""> <i class="far fa-user "></i><i class="fa fa-caret-down"></i></a>
        </button>
        <div class="downdrop">
          <a href="../Registration/login.php">Profile Setting</a>
        </div>
      </div>
      <div class="dropdown">
        <button class="dropbtn">LogIn/Register
          <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content">
          <a href="../Registration/login.php">Login</a>
          <a href="../Registration/select.php">Register</a>
          <a href="../index.php">Logout</a>
        </div>
      </div>
    </div>
  </div>


<?php 

    if(isset($_POST['order'])){
		setcookie("cart_detail[products]", serialize($_POST['products']));
		setcookie("cart_detail[grand_total]", $_POST['grand_total']);
    }
		
	?>

 
  <div class="container">
<form method="post" action="">
    <!-- Note -->
    <!-- The flexible grid (content) -->
    <div class="row">
      <div class="main">

        <h2 style="color:green">Shopping Cart</h2>
        <!--<button class="button"><a href="deletecart.php?id=<?php echo $row['PRODUCT_ID']; ?>">Remove all</a></button>-->
        <br />
        <hr>
        <br />

        <?php

include 'connection.php';
$total=0;
        if (isset($_COOKIE['cart'])) {			
            foreach ($_COOKIE['cart'] as $name => $value) {
            //foreach ($products as $data) {
                $id = htmlspecialchars($value);
                $sql = "SELECT * FROM PRODUCT WHERE product_id = $id";

                $result = oci_parse($connection,$sql);
                oci_execute($result);
                $row=oci_fetch_assoc($result);
                if($row){
                  $discountSQL = "SELECT * FROM DISCOUNT WHERE product_id = $id";           
                  $discountResult = oci_parse($connection,$discountSQL);

                  oci_execute($discountResult);
                  $discountRow=oci_fetch_assoc($discountResult);  
                  $productPrice = $row['PRODUCT_PRICE'];
                  $discountPer = 0;
                  if($discountRow){
                    $discountPer = $discountRow['DISCOUNT'];
                    // print_r($discountRow);
                  }
                
                  $subTotal = $productPrice - ($productPrice*$discountPer/100);

echo '<div class="items" data-productId="'.$id.'" data-productname="'.$row['PRODUCT_NAME'].'" data-price="'.$productPrice.'" data-discount="'.$discountPer.'">';
  echo '<div class="box">';
 echo' <img src="./images/'.$row['PRODUCT_IMAGE'].'">';
echo '</div>';

echo'<div class="box1">';
  echo '<h2>'.$row['PRODUCT_NAME'].'</h2>';
 echo '<div>';
  echo  '<p>'.$row['PRODUCT_CATEGORY'].'</p>';
    echo '<p>'.$row['PRODUCT_STOCK_STATUS'].' Available</p>';
echo '</div>';

    echo '<div class="quantity buttons_added">';
     echo '<label>Quantity</label>';
     echo '<input type="hidden" class="id" value="<?='. $row['PRODUCT_ID']. '?>" name="products[<?='. $row['PRODUCT_ID'].' ?>][id]">';
     
  echo '<input id="quantity'.$id.'" data-id="'.$id.'" data-productPrice="'.$productPrice.'" data-discount="'.$discountPer.'" 
  class="productQuantity" type="number" step="1" min="1" max="20" title="qty" class="input-text qty text" size="4" pattern="" inputmode="" value="1" name="products">';
  
echo '</div>';
echo '<h5> <a href="deletecart.php?id='.$row['PRODUCT_ID'].'">Delete</a></h5>';
echo '<h5>Save For later</h5>';     
echo '</div>';

echo '<div class="box2">';
echo '<p>Unit Price:RS. '.$row['PRODUCT_PRICE'].'</p>';
echo '<p>Discount:'.$discountPer.'%</p>';
echo '<p class="subtotal'.$id.' subTotals" id="subTotals" data-subtotal="'.$subTotal.'">Sub Total:RS. '.$subTotal.'</p>';
echo '</div>';
echo '</div>';
                }

            }
          }
        
          else{
            echo 'No products in Cart';
          }
        
          echo '</div>';
?>
        <div class="side">
        
          <h1 style="text-align:center; color:green">Order Summary</h1>
          <div class="order">
            
            <hr>
            <input type="hidden" name="grand_total">
            <p>Total<span class="price" style="color:black">Rs.<b class="totalPrice" name="grand-total"></b></span></p>
          </div>

          <button class="button orderButton" name="order" style="margin:10px 25%; color: white">
            <!-- <a href="collectionslot.php">Order Now</a> -->Continue
        </button><br> <br><br />
        </form>
          <h2 style="text-align:center; color:green">Some products related your Cart</h2>

          <?php
include "connection.php";

$query="SELECT * FROM( SELECT * FROM PRODUCT  ORDER BY dbms_random.value) WHERE rownum <=4";  
    $result = oci_parse($connection,$query);
    oci_execute($result);
    while($row = oci_fetch_assoc($result)){
      echo '<div class="product">';
  echo '<div class="product1">';
  echo '<img src="./images/'.$row['PRODUCT_IMAGE'].'">';
  echo '</div>';
  echo '<div class="product2">';
  echo '<p>'.$row['PRODUCT_NAME'].'</p>';
  echo '<p>'.$row['PRODUCT_CATEGORY'].'</p>';
     echo'<span class="fa fa-star "></span>';
     echo'<span class="fa fa-star "></span>';
     echo'<span class="fa fa-star "></span>';
     echo'<span class="fa fa-star"></span>';
     echo'<span class="fa fa-star"></span>';
  echo'<p>RS. '.$row['PRODUCT_PRICE'].'</p>';
  echo'</div>';
echo '</div>';
    }?>
        </div>

        <script type="text/javascript">
          getTotal()
          function checkTotalQuantity() {
            let totalQuantity = 0;
            $('.productQuantity').each(function (i, obj) {
              let quantity = parseInt($(obj).val());
              totalQuantity += quantity;
            });
            // console.log(totalQuantity);
            if (totalQuantity < 20) return true;
            else return false;
          }

          function getTotal() {
            let total = 0;
            $('.subTotals').each(function (i, obj) {
              let subTotal = parseFloat($(obj).data('subtotal'));
              total += subTotal;
              // console.log(obj)
              // let quantity = parseInt($(obj).val());
              // totalQuantity+=quantity;
            });
            // console.log(total)
            $('.totalPrice').text(total)
          }

          $(".productQuantity").change(function (e) {
            if (checkTotalQuantity()) {
              let id = $(this).data('id');
              let quantity = parseFloat($(this).val());
              let price = parseFloat($(this).data('productprice'));
              let discount = parseFloat($(this).data('discount'));
              // console.log(quantity, price, discount)
              let subTotal = (quantity * (price - (price * discount / 100))).toFixed(2);
              // console.log(subTotal);
              $('.subtotal' + id).text('Sub Total:RS.' + subTotal);
              $('.subtotal' + id).data('subtotal', subTotal)
              getTotal();
            } else {
              alert('total quantity in a cart cannot be greater than 20')
            }

          });
          $(".orderButton").click(function(e){
            e.preventDefault();
            let orders = []
            $('.items').each(function (i, obj) {
              let item = $(obj)
              let price = item.data('price');
              let itemName = item.data('productname');
              let id = item.data('productid');
              let quantity = parseFloat($('#quantity'+id).val());
              // orders[i]['id'] = id;
              // orders[i]['itemName'] = itemName;
              // orders[i]['price'] = price;
              // orders[i]['quantity'] = quantity;

              orders.push({
                "id":id, "itemName":itemName, "price":price, "quantity":quantity
              })
              // console.log(i, obj, price, id, quantity)
            });
            let orderString = JSON.stringify(orders)
            sessionStorage.setItem('orders',orderString)
            console.log(orders, orderString)
            document.cookie = 'orders'+"="+orderString 
            let path = "collectionslot.php";
            $.ajax({  
                type:"GET",  
                url:path,  
                success:function(data){  
                  window.location.href = path;
                  }  
              });
          })

        </script>
      </div>
</body>

</html>