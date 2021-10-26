<?php
include 'connection.php';
session_start();

if(!$_SESSION['logged_in']){
    header('location: ../Registration/login.php');
  }

  ?>
<!DOCTYPE html>

<html>
<head>
<style>
   body {
       padding:0;
       /* background:  #EFB126; */
       font-family: sans-serif;
    }

.container{
    display: flex;
    flex-direction: row;
    background-color: black;
}

.box{
    padding: 10px;
    height: auto;
    width: 50%;
    color: white;
}

.box1{
    float: right;
    width:50%;
    margin-top: 15px;
    font-size: 10px;
    float: right;
    padding: 10px;
    height: auto;
    color: white;
    text-align:center;
}

.box1 a{
    text-decoration:none;
    color: red;
}

.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  max-width: 350px;
  margin: 0 auto;
  height: auto;
  text-align: center;
  background-color: #f1f1f1;
}

.card h1{
    color: #089E21;
    padding: 20px;
}

.card label{
color: #089E21;
font-size: 20px;
}

.card select{
    width: 150px;
    height: 30px;
}

.button{
  border: none;
  outline: 0;
  padding: 12px;
  color: white;
  background-color: #000;
  text-align: center;
  cursor: pointer;
  width: 100%;
  font-size: 18px;
}

.card button:hover {
  opacity: 0.7;
}
.footer{
    position:sticky;
    background: #6d8053;
    width: 100%;
    margin-top: 21%;
    color: #fff;
    font-size: 14px;
    height: auto;    
}
.footer p{
    margin-left: 10px;
    display: inline-block;
    margin-right: 10px;
}

</style>
</head>
<body>


<?php
error_reporting(0);

