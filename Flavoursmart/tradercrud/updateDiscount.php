<?php

include 'connection.php';

$id=$_GET['id'];

$query="SELECT * FROM DISCOUNT WHERE discount_id='$id'";
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
                Enter Discount Details
            </legend>

            <label for="name">DISCOUNT ID: </label>
            <input type="hidden" name="txtId" value="<?php echo $row['DISCOUNT_ID']?>" /><br /><br />

            <label for="price">Discount(%): </label>
            <input type="text" name="txtper" value="<?php echo $row['DISCOUNT']?>" /><br /><br />

            <label for="image">Discount Type: </label>
            <input type="text" name="txttype" value="<?php echo $row['DISCOUNT_TYPE']?>" /><br /><br />

            <button class="button" type="submit" value="Submit" name="updateDiscount" >Submit</button>
            <button class="button" type="reset" value="Clear" >Clear</button>
            
        </fieldset>
    </form>

    <?php

if(isset($_POST['updateDiscount']))
{
    $id = $_POST['txtId'];
    $product=$_POST['txtproduct'];
    $discount=$_POST['txtper'];
    $type=$_POST['txttype'];

    //Update query

    $query = "UPDATE DISCOUNT
                SET 
                    discount_id = '$id',
                    product_name = '$product',
                    discount_percent = '$discount',
                    discount_type= '$type'
                WHERE
                    discount_id = '$id'
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


