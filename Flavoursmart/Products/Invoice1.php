<?php include 'connection.php'?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title> Invoice</title>
	<link rel="icon" href="images/logo.png" type="image/x-icon"/>
	<link rel="stylesheet" type="text/css" href="css/style.css"/>
	<link rel="stylesheet" type="text/css" href="invoice.css"/>


	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
	<!-- Header -->
	

	<!-- main body -->
	<div class= "content">
		<div id="banner">
			<h1>Invoice</h1>
		</div>
		<?php
			session_start();//
			$orderId = $_GET['item_number'];
			
			$orderSql = "SELECT ORDER_DATE FROM ORDERS WHERE ORDER_ID = " . $orderId;
			$result = oci_parse($connection,$orderSql);
			oci_execute($result);
			$order=oci_fetch_assoc($result);

			$paymentSql = "SELECT * FROM PAYMENT WHERE ORDER_ID = ". $orderId ;//
			$result = oci_parse($connection,$paymentSql);//
		
			oci_execute($result);//
			oci_fetch_assoc($result);//

			if(!oci_num_rows($result)){//
				$amount = $_GET['amt'];
				$userId = $_SESSION['id'];

				$insertPaymentSql = 'INSERT INTO PAYMENT(order_id, user_id, total_amount) ';
				$insertPaymentSql .= "VALUES(:orderNo, :userId, :amt) ";
				
				$insertPaymentStatement = oci_parse($connection, $insertPaymentSql);

				oci_bind_by_name($insertPaymentStatement, ':orderNo', $orderId);
				oci_bind_by_name($insertPaymentStatement, ':userId', $userId);
				oci_bind_by_name($insertPaymentStatement, ':amt', $amount);

				oci_execute($insertPaymentStatement);
			}//
		?>

        <div class="invoice-header">
                <h4> Order ID : <?= $orderId ?></h4><br>
				<h4>Placed on : <?= $order['ORDER_DATE'] ?></h4> 
            <div class="total-amount">
                <h5>Total: Rs.<span id="gtotal">50</span></h5>
            </div>
        </div>
		<div id="invoice-detail">
			<h3>Products</h3>
			<h3>Quantity</h3>
			<h3>Price</h3>
			<h3></h3>
			
			<?php 
				$orderSql = "SELECT product.PRODUCT_ID, product.PRODUCT_STOCK_STATUS, PRODUCT_NAME, ITEM_QUANTITY, PRODUCT_PRICE, PRODUCT_IMAGE" ;
				$orderSql .= " FROM order_item";
				$orderSql .= " JOIN product ON order_item.PRODUCT_ID = product.PRODUCT_ID";
				$orderSql .= " WHERE order_item.ORDER_ID = '" . $orderId . "' ";
				
				$result = oci_parse($connection,$orderSql);
				oci_execute($result);
			// $data=oci_fetch_assoc($result);
				$grandTotal = 0;

				
			?>

			<?php while($product=oci_fetch_assoc($result)){?>
				<?php
					$newQty = $product['PRODUCT_STOCK_STATUS'] - $product['ITEM_QUANTITY'];
					$updateProductSql = "UPDATE PRODUCT SET PRODUCT_STOCK_STATUS = " . $newQty . " ";
					$updateProductSql .= "WHERE PRODUCT_ID = ". $product['PRODUCT_ID'];

					$updateProductStatement = oci_parse($connection,$updateProductSql);
					oci_execute($updateProductStatement);
				?>

				<?php $grandTotal += $product['ITEM_QUANTITY'] *  $product['PRODUCT_PRICE']; ?>
				<div class="invoiceproduct">

					<h4><?= $product['PRODUCT_NAME']?></h4>
					
				</div>
				<div class="price">
					<h4><?= $product['ITEM_QUANTITY']?></h4>
				</div>
				<div class="price">
					<h4><?= "€".$product['PRODUCT_PRICE'] ?></h4>
				</div>
				
			<?php }?>
		
		</div>
		<script>
			$('#gtotal').html('<?= $grandTotal ?>')
		</script>

		<?php 
			$colSql = "SELECT * FROM COLLECTION_SLOT WHERE USER_ID=".$userId;
			$result = oci_parse($connection,$colSql);
			oci_execute($result);
			$data=oci_fetch_assoc($result);
			
			
			
			$time = date("h:i a", strtotime($data['COLLECTION_TIME']))
		?>
		<div class="collection-slot">
			<h4>Collection Slot:</h4>
			Day : <?= $data['COLLECTION_DATE'] ?>
			Time : <?= $time ?>
		</div>

	<!-- footer -->
	
</body>
</html>