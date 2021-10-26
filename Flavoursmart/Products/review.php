
<?php
include 'connection.php';
session_start();
/*if(!$_SESSION['logged_in']){
header("location: ../Registration/login.php");
}*/
?>

<!DOCTYPE html>
<html>

<head>

  <script data-require="jquery@*" data-semver="2.2.0"
    src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <link data-require="fontawesome@*" data-semver="4.5.0" rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.css" />
  <link rel="stylesheet" href="review.css" />
  <link rel="stylesheet" href="rating.css" />
  <link rel="stylesheet" href="upload.css" />
  <link rel="stylesheet" href="toggle.css" />
  <link rel="stylesheet" href="submit.css" />
  <script type="text/javascript" src="rating.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>
 
<?php



$product_id=$_GET['id'];

$query1=oci_parse($connection, "SELECT * FROM PRODUCT where PRODUCT_ID= '$product_id' ");
oci_execute($query1);
$row1=oci_fetch_assoc($query1);
?>
   
  
  <div class="container">
    <div class="container1">

      <div class="box">
        <div class="image">
          <img src= "images/<?php echo $row1['PRODUCT_IMAGE'];?>">
        </div>
      </div>
      <div class="box">
        <div class="txt">
          <p>Product Name: <?php echo $row1['PRODUCT_NAME'];?></p>
          <p>Product id : <?php echo $row1['PRODUCT_ID'];?></p>
        </div>
      </div>
</div>

<?php


if(isset($_POST['submit'])){
  $review = $_POST['review'];
  $user_id= $_SESSION['id'];


  $query = 'INSERT INTO REVIEW (review_description,product_id,user_id)'.
            'VALUES (:review,:pid,:user_id)';
  $statement = oci_parse($connection,$query);
  oci_bind_by_name($statement,':review',$review);
  oci_bind_by_name($statement,':pid',$product_id);
  oci_bind_by_name($statement,':user_id',$user_id);
 oci_execute($statement);
 header('location: AllProducts.php');
}
?>

    <div class="section">
      <div class="container2">
        <div class="row">
          <h1>Write Review</h1>
          <form action="" method="post">
          <textarea name="review" type="text" class="input" placeholder="eg.your experience, pros and cons" v-model="newItem"
            @keyup.enter="addItem()"></textarea>

        
        </div>
      </div>
    </div>
    
    <h1>Would you like to recommend this product to friend?</h1>
    <label class="switch">
      <input class="switch-input" type="checkbox" />
      <span class="switch-label" data-on="Yes" data-off="No"></span>
      <span class="switch-handle"></span>
    </label>

    <h2>
          <div class="button">
         <button type='submit' name= 'submit' style= "background-color:green">Submit</button>
         </div>
        </h2>

          </form>

  </div>
    </body>
    </html>