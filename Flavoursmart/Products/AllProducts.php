<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flavours Mart</title>
  <script src="https://kit.fontawesome.com/1935d064dd.js" crossorigin="anonymous"></script>
  <script type="text\javascript" src="swipper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="../css/header.css">
  <link rel="stylesheet" href="../css/footer.css">

</head>

<body>

  <div class="topnav">
    <img class="logo" src="images/Logo.png">
    <a href="../index.php">Home</a>
    <a href="../aboutus.php">About Us</a>
    <a href="AllProducts.php">All Products</a>

    <?php
    $product_name = isset($_GET['PRODUCT_NAME']) ? $_GET['PRODUCT_NAME']: '';
    ?>

    <div class="search-container">
    <form action="Aproduct.php" method="get"> 
      <input class="form-control" type="text" name="product_name" placeholder="Search.." 
        value="<?php if(isset($_GET['PRODUCT_NAME']))
        echo $_GET['PRODUCT_NAME'] ?>"/>
      <button type="submit"><i class="fa fa-search"></i></button>
      </form>
    </div>
    <div class="icon-bar">

      <a href="cart.php"><i class="fas fa-cart-plus "></i></a>

      <div class="drop">
        <button class="btn"><a href=""> <i class="far fa-user "></i><i class="fa fa-caret-down"></i></a>
        </button>
        <div class="downdrop">
          <a href="../setting.php">Profile Setting</a>


        </div>
      </div>
      <div class="dropdown">

        <button class="dropbtn">LogIn/Register
          <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content">
          <a href="../Registration/login.php">Login</a>
          <a href="../Registration/select.php">Register</a>
          <a href="../index.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="Categories">
      <h2 style="color: #f0c60d;">Categories</h2>
      <div class="sub">
        <ul>
          <li><a href="<?php echo $product_category='Meat.php'?>">Meat</a></li>
          <li><a href="<?php echo $product_category='Fish.php'?>">Fish</a></li>
          <li><a href="<?php echo $product_category='Bakery.php'?>">Bakery</a></li>
          <li><a href="<?php echo $product_category='Delicatessen.php'?>">Delicatessen</a></li>
          <li><a href="<?php echo $product_category='Fruit.php'?>">Fruits</a></li>
          <li><a href="<?php echo $product_category='Vegetables.php'?>">Vegetables</a></li>
        </ul>
      </div>

      <form action="Shop.php" method="get">
        <div class="shopname">
          <h3 style="color: #f0c60d; margin-bottom: 35px;"> Filter by: </h3>

          <?php 
             // $counter = 0
             $checkboxProducts = array(2201=>'Fresh Veggies',2203=> 'Toro Fish Market',
              2200=>'Meat way', 
              2202=>'Cakey bakey',
              2204=> 'Devilishly delish');
             $shops =  isset($_GET['shops']) ? $_GET['shops'] : '';
             $selectedShops = $shops ? explode(',', $shops):[];
                foreach($checkboxProducts as $key => $value){
             ?>
          <label class="Shop">
            <?php $v = in_array($key, $selectedShops)?'checked': ''; ?>
            <?php echo $value; ?>
            <input type="checkbox" name="shop" value="<?php echo $key ?>" <?php echo $v ?> >
            <span class="checkmark"></span>
          </label>
          <?php 
                }
             ?>
        </div>
      </form>

    </div>


    <div class="VL"></div>

    <nav class="product-filter">
      <a href="AllProducts.php" style="color: #089E21; text-decoration:none; font-size: 45px;">All Products</a>
      <div class="searchsort">

        <?php 
             $sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : '';
         ?>

        <form action="" method="get">

          <div class="collection-sort">
            <label style="color:  #EFB126 ">Sort by:</label>
            <select name="sort_by" id="sortById" class="form-control">
              <option value="" disabled selected>Default</option>
              <option value="Alphabetically" <?php if($sort_by=="Alphabetically" ) echo 'selected' ?> >Alphabetically
              </option>
              <option value="MinimumPrice" <?php if($sort_by=="MinimumPrice" ) echo 'selected' ?> >Minimun Price
              </option>
              <option value="MaximumPrice" <?php if($sort_by=="MaximumPrice" ) echo 'selected' ?> >Maximum Price
              </option>
            </select>
          </div>
        </form>
      </div>
    </nav>
    <?php        
            include 'connection.php';
            $fields = array('product_category', 'product_name','shop_name');
            $conditions = array();
            foreach($fields as $field){
                // if the field is set and not empty
                if(isset($_GET[$field]) && $_GET[$field] != '') {
                    // create a new condition while escaping the value inputed by the user (SQL Injection)
                    $conditions[] = "`$field` LIKE '%" . $_GET[$field] . "%'";
                }
            }
            //$query="SELECT * FROM( SELECT * FROM PRODUCT ORDER BY dbms_random.value) WHERE rownum <=12"; 
            // $query=" SELECT * FROM PRODUCT P INNER JOIN SHOP S ON P.SHOP_ID = S.SHOP_ID"; 
            $query=" SELECT * FROM PRODUCT P "; 

            if(count($conditions) > 0) {
                // append the conditions
                $query .= "WHERE " . implode (' AND ', $conditions); // you can change to 'OR', but I suggest to apply the filters cumulative
            }
            
            if(count($selectedShops)){
              $shopsConditions = array();
              foreach($selectedShops as $s){
                  $shopsConditions[] = "P.SHOP_ID =".$s;
              }
                $query .= "WHERE " . implode (' OR ', $shopsConditions);
            }
            $orderby = '';
            if($sort_by=='Alphabetically'){
              $orderby = 'order by P.PRODUCT_NAME ASC ';
            }else if($sort_by== 'MinimumPrice') {
                $orderby = ' order by P.PRODUCT_PRICE ASC ';
            }
            else if($sort_by== 'MaximumPrice'){
              $orderby = 'order by P.PRODUCT_PRICE DESC ';
            }
            
            if($orderby){
                $query = $query." ".$orderby;
            }
            //echo $query;
            // echo $query;
            $query = oci_parse($connection,$query );
            oci_execute($query);
         
            //Use a while loop to iterate through your $query array and display

            echo '<div class ="product">';
            while($row = oci_fetch_assoc($query)){    

            echo '<div class = "productcard">';
            echo '<a href="Aproduct.php?id='.$row['PRODUCT_ID'].' "><img src="images/'.$row['PRODUCT_IMAGE'].' "style="width: 200px; overflow: hidden">';
            echo '<h4>'. $row['PRODUCT_NAME'].'</h4>'.'</a>';
            echo '<p>NRs  '.$row['PRODUCT_PRICE'].'</p>';
            echo ' 
            <br><br />
            <a href="addcart.php?id='.$row['PRODUCT_ID'].' " class="btn" style= "color: #089E21;background-color: #97BC62FF; padding: 5px; margin-bottom:10px;">
            Add to Cart</a>';
            echo'</div>';     
            }
            echo'</div>';

            echo '<br/>'.'<br/>';

          ?>
    <?php
            $query="SELECT * FROM( SELECT * FROM PRODUCT  ORDER BY dbms_random.value) WHERE rownum <=7"; 
            // $query = oci_parse($connection,$query. $orderby);
            $query = oci_parse($connection,$query);
            oci_execute($query);
            echo '<div class ="productslider">';
            echo '<img id="slide-left" class="arrow" src="images/arrow-left.png">'; 
            while($row = oci_fetch_assoc($query)){    
            echo '<section class="productcontainer" id="slider">';       
            echo '<div class = "productcard">';
            echo '<a href="Aproduct.php?id='.$row['PRODUCT_ID'].' "><img src="images/'.$row['PRODUCT_IMAGE'].' " style="width: 200px; overflow: hidden"/>'.'<br>';
            
            echo '<h4>'. $row['PRODUCT_NAME'].'</h4>'.'</a>';
            echo '<p>NRs  '.$row['PRODUCT_PRICE'].'</p>';
           
            echo ' 
          <br><br/>
            <a href="cart.php'.$row['PRODUCT_ID'].' ?>" class="btn" style= "color: #089E21;background-color: #97BC62FF;
    padding: 5px; margin-bottom: 10px;">
    Add to Cart</a>';
    echo'
  </div>';
  echo '</section>';
  }
  echo '<img id="slide-right" class="arrow" src="images/arrow-right.png">';
  echo'</div>';

  echo '<br>'.'<br>';

  ?>

  </div>
  <script src="script.js"></script>