$id = $_SESSION['id'];
if (isset($_POST['submit'])) {
    // 12/15/2020
$date = date("d/m/Y");
$day = $_POST['day'];
$time = $_POST['time'];
$orders = json_decode($_COOKIE['orders'], true);
// print_r($orders);
$status = ' ';

// when paypal submit button is clicked insert into cart
$query='INSERT INTO CART (user_id) VALUES (:user_id)';
$insertcartstatement=oci_parse($connection,$query);
oci_bind_by_name($insertcartstatement, ':user_id', $id);
oci_execute($insertcartstatement);

$lastCart = 'SELECT MAX( CART_ID ) FROM CART';
$lastCartStatement=oci_parse($connection,$lastCart);
oci_execute($lastCartStatement);
$lastCartId = oci_fetch_assoc($lastCartStatement);
// $lastinsertedCart = 
// // insert into collection slot
// $quer ="INSERT INTO COLLECTION_SLOT(COLLECTION_TIME, USER_ID, COLLECTION_DAY, COLLECTION_DATE) VALUES('".$time."', ".$id.", '".$day."', '".$date."')";

$insertCollectionSlotSql = 'INSERT INTO COLLECTION_SLOT(COLLECTION_TIME, USER_ID, COLLECTION_DAY, COLLECTION_DATE) '.
'VALUES(:time, :userId, :collectionDay, :orderDate)';

$colectionSlotStatement = oci_parse($connection, $insertCollectionSlotSql);
oci_bind_by_name($colectionSlotStatement, ':time', $time);
oci_bind_by_name($colectionSlotStatement, ':userId', $id);
oci_bind_by_name($colectionSlotStatement, ':collectionDay', $day);
oci_bind_by_name($colectionSlotStatement, ':orderDate', $date);

// if (!$insertCollectionSlotSql) {
//     $error = oci_error($connection);
//     echo "Parse ERROR: (" . $error['message'] . ")";
// } else
//     echo "NO ERROR";

$r = oci_execute($colectionSlotStatement);
var_dump($r);
// $quer = "INSERT INTO COLLECTION_SLOT(COLLECTION_TIME, USER_ID, COLLECTION_DAY, COLLECTION_DATE)
//     VALUES 
//         ('$time',$id,'$day','$date')";
// $colectionSlotStatement = oci_parse($connection, $quer);
// oci_execute($colectionSlotStatement);
// echo $time .' '. $id . ' '. $day . ' '.$date.' '.$lastCartId ;
// var_dump($r);
// if (!$r) {
//     $error = oci_error($colectionSlotStatement);
//     echo "Execution ERROR: (" . $error['message'] . ")";
// } else
//     echo "NO ERROR";


if($colectionSlotStatement){
    $lastCollectionSlot = 'SELECT MAX( COLLECTION_ID ) FROM COLLECTION_SLOT';
    $lastCollectionSlotStatement=oci_parse($connection,$lastCollectionSlot);
    oci_execute($lastCollectionSlotStatement);
    $lastCollectionSlotId = oci_fetch_assoc($lastCollectionSlotStatement);
    print_r($lastCartId['MAX(CART_ID)']);
    $collectionId = $lastCollectionSlotId['MAX(COLLECTION_ID)'];
    $cartId = $lastCartId['MAX(CART_ID)'];
      
// die;  
    // get user id, cart id, collection id, date, status 
    //insert into order table
    // $insertOrderQuery = "INSERT INTO ORDERS(CART_ID, ORDER_DATE, USER_ID, STATUS, COLLECTION_ID)
    // VALUES 
    //     ($cartId,'$date',$id,'$status',$collectionId)";
    // print($insertOrderQuery);
    // $ordersSlot = oci_parse($connection, $insertOrderQuery);
    // oci_execute($ordersSlot);

    $insertOrderSql = 'INSERT INTO ORDERS(CART_ID, ORDER_DATE, USER_ID, STATUS, COLLECTION_ID) '.
    'VALUES(:cartId, :orderDate, :userId, :status, :collectionId)';
    $insertOrderStatement = oci_parse($connection, $insertOrderSql);
    oci_bind_by_name($insertOrderStatement, ':orderDate', $date);
    oci_bind_by_name($insertOrderStatement, ':userId', $id);
    oci_bind_by_name($insertOrderStatement, ':collectionId', $collectionId);
    oci_bind_by_name($insertOrderStatement, ':status', $status);
    oci_bind_by_name($insertOrderStatement, ':cartId', $cartId);
    oci_execute($insertOrderStatement);
    if($insertOrderStatement){
        $lastOrder = 'SELECT MAX( ORDER_ID ) FROM ORDERS';
        $lastOrderStatement=oci_parse($connection,$lastOrder);
        oci_execute($lastOrderStatement);
        $lastOrderId = oci_fetch_assoc($lastOrderStatement);
        print('ordid');
        print_r($lastOrderId['MAX(ORDER_ID)']);
        $orderId = $lastOrderId['MAX(ORDER_ID)'];

        // loop through orders and insert into order_item table
        // ned order id from order table
        for($i=0; $i< count($orders); $i++ ){
            // working
            // print($orders[$i]['id']);
            $insertOrderItemSql = 'INSERT INTO ORDER_ITEM(ORDER_ID,PRODUCT_ID, ITEM_QUANTITY, ITEM_NAME,ITEM_PRICE ) '.
            'VALUES(:orderId, :productId, :quantity, :name, :price)';

            $insertOrderItemStatement = oci_parse($connection, $insertOrderItemSql);
            oci_bind_by_name($insertOrderItemStatement, ':orderId', $orderId);
            oci_bind_by_name($insertOrderItemStatement, ':productId', $orders[$i]['id']);
            oci_bind_by_name($insertOrderItemStatement, ":quantity", $orders[$i]['quantity']);
            oci_bind_by_name($insertOrderItemStatement, ":name", $orders[$i]['itemName']);
            oci_bind_by_name($insertOrderItemStatement, ":price", $orders[$i]['price']);
            oci_execute($insertOrderItemStatement);
        }

        header('Location: orderdetail2.php?order_id='.$orderId);
    }else
    {
        print('nn');
    die;
    }
}else
{
    print('noen');
    die;
}
}
?>

<div class="container">
    <div class="box">
        <h2>Collection Slots</h2>
</div>

<div class="box1">
        <h2><a href="cart.php">Return to Cart</a>/Collection Slot</h2>
</div>
</div>

<div class="card">
<h1>Collection slots </h1>

<?php 
date_default_timezone_set("Asia/Kathmandu");
?>
<form method="post" action="collectionslot.php">
<label>Day:</label>		    
    <select name="day" value="" id="day" required>
        <option name="day" >Select</option>
    <?php

$today= date("l"); 
$current_time=date("H"); //the current time in 24 hr format

if($today=='Tuesday' && $current_time<19){    //if purchase is made on tuesday and time is earlier than 19pm 
    echo "<option value='Wednesday'>Wednesday</option>"; //all slots are open
    echo "<option value='Thursday'>Thursday</option>";
    echo "<option value='Friday'>Friday</option>";
}

