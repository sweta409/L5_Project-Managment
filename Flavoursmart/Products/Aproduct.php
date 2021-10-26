<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flavours Mart</title>
  <link rel="stylesheet" href="style2.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
  <link rel="stylesheet" href="../css/header.css">
  <link rel="stylesheet" href="../css/footer.css">
  <script src="https://kit.fontawesome.com/dbed6b6114.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>

<body>

  <div class="topnav">
    <img class="logo" src="images/Logo.png">
    <a href="../index.php">Home</a>
    <a href="../aboutus.php">About Us</a>
    <a href="../Products/AllProducts.php">All Products</a>

    <div class="search-container">
    <form action="Aproduct.php" method="get">
      <input type="text" placeholder="Search.." name="search">
      <button type="submit"><i class="fa fa-search"></i></button>
      </form>
    </div>
    <div class="icon-bar">

      <a href="../Registration/login.php"><i class="fas fa-cart-plus "></i></a>

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
           <a href="../logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <?php
     session_start();
  

          include 'connection.php';
          if (isset($_GET['id'])){ 
          $product_id=$_GET['id'];
          $query=oci_parse($connection,"SELECT * FROM PRODUCT WHERE PRODUCT_ID = '$product_id' ");
          oci_execute($query);
          $row = oci_fetch_assoc($query);
          
         

          $query2=oci_parse($connection,"SELECT * FROM DISCOUNT WHERE PRODUCT_ID = '$product_id' ");
          oci_execute($query2);
          $row2=oci_fetch_assoc($query2);

          $query3=oci_parse($connection,"SELECT * FROM DISCOUNT ");
          oci_execute($query3);
          $row3=oci_fetch_assoc($query3);
          $amount = ($row3['DISCOUNT'] * $row['PRODUCT_PRICE'])/100;
   
        ?>
  <div class="product-info">
    <div class="Aproduct">
      <div class="image">
        <img src="images/<?php echo $row['PRODUCT_IMAGE'] ?> " style="width:300px ; height: 200px ">
      </div>
      <div class="description">
        <h5><b>
            <?php echo $row['PRODUCT_ID'];?> -
            <?php echo $row['PRODUCT_NAME'];?>-
            <?php echo $row['PRODUCT_CATEGORY'];?>
          </b>
          <h5\>
            <h6>
              <h6\>
                <h6>
                  <?php
            if ($row['PRODUCT_STOCK_STATUS'] >0 ){
              echo 'Available  '. $row['PRODUCT_STOCK_STATUS'];
            }
            else{
              echo 'Out of Stock';
            }

      ?>
                  <h6\>
                    <div class="rating" role="optgroup">
                      <!-- in Rails just use 1.upto(5) -->
                      <i class="fa fa-star-o fa rating-star" id="rating-1" data-rating="1" tabindex="0"
                        aria-label="Rate as one out of 5 stars" role="radio"></i>
                      <i class="fa fa-star-o fa rating-star" id="rating-2" data-rating="2" tabindex="0"
                        aria-label="Rate as two out of 5 stars" role="radio"></i>
                      <i class="fa fa-star-o fa rating-star" id="rating-3" data-rating="3" tabindex="0"
                        aria-label="Rate as three out of 5 stars" role="radio"></i>
                      <i class="fa fa-star-o fa rating-star" id="rating-4" data-rating="4" tabindex="0"
                        aria-label="Rate as four out of 5 stars" role="radio"></i>
                      <i class="fa fa-star-o fa rating-star" id="rating-5" data-rating="5" tabindex="0"
                        aria-label="Rate as five out of 5 stars" role="radio"></i>

                      
                      <div class="Line">
                        <p><button style="height: fit-content; padding: 5px; margin-bottom: -90%;">
                            <a href="review.php?id=<?php echo $row['PRODUCT_ID']?>">Write a review</a></button></p>
                      </div>
                    </div>

                    <div class="desc">
                      <hr>
                      <p>
                        <?php echo $row['PRODUCT_DESCRIPTION'];?>
                      </p>
                    </div>
                    <div class="desc">
                      <b style="margin-top: -15px">Allergy Info:
                        <?php echo $row['PRODUCT_ALLERGY'];?>
                      </b>
                    </div>

      </div>
      <div class="price">

        <h6>List price : NRs
          <?php echo $row['PRODUCT_PRICE'];?>
          <h6\>
            <?php
                $row2['DISCOUNT_CODE'] >0;
                ?>
            <h6>Discount :
              <?php echo $row2['DISCOUNT'].'%';?>
            </h6>
            <h6>Total amount : NRs
              <?php echo $row['PRODUCT_PRICE'] - $amount;?>
              <h6\>

                <hr>

                <form action="/cart.php">
                  <label for="quantity">Quantity :</label>
                  <input type="number" id="quantity" name="quantity" min="1" max="20">

                  <p style="text-align: center;"><button
                      style="text-decoration: none; height: fit-content; margin-top: 12px; background-color: #EFB126; color:white">
                      <a href="addcart.php?id= <?php echo $row['PRODUCT_ID']?>">Add to Cart</a></button></p>
                </form>


      </div>
    </div>

    <?php 
           }
            ?>
    <hr style="margin-top:2%; margin-left: 5%; margin-right: 5%;"><br>
    <h4 style="margin-bottom: -40%; margin-left: 5%">Customer who bought also bought these</h4>

    <div class="recommendation">
      <div class="Customer_Choice">
        <?php
            include'connection.php'; 
            $query=oci_parse($connection,"SELECT * FROM( SELECT * FROM PRODUCT ORDER BY dbms_random.value) WHERE rownum <4"); 
            oci_execute($query);
            while ($row=oci_fetch_assoc($query)){
              echo '<a href="Aproduct.php?id='.$row['PRODUCT_ID'].'"><img src="images/'.$row['PRODUCT_IMAGE'].'"alt="img can\'t load" style="width: 250px; height:150px" > ';
              echo"<h5>".$row['PRODUCT_NAME']."</h5>";
               echo '<h6>'.'NRs.'. $row['PRODUCT_PRICE'].'</h6>'.'</a>';
            }
          ?>
      </div>
    </div>

    <hr style="margin-top: 35% ; margin-left: 5%; margin-right: 5%; color: black;">

    <?php
    include 'connection.php';
    if (isset($_GET['id'])){ 
    $product_id=$_GET['id'];
    
    $query4=oci_parse($connection,"SELECT * FROM PRODUCT WHERE PRODUCT_ID = '$product_id' ");
    oci_execute($query4);
    $row4 = oci_fetch_assoc($query4);

    $query5=oci_parse($connection,"SELECT * FROM REVIEW WHERE PRODUCT_ID = '$product_id'");
    oci_execute($query5);
    $row5 = oci_fetch_assoc($query5);
    $user1=$_SESSION['id'];

    if($row5){
    $query6=oci_parse($connection,"SELECT * FROM USERS WHERE USER_ID = $user1 ");
    oci_execute($query6);
    $row6 = oci_fetch_assoc($query6);
    }
    ?>

    <div class="customer">
      <div class="customer_reviews">
        <p style="font-size: 22px;">Customer reviews</p>
       
              <button style="padding: 7px; margin-bottom: -90%;">
              <a href="review.php?id=<?php echo $row4['PRODUCT_ID']?>">Write a review</a></button>
               
          
            </p></a>
          </div>
        </div>
      </div>



      <div class="top_reviews">
        <p style="font-size: 22px;">Top reviews</p>
        <div class="review_customer">
           <?php 
           while ($row5= oci_fetch_assoc($query5)){
             echo '<br>'.'<br>'.'<img src="pp.png" alt="useraccount" style="width:30px; height:30px">';
            echo '<p>'.$row6['USER_FULLNAME'].'<br/>'. $row5['REVIEW_DESCRIPTION'].'</p>';
           }
           ?>
          
        </div>
      </div>

<?php } ?>
    </div>
  </div>
  </div>




  <script>

    function increment() {
      document.getElementById('quantity').stepUp();
    }
    function decrement() {
      document.getElementById('quantity').stepDown();
    }

    $(document).ready(function () {

      function setRating(rating) {
        $('#rating-input').val(rating);
        // fill all the stars assigning the '.selected' class
        $('.rating-star').removeClass('fa-star-o').addClass('selected');
        // empty all the stars to the right of the mouse
        $('.rating-star#rating-' + rating + ' ~ .rating-star').removeClass('selected').addClass('fa-star-o');
      }

      $('.rating-star')
        .on('mouseover', function (e) {
          var rating = $(e.target).data('rating');
          // fill all the stars
          $('.rating-star').removeClass('fa-star-o').addClass('fa-star');
          // empty all the stars to the right of the mouse
          $('.rating-star#rating-' + rating + ' ~ .rating-star').removeClass('fa-star').addClass('fa-star-o');
        })
        .on('mouseleave', function (e) {
          // empty all the stars except those with class .selected
          $('.rating-star').removeClass('fa-star').addClass('fa-star-o');
        })
        .on('click', function (e) {
          var rating = $(e.target).data('rating');
          setRating(rating);
        })
        .on('keyup', function (e) {
          // if spacebar is pressed while selecting a star
          if (e.keyCode === 32) {
            // set rating (same as clicking on the star)
            var rating = $(e.target).data('rating');
            setRating(rating);
          }
        });
    });
  </script>