</body>
<script type="text/javascript">

  $('#sortById').on('change', function (e) {
    var optionSelected = $("option:selected", this);
    var valueSelected = this.value;
    let path = "AllProducts.php?sort_by=" + valueSelected;
    console.log(path)
    $.ajax({
      type: "GET",
      url: path,
      success: function (data) {
        window.location.href = path;
        // location.reload() 
      }
    });
  });
  var checked = $("input[type=checkbox]:checked").length;
  console.log(checked)
  $('input[type=checkbox]').on('change', function (e) {
    console.log(this.value)
    let checkboxVal = this.value;
    const urlParams = new URLSearchParams(window.location.search);
    const myParam = urlParams.get('shops');
    let checkedValues = myParam ? myParam.split(',') : [];
    if (checkedValues.includes(checkboxVal)) {
      checkedValues = checkedValues.filter(function (item) {
        return item !== checkboxVal
      })
    } else {
      checkedValues.push(checkboxVal)
    }
    let values = checkedValues.join()
    console.log(myParam, checkedValues, values)
    let path = "AllProducts.php?shops=" + values;
    $.ajax({
      type: "GET",
      url: path,
      success: function (data) {
        window.location.href = path;
        // location.reload() 
      }
    });
  });
</script>
<script type="text/javascript" src="script.js"></script>

<footer>
  <div class="main-content">
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