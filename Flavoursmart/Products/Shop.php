<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <script src="https://kit.fontawesome.com/1935d064dd.js" crossorigin="anonymous"></script>
    <script type="text\javascript" src="swipper.min.js" ></script>
    
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="swipper.min.css">
   
    
</head>
<body>
  <div class = "container">
  <div class= "Categories">
  <h2 style= "color: #f0c60d;">Categories</h2>
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
            <h3 style= "color: #f0c60d; margin-bottom: 35px;"> Filter by: </h3>
            <label class="Shop">Fresh Groccer
              <input type="checkbox" name= "shop" value="1" >
              <span class="checkmark"></span>
            </label>
            
            <label class="Shop">Toro Fish Market
              <input type="checkbox" name= "shop" value="2" >
              <span class="checkmark"></span>
            </label>
            
            <label class="Shop">Meat way
              <input type="checkbox" name= "shop" value="3">
              <span class="checkmark"></span>
            </label>
            
            <label class="Shop">Cakey bakey
              <input type="checkbox" name= "shop" value="4">
              <span class="checkmark"></span>
            </label>

            <label class="Shop">Devilishly delish
              <input type="checkbox" name= "shop" value="5">
              <span class="checkmark" ></span>
            </label>
          </div>  
          </form>
<?php ?>
       </div>

             
<div class="VL" style ="height: 600px;"></div>
 
     <nav class="product-filter">
     <a href="AllProducts.php" style="color: #089E21; text-decoration:none; font-size: 45px; ">All Products</a>
         <div class="searchsort">

         <?php 
             $product_name = isset($_GET['product_name']) ? $_GET['product_name']: '';
             $product_category = isset($_GET['product_category']) ? $_GET['product_category'] : '';
             $shop_name = isset($_GET['shop_name']) ? $_GET['shop_name']: '';
             $search_by = isset($_GET['search_by']) ? $_GET['search_by'] : '';
             $sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : '';
         ?>
        
        <form action="All Products.php" method="get">

        <div class = "collection-sort">
        <input class="form-control" type="text" name="PRODUCT_NAME" placeholder="Product Name" 
         value="<?php if(isset($_GET['PRODUCT_NAME']))
         echo $_GET['PRODUCT_NAME'] ?>"/>
        </div>

        <div class = "collection-sort">
        <select name="Product_Category" class="form-control">
          <option value="" disabled selected>Product Category</option>
          <option value="Vegetables" <?php if($product_category=="Vegetables") echo 'selected'?> >Vegetables</option>
          <option value="Fruit" <?php if($product_category=="Fruit") echo 'selected'?> >Fruit</option>
          <option value="Fish" <?php if($product_category=="Fish") echo 'selected'?>>Fish</option>
          <option value="Meat" <?php if($product_category=="Meat") echo 'selected'?>>Meat</option>
          <option value="Bakery" <?php if($product_category=="Bakery") echo 'selected'?>>Bakery</option>
          <option value="Delicatessen" <?php if($product_category=="Delicatessen") echo 'selected'?>>Delicatessen</option>
        </select>
        </div>

        <div class = "collection-sort">
        <select name="Shop_Name" class="form-control">
          <option value="" disabled selected>Shop</option>
          <option value="Fresh Groccer" <?php if($shop_name=="Fresh Groccer") echo 'selected'?> >Fresh Groccer</option>
          <option value="Toro Fish Market" <?php if($shop_name=="Toro Fish Market") echo 'selected'?>>Toro Fish Market</option>
          <option value="Meat way" <?php if($shop_name=="Meat way") echo 'selected'?>>Meat Way</option>
          <option value="Cakey bakey" <?php if($shop_name=="Cakey bakey") echo 'selected'?>>Cakey bakey</option>
          <option value="Devilishly delish" <?php if($shop_name=="Devilishly delish") echo 'selected'?>>Devilishly delish</option>
        </select>
        </div>
        

        <div class="collection-sort">
        <label style= "color:  #EFB126 ">Sort by:</label>
          <select name="sort_by" class="form-control">
            <option value="" disabled selected>Default</option>
            <option value="Name"  <?php if($sort_by=="Alphabetically") echo 'selected'?> >Alphabetically</option>
            <option value="Minimum Price" <?php if($sort_by=="Minimun Price") echo 'selected'?> >Minimun Price</option>
            <option value="Maximum Price" <?php if($sort_by=="Maximum Price") echo 'selected'?> >Maximum Price </option>
          </select>
        </div>
        <div class="collection-sort">
        <input class="btn btn-primary" type="submit" name="submit" value="Search" />
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
            $query="SELECT * FROM( SELECT * FROM PRODUCT ORDER BY dbms_random.value) WHERE  SHOP_NAME LIKE 'Meat way' "; 
            if(count($conditions) > 0) {
                // append the conditions
                $query .= "WHERE " . implode (' AND ', $conditions); // you can change to 'OR', but I suggest to apply the filters cumulative
            }
            $orderby = '';
            if($sort_by=='Alphabetically'){
              $order_by = 'order by product_name ASC';
            }else if($sort_by== 'Minimun Price') {
                $orderby = ' order by product_price DESC ';
            }
          
            else{
              $orderby = 'order by product_price ASC';
            }

            $query = oci_parse($connection,$query. $orderby) ;
            oci_execute($query);
         
           
           

            //Use a while loop to iterate through your $query array and display

            echo '<div class ="product">';
            while($row = oci_fetch_assoc($query)){               
            echo '<div class = "productcard">';
            echo '<a href="Aproduct.php?id='.$row['PRODUCT_ID'].' "><img src="images/'.$row['PRODUCT_IMAGE'].' "style="width: 200px; overflow: hidden">';
            echo '<h4>'. $row['PRODUCT_NAME'].'</h4>'.'</a>';
            echo '<p>NRs  '.$row['PRODUCT_PRICE'].'</p>';
            echo ' 
            <label style = "padding:3px">Quantity
            <input type="number" value ="1"></label>
            <br><br>
            <a href="" class="btn" style= "color: #089E21;background-color: #97BC62FF; padding: 5px;">Add to Cart</a> ';
            echo'</div>';     
            }
            echo'</div>';

            echo '<br>'.'<br>';
          ?>
            
        </div>
</body>
</html>