</body>
<footer>
  <div class="main-content" style="margin-top: 75%">
    <div class="left box">
      <img src="./images/Logo.png" alt="" class="img-fluid">
      <h2>CONTRACT INFO</h2>
      <ul class="contact-details">
        <li>

          <a href="#">Phone</a>
        </li>
        <li>

          <a href="#">Form</a>
        </li>
        </li>
        <li>

          <a href="#">Email</a>
        </li>
      </ul>
    </div>

    <div class="center box">
      <h2>INFORMATION</h2>
      <li>
        <a href="#">AboutUs</a>
      </li>
      <li>
        <a href="#">MoreSearch</a>
      </li>
      <li>
        <a href="#">Blog</a>
      </li>
      <li>
        <a href="#">Testimonials</a>
      </li>
      <li>
        <a href="#">Event</a>
      </li>
      </ul>
    </div>
    <div class="midle box">
      <h2>HELPFUL LINKS</h2>
      <ul>
        <li>
          <a href="#">Services</a>
        </li>
        <li>
          <a href="#">Supports</a>
        </li>
        <li>
          <a href="#">Terms & Conditions</a>
        </li>

        <li>
          <a href="#">privacy policy</a>
        </li>
      </ul>
    </div>
    <div class="right box">
      <h2>LOCATION</h2>

      <!--Footer content-->
      <section class="footer"></section>
      <!--Google Map-->
      <section>
        <iframe src="https://www.google.com/maps/d/embed?mid=1YeV-CBqH1wi1X9q1UyoHyl-5ais" width="340"
          height="200"></iframe>
      </section>
    </div>


  </div>
  <hr>
  <div class='left'> Copyright @ Company FLAVOURS MART </div>
  <div class='right'> All rights reserved </div>
</footer>

</html>