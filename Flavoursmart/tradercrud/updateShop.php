<?php

include 'connection.php';

$id=$_GET['id'];

$query="SELECT * FROM  SHOP WHERE shop_id='$id'";
$result=oci_parse($connection, $query);
oci_execute($result);
$row=oci_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update</title>
    <style>
fieldset {
  font-family: Helvetica;
  background-color: #5cb571;
  border-radius:20px;
  width: 350px;
  margin:0 auto;

}

legend {
  background-color: #ebc444;
  color: white;
  padding: 5px 10px;
  border-radius:20px;
  text-align:center;
}

input {
  margin: 5px;
}
button{
    background-color: #D7C322;
  border: none;
  color: white;
  padding: 10px;
  text-align:center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  border-radius: 12px;
}
</style>
</head>
<body>

<form method="post">
        <fieldset class="fieldset-width">
            <legend>
                Enter Product Details
            </legend>

            <label for="name">Shop ID: </label>
            <input type="hidden" name="txtId" value="<?php echo $row['SHOP_ID']?>" /><br /><br />

            <label for="name">Shop Name: </label>
            <input type="text" name="txtshop" value="<?php echo $row['SHOP_NAME']?>" /><br /><br />

            <label for="price">Shop Address: </label>
            <input type="text" name="txtaddress" value="<?php echo $row['SHOP_ADDRESS']?>" /><br /><br />

            <label for="image">Trader Name: </label>
            <input type="text" name="txtuser" value="<?php echo $row['TRADER_NAME']?>" /><br /><br />

            <button class="button" type="submit" value="Submit" name="updateShop" >Submit</button>
            <button class="button" type="reset" value="Clear" >Clear</button>
            
        </fieldset>
    </form>

    <?php

if(isset($_POST['updateShop']))
{
    $id = $_POST['txtId'];
    $shop_name=$_POST['txtshop'];
    $shop_address=$_POST['txtaddress'];
    $user_name=$_POST['txtuser'];

    //Update query

    $query = "UPDATE SHOP
                SET 
                    shop_id = '$id',
                    shop_name = '$shop_name',
                    shop_address = '$shop_address',
                    trader_name = '$user_name'
                WHERE
                    shop_id = '$id'
    ";

    //run query
    $re=oci_parse($connection,$query);
    oci_execute($re);
    //relocate back to main page

    ?>
    <script type="text/javascript">
    alert("Updated Successfully.");
    window.location = "trader.php";
     </script>
     <?php
}
?>
</body>
</html>