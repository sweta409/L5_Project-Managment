<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" type="text/css" href="invoice.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"/>
 
    <title>invoice</title>
</head>
<body>

    <div class="container bootdey">
        <div class="row invoice row-printable">
            <div class="col-md-10">
                <!-- col-lg-12 start here -->
                <div class="panel panel-default plain" id="dash_0">
                    <!-- Start .panel -->
                    <div class="panel-body p30">
                        <div class="row">
                            <!-- Start .row -->
                            <div class="col-lg-6">
                                <!-- col-lg-6 start here -->
                                <img src="Logo.png" alt="" class="img-fluid" width="200">
                            </div>


                            <?php
                            include 'connection.php';
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

                    <!-- col-lg-6 end here -->
                    <div class="col-lg-12">
                        <!-- col-lg-12 start here -->
                        <div class="invoice-details mt25">
                            <div class="well">
                                <ul class="list-unstyled mb0 text-right">
                                    <li><h1>Invoice</h1></li>
                                    <li><strong>ORDER ID:   <?= $orderId ?></strong> </li>
                                    <li><strong>INVOICE DATE:  <?= $order['ORDER_DATE'] ?></strong> </li>
 
                                </ul>
                            </div>
                        </div>
                        <div class="invoice-to mt25">
                            <ul class="list-unstyled">
                                <li><h3>RECEIPT</h3></li>

                            </ul>
                        </div>

                        <p>INVOICE</p>
                        
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
                <div class="invoice-items">
                            <div class="table-responsive" style="overflow: hidden; outline: none;" tabindex="0">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr><th class="text-center">PRODUCT</th>
                                            <th class="text-center">QUANTITY</th>
                                            <th class="text-center">PRICE</th>
                                        </tr>
                                            <tr>
                                             <td><?= $product['PRODUCT_NAME']?></td>
                                             <td><?= $product['ITEM_QUANTITY']?></td>
                                             <td><?= "Rs.".$product['PRODUCT_PRICE'] ?></td>
                                            </tr>    
                                    </thead>
                                    </table>
                                    <?php
                                       }
                                    ?>
                                    <tfoot>
                                        <table class="table table-bordered">
                                        <tr>
                                            <th colspan="2" class="text-right">
                                            <h5>Total: Rs.<span id="gtotal">50</span></h5>
                                            </th>
                                            
                                        </tr>
                                    </table>
                                    </tfoot> 
                            </div>
        
                                    </div>
            <?php 
			$colSql = "SELECT * FROM COLLECTION_SLOT WHERE user_id=".$userId;
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
                        <div class="invoice-footer mt25">
                            <p class="text-center">Note: Thankyou for shopping with us please visit us again </p>
                        </div>
                    </div>
                    <!-- col-lg-12 end here -->
                </div>
                <!-- End .row -->
            </div>
        </div>
        <!-- End .panel -->
    </div>
    <!-- col-lg-12 end here -->
</div>
</div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
      <h3><a href='../index.php' style="text-decoration: none; margin-left: 33%; color: green; ">Return to home page</a></h3>
    
    <script>
            $('#gtotal').html('<?= $grandTotal ?>')
        </script>
</body>
</html>