elseif($today=='Tuesday' && $current_time>=19){  // if purchase is made on tuesday and time is 19pm or more then 
    echo "<option value='Next Wednesday'>Next Wednesday</option>";   //all slots for thursday friday and next wednesday are open
    echo "<option value='Thursday'>Thursday</option>";
    echo "<option value='Friday'>Friday</option>";
}

elseif($today=='Wednesday' && $current_time<19){     // if purchase is made on wednesday and time is earlier than 19pm 
    echo "<option value='Next Wednesday'>Next Wednesday</option>";   //all slots for thursday friday and next wednesday are open
    echo "<option value='Thursday'>Thursday</option>";
    echo "<option value='Friday'>Friday</option>";
}

elseif($today=='Wednesday' && $current_time>=19){
    echo "<option value='Next Wednesday'>Next Wednesday</option>";
    echo "<option value='Next Thursday'>Next Thursday</option>";
    echo "<option value='Friday'>Friday</option>";
}

elseif($today=='Thursday' && $current_time<19){
    echo "<option value='Next Wednesday'>Next Wednesday</option>";
    echo "<option value='Next Thursday'>Next Thursday</option>";
    echo "<option value='Friday'>Friday</option>";
}

elseif($today=='Thursday' && $current_time>=19){
    echo "<option value='Next Wednesday'>Next Wednesday</option>";
    echo "<option value='Next Thursday'>Next Thursday</option>";
    echo "<option value='Next Friday'>Next Friday</option>";
}

elseif ($today=='Friday') {                    //if purchase day is friday, then all days & slots for next week is open
    echo"<option value='Next Wednesday'>Next Wednesday</option>";
    echo "<option value='Next Thursday'>Next Thursday</option>";
    echo "<option value='Next Friday'>Next Friday</option>";
}
else{
    echo"<option value='Wednesday'> Wednesday</option>"; //else, if purachase day if on any other day, upcoming wed, thursday and fri are slots are open
    echo "<option value='Thursday'>Thursday</option>";
    echo "<option value='Friday'>Friday</option>";
}
?>		
</select><br/><br/>

<label>Time:</label>
<select name="time" value="time" required>
<?php
$current_time=date("H");

//inside tuesday
if ($today=='Wednesday' ) { 
    if($current_time<13)
    {
    echo"<option value='10AM to 1PM'> 10AM to 1PM </option>";//if purchase day is wednesday and time is 12:59pm or earlier 
    echo "<option value='1PM to 4PM'>1PM to 4PM</option>";////all slots are open
    echo "<option value='4PM to 7PM'>4PM to 7PM</option>";
    }
    
    elseif ($current_time>=19) {
        echo"<option value='10AM to 1PM'> 10AM to 1PM </option>"; //if purchase day is wednesday and time is 7pm or late 
        echo "<option value='1PM to 4PM'>1PM to 4PM</option>";//all slots from friday and upcoming wed and thursday is free
        echo "<option value='4PM to 7PM'>4PM to 7PM</option>";
        }

    elseif ($dayselected=='Thursday') {
    
    if ($current_time>=13 and $current_time<16) {
    echo"<option disabled value='10AM to 1PM'> 10AM to 1PM </option>";//if purchase day is wednesday and time is between 1pm to 3pm and Collection day
    echo "<option value='1PM to 4PM'>1PM to 4PM </option>";//thursday, only the first slot is unavailable
    echo "<option value='4PM to 7PM'>4PM to 7PM</option>";
    }

    elseif ($current_time=16 and $current_time<19 ) {
    echo"<option disabled value='10AM to 1PM'> 10AM to 1PM </option>";//if purchase day is wednesday and time is between 4pm to 6pm and Collection day
    echo "<option disabled value='1PM to 4PM'>1PM to 4PM </option>";//thursday the last slot is available
    echo "<option value='4PM to 7PM'>4PM to 7PM</option>";
    }
    
    }//if selected day is thursday
    
    else{
    echo"<option value='10AM to 1PM'> 10AM to 1PM </option>"; //else all slots for any days selected is free
    echo "<option value='1PM to 4PM'>1PM to 4PM</option>";
    echo "<option value='4PM to 7PM'>4PM to 7PM</option>";
    }  
    }

