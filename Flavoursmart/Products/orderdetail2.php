<?php 
	session_start();
	include 'connection.php';
	/*if(!$_SESSION['logged_in']){
		header("Location: ../Registration/login.php");
	}*/
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Order Detail</title>
	<link rel="icon" href="images/logo.png" type="image/x-icon"/>
	<link rel="stylesheet" type="text/css" href="../css/header.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="http://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css" rel="stylesheet" />
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>
<style>

body{
    font-style: sans-serif;
    background: #f1f1f1;
}

    .items {
  display:flex;
  flex-direction:row;
  background-color: white;
  width: 80%;
  border: 5px;
  height:auto;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  margin-left:10%;
  margin-top: 30px;
}

.box{
  display: flex;
  align-items: center;
  justify-content: center;
  width:30%;
  padding: 5px;
  /*background-color: red;*/
}

.box input{
height: 18px;
width: 18px;
margin-right: 50px;
}

.box img{
text-align: center;
width: 200px;
height: 150px;
}

.box1{
  padding:10px;
  width:50%;
  /*background-color: green;*/
}

.box1 h5{
 display:inline;
 margin-left: 20px;
}

.box2{
  padding: 10px;
  width:20%;
  /*background-color: yellow;*/
}

.box2 p{
  font-size: 15px;
}

.button{
  width: 200px;
  padding: 10px;
  font-size: 16px;
  float: right;
  font-family: sans-serif;
  font-weight: 600;
  border-radius: 3px;
  background-color: #2c5f2d;
  color: #fff;
  cursor: pointer;
  border: 1px solid rgba(255,255,255,0.3);
  box-shadow: 1px 1px 5px rgba(0,0,0,0.3);
}

.button a{
  text-decoration:none;
}
.button:hover{
      background-color: #45a049;
  }

.total h3{
 margin-right: 80px;
  width: 200px;
  float: right;
  font-family: sans-serif;
  font-weight: 600;
  color: #333;
  

}
</style>

</head>
<body>
	<!-- Header -->
	<?php include'../header.php'?>
    <!-- main body -->
     
    <?php 

        // $cookies = array('cart', 'orders', 'cart_detail');
       // remove all cookies value

        $finaltotal=0;
        $orderId = $_GET['order_id'];
		$orderSql=oci_parse($connection,"SELECT * FROM ORDER_ITEM WHERE ORDER_ID= '$orderId'");
        oci_execute($orderSql);
        while($row = oci_fetch_assoc($orderSql)){

            $id=$row['PRODUCT_ID'];
            $quantity=$row['ITEM_QUANTITY'];

            $sql = "SELECT * FROM PRODUCT WHERE PRODUCT_ID = $id";
            $result = oci_parse($connection,$sql);
            oci_execute($result);
            $data=oci_fetch_assoc($result);

            $sql1 = "SELECT * FROM DISCOUNT WHERE PRODUCT_ID=$id";
            $result1= oci_parse($connection,$sql1);
            oci_execute($result1);
            $data1=oci_fetch_assoc($result1); 
            ?>

<div class="items">
    <div class="box">
        <img src="./images/<?php echo $data['PRODUCT_IMAGE']?>">
        </div>

        <div class="box1">
        <p><?php echo $row['ITEM_NAME']?></p>
            <p><?php echo 'Quantity: '.$row['ITEM_QUANTITY']?><p>
        </div>

        <div class="box2">
            <p><?php echo 'Unit Price: '.$row['ITEM_PRICE']?></p>
            <p><?php echo 'Discount: '.$data1['DISCOUNT'].'%'?></p>
            <p><?php 
            $multiply=$row['ITEM_PRICE']*$row['ITEM_QUANTITY'];
            $discount=$data1['DISCOUNT']/100;
            echo 'Subtotal: '.$subtotal=$multiply - ($discount);

            
            $quantity=$row['ITEM_QUANTITY'];
            $multiply=$row['ITEM_PRICE'] * $row['ITEM_QUANTITY'];
            $discount=$data1['DISCOUNT']/100;
            $tt= $multiply - ($discount);
            $finaltotal += $tt; 
            
            ?>
        </p>
        </div>
        </div>

<?php
        }
         
        $_SESSION['amt']=$finaltotal;
    ?>
        <div class="total">
        <h3> <?php echo 'Total: '.$finaltotal.'</h3>'?>;
        </div>
        <form method ="POST" action="paypal.php">
				
				<input type="hidden" name="orderId" value="<?= $orderId ?>">
				<input type="hidden" name="total" value="<?= $finaltotal?>">
                <button class="button orderButton" name="order" style="margin:10px 25%; color: white">Order Now
        </button>
    </form>
    
	<!-- footer -->
	
</body>
</html>