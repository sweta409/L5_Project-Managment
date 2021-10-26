<?php

include 'connection.php';

$id=$_GET['id'];

$query="SELECT * FROM  PRODUCT WHERE product_id='$id'";
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

<form method="post" action="updateProduct.php">
        <fieldset class="fieldset-width">
            <legend>
                Enter Product Details
            </legend>

            <label for="name"> </label>
            <input type="hidden" name="txtId" value="<?php echo $row['PRODUCT_ID']?>" /><br /><br />

            <label for="name">Product Name: </label>
            <input type="text" name="txtname" value="<?php echo $row['PRODUCT_NAME']?>" /><br /><br />

            <label for="name">Product Category: </label>
            <input type="text" name="txtcategory" value="<?php echo $row['PRODUCT_CATEGORY']?>" /><br /><br />

            <label for="name">Product Price: </label>
            <input type="text" name="txtprice" value="<?php echo $row['PRODUCT_PRICE']?>" /><br /><br />

            <label for="name">Product Quantity: </label>
            <input type="text" name="txtquantity" value="<?php echo $row['PRODUCT_QUANTITY']?>" /><br /><br />

            <label for="price">Description: </label>
            <input type="text" name="txtdescription" value="<?php echo $row['PRODUCT_DESCRIPTION']?>" /><br /><br />

            <label for="name">Stock Availability: </label>
            <input type="text" name="txtstock" value="<?php echo $row['PRODUCT_STOCK_STATUS']?>" /><br /><br />

            <label for="name">Minimun: </label>
            <input type="text" name="txtstock" value="<?php echo $row['PRODUCT_MIN']?>" /><br /><br />

            <label for="name">Maximum: </label>
            <input type="text" name="txtstock" value="<?php echo $row['PRODUCT_MAX']?>" /><br /><br />

            <label for="image">Product Allergy: </label>
            <input type="text" name="txtimage" value="<?php echo $row['PRODUCT_ALLERGY']?>" /><br /><br />

            <label for="image">Product Image: </label>
            <input type="text" name="txtimage" value="<?php echo $row['PRODUCT_IMAGE']?>" /><br /><br />

            <button class="button" type="submit" value="Submit" name="updateProduct" >Submit</button>
            <button class="button" type="reset" value="Clear" >Clear</button>
            
        </fieldset>
    </form>
</body>
</html>



<?php

if(isset($_POST['updateProduct']))
{

    $id = $_POST['txtId'];
    $name=$_POST['txtname'];
    $category=$_POST['txtcategory'];
    $price=$_POST['txtprice'];
    $quantity=$_POST['txtquantity'];
    $description=$_POST['txtdescription'];
    $stock=$_POST['txtstock'];
    $image=$_POST['txtimage'];

    //Update query
    $query = "UPDATE PRODUCT
                SET 
                    product_id = '$id',
                    product_name = '$name',
                    product_category = '$category',
                    product_price = '$price',
                    product_quantity = '$quantity',
                    product_description = '$description',
                    product_stock_status = '$stock',
                    product_image = '$image'
                WHERE
                    product_id = '$id'
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