//inside wednesday
elseif ($today=='Thursday') {
    if($current_time<13)
    {
    echo"<option value='10AM to 1PM'> 10AM to 1PM </option>"; //if purchase day is thursday and time is 12:59pm or earlier 
    echo "<option value='1PM to 4PM'>1PM to 4PM</option>";//all slots are open
    echo "<option value='4PM to 7PM'>4PM to 7PM</option>";
    }
    
    elseif ($current_time>=19) {
        echo"<option value='10AM to 1PM'> 10AM to 1PM </option>"; //if purchase day is thursday and time is 7pm or late 
        echo "<option value='1PM to 4PM'>1PM to 4PM</option>";//all slots for next days are open
        echo "<option value='4PM to 7PM'>4PM to 7PM</option>";
    }

    elseif ($dayselected=='Friday') {
    if (($current_time>=13 and $current_time<16) ) {
    echo"<option disabled value='10AM to 1PM'> 10AM to 1PM </option>"; //if purchase day is thursday and time is between 1pm to 3pm and Collection day
    echo "<option value='1PM to 4PM'>1PM to 4PM</option>";//is friday then only the first slot is unavailable
    echo "<option value='4PM to 7PM'>4PM to 7PM</option>";
    }

    elseif (($current_time>=16 and $current_time<19) ) { 
    echo"<option disabled value='10AM to 1PM'> 10AM to 1PM </option>";//if purchase day is thursday and time is between 4pm to 6pm and Collection day
    echo "<option disabled value='1PM to 4PM'>1PM to 4PM</option>";//is friday, only the last slot is available
    echo "<option value='4PM to 7PM'>4PM to 7PM</option>";
    }
    }
    
    else{
    echo"<option value='10AM to 1PM'> 10AM to 1PM </option>"; //else all slots for any days selected is free
    echo "<option value='1PM to 4PM'>1PM to 4PM</option>";
    echo "<option value='4PM to 7PM'>4PM to 7PM</option>";
    }
    
    }//thursday

    //inside friday
    elseif ($today=='Tuesday' ) { 
        if($current_time<12) //if purchase day is tuesday and time is 12:59 am or earlier
        {
        echo"<option value='10AM to 1PM'> 10AM to 1PM </option>"; //all slots for upcoming next are open
        echo "<option value='1PM to 4PM'>1PM to 4PM</option>";
        echo "<option value='4PM to 7PM'>4PM to 7PM</option>";
        }

        elseif($current_time>=19) {//if purchase day is tuesday and time is 7pm or late 
        echo"<option value='10AM to 1PM'> 10AM to 1PM </option>"; //all slots for thurday, friday and next wednesday is open
        echo "<option value='1PM to 4PM'>1PM to 4PM</option>";
        echo "<option value='4PM to 7PM'>4PM to 7PM</option>";
        }

        elseif ($dayselected=='Wednesday'){
        if (($current_time>=13 and $current_time<16) ) {
        echo"<option disabled value='10AM to 1PM'> 10AM to 1PM </option>"; //if purchase day is tuesday and time is between 1pm to 3:59pm and 
        echo "<option value='1PM to 4PM'>1PM to 4PM</option>";////Collection day is Wednesday, the first slot is unavailable
        echo "<option value='4PM to 7PM'>4PM to 7PM</option>";
        }
        elseif (($current_time>=16 and $current_time<19) ) { 
        echo"<option disabled value='10AM to 1PM'> 10AM to 1PM </option>"; //if purchase day is tuesday and time is between 4pm to 6pm and 
        echo "<option disabled value='1PM to 4PM'>1PM to 4PM</option>";////Collection day is Wednesday,only the last slot is available
        echo "<option value='4PM to 7PM'>4PM to 7PM</option>";
        }
        }
        
        else{
        echo"<option value='10AM to 1PM'> 10AM to 1PM </option>"; //
        echo "<option value='1PM to 4PM'>1PM to 4PM</option>";
        echo "<option value='4PM to 7PM'>4PM to 7PM</option>";
        }
        }

        else
    {
    echo"<option value='10AM to 1PM'> 10AM to 1PM </option>";
    echo "<option value='1PM to 4PM'>1PM to 4PM</option>";
    echo "<option value='4PM to 7PM'>4PM to 7PM</option>";
    }

        if ($today=='Friday') { //if purchase day is friday, then all days & slots for next week is open
            echo"<option value='10AM to 1PM'> 10AM to 1PM </option>";
            echo "<option value='1PM to 4PM'>1PM to 4PM</option>";
            echo "<option value='4PM to 7PM'>4PM to 7PM</option>";
        }

?>
  </select><br/><br/>

  <p><button type="submit" class="button" name="submit" value="Submit">Submit</button>

<div class="footer">
    <p>Copyright &copy; FlavoursMart 2021</p>
    <p style="float: right;">All Right Reserved</p>
    </div>
</body>
</html>