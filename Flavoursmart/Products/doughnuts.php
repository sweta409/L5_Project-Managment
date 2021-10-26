<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doughnuts</title>
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css"
         rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet"
         href="https://cdnjs.cloudflare.com/ajax/libs/fontawesome/4.7.0/css/font-awesome.min.css">
        </head>
<body>
    

    <div class="navbar">
        <img class="logo" src="Logo.png" >

        <a href="">Home</a>
        <a href="">About As</a>
        <a href="">All product</a>
        
        <div class="dropdown">
          <button class="dropbtn">Shop 
            <i class="fa fa-caret-down"></i>
          </button>
          <div class="dropdown-content">
            <a href="#">Link 1</a>
            <a href="#">Link 2</a>
            <a href="#">Link 3</a>

          </div>
          
          </div>
          <div class="search-container">
            
              <input type="text" placeholder="Search.." name="search">
              <button type="submit"><i class="fa fa-search"></i></button>  
          </div>
          
          <div class="icon-bar">
     
            <a href=""><i class="fas fa-cart-plus "></i></a>            
              <a href=""> <i class="far fa-user "></i><i class="fa fa-caret-down"></i></a>
              <a href="#" class="px-2">LogIn/Register</a>
            </div>
        
        </div> 

          <?php

          include 'connection.php';
          if (isset($_GET['id'])){ 
          $product_id=$_GET['id'];
          $query=oci_parse($connection,"SELECT * FROM PRODUCT WHERE PRODUCT_ID = '$product_id' ");
          oci_execute($query);
          $row = oci_fetch_assoc($query);

          $sid= $row['SHOP_ID'];
          $query1=oci_parse($connection,"SELECT SHOP_NAME FROM SHOP WHERE SHOP_ID = '$sid' ");
          oci_execute($query1);
          $row1=oci_fetch_assoc($query1);

          $query2=oci_parse($connection,"SELECT * FROM DISCOUNT WHERE PRODUCT_ID = '$product_id' ");
          oci_execute($query2);
          $row2=oci_fetch_assoc($query2);
          
 
   
        ?> 
        <div class="product-info">
        <div class= "Aproduct">
          <div class= "image">
            <img src="images/<?php echo $row['PRODUCT_IMAGE'] ?> " style="width:300px ; height: 200px " >
          </div>
          <div class= "description">
         <h5><b><?php echo $row['PRODUCT_ID'];?> -
           <?php echo $row['PRODUCT_NAME'];?>-
           <?php echo $row['PRODUCT_CATEGORY'];?></b><h5\>
          <h6> <?php echo $row1['SHOP_NAME'];?><h6\>
          <h6>
            <?php
            if ($row['PRODUCT_STOCK_STATUS'] >0 ){
              echo 'Available  '. $row['PRODUCT_STOCK_STATUS'];
            }
            else{
              echo 'Out of Stock';
            }

      ?><h6\>
          <div class="rating" role="optgroup">
          <!-- in Rails just use 1.upto(5) -->
          <i class="fa fa-star-o fa rating-star" id="rating-1" data-rating="1" tabindex="0" aria-label="Rate as one out of 5 stars" role="radio"></i>
          <i class="fa fa-star-o fa rating-star" id="rating-2" data-rating="2" tabindex="0" aria-label="Rate as two out of 5 stars" role="radio"></i>
          <i class="fa fa-star-o fa rating-star" id="rating-3" data-rating="3" tabindex="0" aria-label="Rate as three out of 5 stars" role="radio"></i>
          <i class="fa fa-star-o fa rating-star" id="rating-4" data-rating="4" tabindex="0" aria-label="Rate as four out of 5 stars" role="radio"></i>
          <i class="fa fa-star-o fa rating-star" id="rating-5" data-rating="5" tabindex="0" aria-label="Rate as five out of 5 stars" role="radio"></i>
       
        <div class="Line">
          <a href="">No of Ratings</a></div>
          <div class="Line">
          <p><button style="height: fit-content; padding: 5px; margin-bottom: -90%;">Write a review</button></p>
          </div>
           </div>  
    
        <div class="desc">
          <hr>
          <p><?php echo $row['PRODUCT_DESCRIPTION'];?></p>
        </div>
        <div class="desc">
          <b style="margin-top: -15px">Allergy Info:<?php echo $row['PRODUCT_ALLERGY'];?></b>
        </div>

       </div>
          <div class="price">
           
           <h6>List price : NRs <?php echo $row['PRODUCT_PRICE'];?><h6\>
             <?php
                $row2['DISCOUNT_CODE'] > 0
                ?>
                <h6>Discount : NRs <?php echo $row2['DISCOUNT_AMOUNT'];?></h6>
                <h6>Total amount : NRs <?php echo $row['PRODUCT_PRICE'] - $row2['DISCOUNT_AMOUNT'];?><h6\>
             
             <hr>

              <form action="/cart.php">
              <label for="quantity">Quantity :</label>
              <input type="number" id="quantity" name="quantity" min="1" max="20">
              
               <p style="text-align: center;"><button style="height: fit-content; margin-top: 12px ;">Add to Cart</button></p>
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
              echo '<a href="doughnuts.php?id='.$row['PRODUCT_ID'].'"><img src="images/'.$row['PRODUCT_IMAGE'].'"alt="img can\'t load" style="width: 250px; height:150px" > ';
              echo"<h5>".$row['PRODUCT_NAME']."</h5>";
            
                echo' <div class="rating" role="optgroup">
                    <!-- in Rails just use 1.upto(5) -->
                    <i class="fa fa-star-o fa rating-star" id="rating-1" data-rating="1" tabindex="0" aria-label="Rate as one out of 5 stars" role="radio"></i>
                    <i class="fa fa-star-o fa rating-star" id="rating-2" data-rating="2" tabindex="0" aria-label="Rate as two out of 5 stars" role="radio"></i>
                    <i class="fa fa-star-o fa rating-star" id="rating-3" data-rating="3" tabindex="0" aria-label="Rate as three out of 5 stars" role="radio"></i>
                    <i class="fa fa-star-o fa rating-star" id="rating-4" data-rating="4" tabindex="0" aria-label="Rate as four out of 5 stars" role="radio"></i>
                    <i class="fa fa-star-o fa rating-star" id="rating-5" data-rating="5" tabindex="0" aria-label="Rate as five out of 5 stars" role="radio"></i>
                  </div>';  
               echo '<h6>'.'NRs.'. $row['PRODUCT_PRICE'].'</h6>'.'</a>';
            }
          ?>
          </div>
      </div>
        
       <hr style= "margin-top: 35% ; margin-left: 5%; margin-right: 5%; color: black;">

       <div class="customer">
          <div class="customer_reviews"><p style="font-size: 22px;">Customer reviews</p>
             <div class="rating" role="optgroup">
                <!-- in Rails just use 1.upto(5) -->
                <i class="fa fa-star-o fa rating-star" id="rating-1" data-rating="1" tabindex="0" aria-label="Rate as one out of 5 stars" role="radio"></i>
                <i class="fa fa-star-o fa rating-star" id="rating-2" data-rating="2" tabindex="0" aria-label="Rate as two out of 5 stars" role="radio"></i>
                <i class="fa fa-star-o fa rating-star" id="rating-3" data-rating="3" tabindex="0" aria-label="Rate as three out of 5 stars" role="radio"></i>
                <i class="fa fa-star-o fa rating-star" id="rating-4" data-rating="4" tabindex="0" aria-label="Rate as four out of 5 stars" role="radio"></i>
                <i class="fa fa-star-o fa rating-star" id="rating-5" data-rating="5" tabindex="0" aria-label="Rate as five out of 5 stars" role="radio"></i>
                <br>
                <div class="reviews">
                <a href="">No. of Ratings</a>
                <p style="text-align: left"><br><button style="height: fit-content; padding: 7px; margin-bottom: -90%;">Write a review</button></p>
             </div>
            </div> 
          </div>

          
          
          <div class= "top_reviews">
            <p style="font-size: 22px; margin-left: 25%">Top reviews</p>
           <div class="review_customer">
            <p><br><br><img src="pp.png" alt="useraccount" style="width:30px; height:30px">
             Customer name</p>
            <div class="rating" role="optgroup">
                <!-- in Rails just use 1.upto(5) -->
                <i class="fa fa-star-o fa rating-star" id="rating-1" data-rating="1" tabindex="0" aria-label="Rate as one out of 5 stars" role="radio"></i>
                <i class="fa fa-star-o fa rating-star" id="rating-2" data-rating="2" tabindex="0" aria-label="Rate as two out of 5 stars" role="radio"></i>
                <i class="fa fa-star-o fa rating-star" id="rating-3" data-rating="3" tabindex="0" aria-label="Rate as three out of 5 stars" role="radio"></i>
                <i class="fa fa-star-o fa rating-star" id="rating-4" data-rating="4" tabindex="0" aria-label="Rate as four out of 5 stars" role="radio"></i>
                <i class="fa fa-star-o fa rating-star" id="rating-5" data-rating="5" tabindex="0" aria-label="Rate as five out of 5 stars" role="radio"></i>
                </div>
                <input type="text" id="review" name="Customer Review" style="width: 120px; height:30px"><br>
           </div>

           <div class="review_customer">
            <p><br><br><img src="pp.png" alt="useraccount" style="width:30px; height:30px">
             Customer name</p>
            <div class="rating" role="optgroup">
                <!-- in Rails just use 1.upto(5) -->
                <i class="fa fa-star-o fa rating-star" id="rating-1" data-rating="1" tabindex="0" aria-label="Rate as one out of 5 stars" role="radio"></i>
                <i class="fa fa-star-o fa rating-star" id="rating-2" data-rating="2" tabindex="0" aria-label="Rate as two out of 5 stars" role="radio"></i>
                <i class="fa fa-star-o fa rating-star" id="rating-3" data-rating="3" tabindex="0" aria-label="Rate as three out of 5 stars" role="radio"></i>
                <i class="fa fa-star-o fa rating-star" id="rating-4" data-rating="4" tabindex="0" aria-label="Rate as four out of 5 stars" role="radio"></i>
                <i class="fa fa-star-o fa rating-star" id="rating-5" data-rating="5" tabindex="0" aria-label="Rate as five out of 5 stars" role="radio"></i>
                </div>
                <input type="text" id="review" name="Customer Review" style="width: 120px; height:30px"><br>
           </div>

           <div class="review_customer">
            <p><br><br><img src="pp.png" alt="useraccount" style="width:30px; height:30px">
             Customer name</p>
            <div class="rating" role="optgroup">
                <!-- in Rails just use 1.upto(5) -->
                <i class="fa fa-star-o fa rating-star" id="rating-1" data-rating="1" tabindex="0" aria-label="Rate as one out of 5 stars" role="radio"></i>
                <i class="fa fa-star-o fa rating-star" id="rating-2" data-rating="2" tabindex="0" aria-label="Rate as two out of 5 stars" role="radio"></i>
                <i class="fa fa-star-o fa rating-star" id="rating-3" data-rating="3" tabindex="0" aria-label="Rate as three out of 5 stars" role="radio"></i>
                <i class="fa fa-star-o fa rating-star" id="rating-4" data-rating="4" tabindex="0" aria-label="Rate as four out of 5 stars" role="radio"></i>
                <i class="fa fa-star-o fa rating-star" id="rating-5" data-rating="5" tabindex="0" aria-label="Rate as five out of 5 stars" role="radio"></i>
                </div>
                <input type="text" id="review" name="Customer Review" style="width: 120px; height:30px"><br>
           </div>

            <div class="review_customer">
            <p><br><br><img src="pp.png" alt="useraccount" style="width:30px; height:30px">
             Customer name</p>
            <div class="rating" role="optgroup">
                <!-- in Rails just use 1.upto(5) -->
                <i class="fa fa-star-o fa rating-star" id="rating-1" data-rating="1" tabindex="0" aria-label="Rate as one out of 5 stars" role="radio"></i>
                <i class="fa fa-star-o fa rating-star" id="rating-2" data-rating="2" tabindex="0" aria-label="Rate as two out of 5 stars" role="radio"></i>
                <i class="fa fa-star-o fa rating-star" id="rating-3" data-rating="3" tabindex="0" aria-label="Rate as three out of 5 stars" role="radio"></i>
                <i class="fa fa-star-o fa rating-star" id="rating-4" data-rating="4" tabindex="0" aria-label="Rate as four out of 5 stars" role="radio"></i>
                <i class="fa fa-star-o fa rating-star" id="rating-5" data-rating="5" tabindex="0" aria-label="Rate as five out of 5 stars" role="radio"></i>
                </div>
                <input type="text" id="review" name="Customer Review" style="width: 120px; height:30px"><br>
           </div>
        </div>


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
            .on('mouseover', function(e) {
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
            .on('click', function(e) {
              var rating = $(e.target).data('rating');
              setRating(rating);
            })
            .on('keyup', function(e){
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
</html>