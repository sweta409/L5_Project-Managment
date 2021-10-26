<!DOCTYPE html>
<html>
<head>
    <title>flavours mart</title>
    
    <link rel="stylesheet" href="css/slider.css">
  <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        
        <meta name="viewport" content="width=device-width, initial-scale=1">
         
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"/>
        <link rel="stylesheet" href="css/product.css">
        <link rel="stylesheet" href="css/footer.css">
        <link rel="stylesheet" href="css/header.css">

          <!-- font awesome -->
        <script src="https://kit.fontawesome.com/dbed6b6114.js" crossorigin="anonymous"></script>
           
 
    </head>
        
<body style="height: 2000px;">
<?php
include 'header.php';
?>
	
    <div class="slider">
		<!-- fade css -->
		<div class="myslide fade">
			<div class="txt">
				<h1>MEAT</h1>
			</div>
			<img src="images/img1.jpg" style="width: 100%; height: 100%;">
		</div>
		
		<div class="myslide fade">
			<div class="txt">
				<h1>GREEN GROCERIES</h1>
			</div>
			<img src="images/img2.jpg" style="width: 100%; height: 100%;">
		</div>
		
		<div class="myslide fade">
			<div class="txt">
				<h1>BAKERY</h1>
			</div>
			<img src="images/img3.jpg" style="width: 100%; height: 100%;">
		</div>
		
		<div class="myslide fade">
			<div class="txt">
				<h1>DELICACY</h1>
			</div>
			<img src="images/img4.jpg" style="width: 100%; height: 100%;">
		</div>
		
		<div class="myslide fade">
			<div class="txt">
				<h1>FISH</h1>
			</div>
			<img src="images/img5.jpg" style="width: 100%; height: 100%;">
		</div>
		
		<!-- onclick js -->
		<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
  		<a class="next" onclick="plusSlides(1)">&#10095;</a>
		
		<div class="dotsbox" style="text-align:center">
			<span class="dot" onclick="currentSlide(1)"></span>
			<span class="dot" onclick="currentSlide(2)"></span>
			<span class="dot" onclick="currentSlide(3)"></span>
			<span class="dot" onclick="currentSlide(4)"></span>
			<span class="dot" onclick="currentSlide(5)"></span>
		</div>
		<!-- /onclick js -->
	</div>

<script type="text/javascript">
    const myslide = document.querySelectorAll('.myslide'),
      dot = document.querySelectorAll('.dot');
let counter = 1;
slidefun(counter);

let timer = setInterval(autoSlide, 8000);
function autoSlide() {
    counter += 1;
    slidefun(counter);
}
function plusSlides(n) {
    counter += n;
    slidefun(counter);
    resetTimer();
}
function currentSlide(n) {
    counter = n;
    slidefun(counter);
    resetTimer();
}
function resetTimer() {
    clearInterval(timer);
    timer = setInterval(autoSlide, 8000);
}

function slidefun(n) {
    
    let i;
    for(i = 0;i<myslide.length;i++){
        myslide[i].style.display = "none";
    }
    for(i = 0;i<dot.length;i++) {
        dot[i].className = dot[i].className.replace(' active', '');
    }
    if(n > myslide.length){
       counter = 1;
       }
    if(n < 1){
       counter = myslide.length;
       }
    myslide[counter - 1].style.display = "block";
    dot[counter - 1].className += " active";
}
</script>

<?php
include "connection.php";

    $query="SELECT * FROM( SELECT * FROM PRODUCT  ORDER BY dbms_random.value) WHERE rownum <=1";  
        $result = oci_parse($connection,$query);
        oci_execute($result);
        while($row = oci_fetch_assoc($result)){ ?>
        <div class = "products">
            <div class = "container">
                <h1 class = "lg-title">PRODUCTS WITH DISCOUNT</h1>
                <p class = "text-light">For Limited Time</p>

                <div class = "product-items">
                    <!-- single product -->
                    <div class = "product">
                        
                            <div class = "product-img">
                                <img src= "./Products/images/<?php echo $row['PRODUCT_IMAGE']; ?>" alt = "product image">
                            </div>
                            <div class = "product-btns">
                                <button type = "button" class = "btn-cart"> add to cart
                                    <span><i class = "fas fa-plus"></i></span>
                                </button>
                                
                            </div>
                      

                        <div class = "product-info">
                            <a href = "#" class = "product-name"><?php echo $row['PRODUCT_NAME']; ?></a>
                            <p class = "product-price"><?php echo $row['PRODUCT_PRICE']; ?></p>
                            <p class = "product-price"><?php echo $row['PRODUCT_PRICE']; ?></p>
                        </div>

                        <div class = "off-info">
                            <h2 class = "sm-title">25% off</h2>
                        </div>
                    </div>
                    <!-- end of single product -->
                    <!-- single product -->

                    <div class = "product">
                       
                            <div class = "product-img">
                                <img src = "images/pic2.png" alt = "product image">
                            </div>
                            <div class = "product-btns">
                                <button type = "button" class = "btn-cart"> add to cart
                                    <span><i class = "fas fa-plus"></i></span>
                                </button>
                            </div>
                        

                        <div class = "product-info">
                            <a href = "#" class = "product-name">fuji apple, 10pcs</a>
                            <p class = "product-price">Rs1500.00</p>
                            <p class = "product-price">Rs1200.00</p>
                        </div>
                        <div class = "off-info">
                            <h2 class = "sm-title">20% off</h2>
                        </div>
                    </div>
                    <!-- end of single product -->
                    <!-- single product -->
                    <div class = "product list">
                        
                            <div class = "product-img">
                                <img src = "images/pic3.png" alt = "product image">
                            </div>
                            <div class = "product-btns">
                                <button type = "button" class = "btn-cart"> add to cart
                                    <span><i class = "fas fa-plus"></i></span>
                                </button>
                            </div>
                       

                        <div class = "product-info">
                            <a href = "#" class = "product-name">tomato, per kg</a>
                            <p class = "product-price">Rs350.00</p>
                            <p class = "product-price">Rs245.00</p>
                        </div>
                        <div class = "off-info">
                            <h2 class = "sm-title">30% off</h2>
                        </div>
                    </div>
                    <!-- end of single product -->
                    <!-- single product -->
                    <div class = "product">
                            <div class = "product-img">
                                <img src = "images/pic4.png" alt = "product image">
                            </div>
                            <div class = "product-btns">
                                <button type = "button" class = "btn-cart"> add to cart
                                    <span><i class = "fas fa-plus"></i></span>
                                </button>
                            </div>
                       
                        <div class = "product-info">
                            <a href = "#" class = "product-name">sardines, per kg</a>
                            <p class = "product-price">Rs1300.00</p>
                            <p class = "product-price">Rs1170.00</p>
                        </div>

                        <div class = "off-info">
                            <h2 class = "sm-title">10% off</h2>
                        </div>
                    </div>
                    <!-- end of single product -->
                    <!-- single product -->
                </div>
                <?php
        }
                ?>

                
        
             <h1 class = "lg-title">MOSTLY SOLD PRODUCTS</h1>
                <p class = "text-light">As Per Customer Preference</p>

                    
                    <div class="slide-container">
                 <img id="slide-left" class="arrow" src="images/arrow-left.png">
                  <section class="" id="slider">

                    <!-- single product -->
                    <div class="thumbnail">
                    <div class = "product">
                        
                            <div class = "product-img2">
                                <img src = "images/pic5.png" alt = "product image">
                            </div>
                            <div class = "product-btns">
                                <button type = "button" class = "btn-cart"> add to cart
                                    <span><i class = "fas fa-plus"></i></span>
                                </button>
                            </div>
                        

                        <div class = "product-info2">
                            <a href = "#" class = "product-name"> chicken, 2pcs</a>
                            <p class = "product-price2">Rs1800.00</p>
                          
                        </div>
                    </div>
                </div>
                    <!-- end of single product -->
                    <!-- single product -->

                    <div class="thumbnail">
                        <div class = "product">
                      
                            <div class = "product-img2">
                                <img src = "images/pic6.png" alt = "product image">
                            </div>
                            <div class = "product-btns">
                                <button type = "button" class = "btn-cart"> add to cart
                                    <span><i class = "fas fa-plus"></i></span>
                                </button>
                            </div>
                       

                        <div class = "product-info2">
                            <a href = "#" class = "product-name">onion, per kg  </a>
                            <p class = "product-price2">Rs300.00</p>
                           
                        </div>
                    </div>
                </div>
                    <!-- end of single product -->
                    <!-- single product -->

                    <div class="thumbnail">
                        <div class = "product">
                        
                            <div class = "product-img2">
                                <img src = "images/pic7.png" alt = "product image">
                            </div>
                            <div class = "product-btns">
                                <button type = "button" class = "btn-cart"> add to cart
                                    <span><i class = "fas fa-plus"></i></span>
                                </button>
                            </div>
                       
                        <div class = "product-info2">
                            <a href = "#" class = "product-name">pork breast, per kg</a>
                            <p class = "product-price2">Rs1300.00</p>
                            
                        </div>
                    </div>
                </div>
                    <!-- end of single product -->
                    <!-- single product -->

                    <div class="thumbnail">
                        <div class = "product">
                       
                            <div class = "product-img2">
                                <img src = "images/pic8.png" alt = "product image">
                            </div>
                            <div class = "product-btns">
                                <button type = "button" class = "btn-cart"> add to cart
                                    <span><i class = "fas fa-plus"></i></span>
                                </button>
                            </div>
                    

                        <div class = "product-info2">
                            <a href = "#" class = "product-name">green chilli, per kg</a>
                            <p class = "product-price2">Rs200.00</p>
                           
                        </div>
                    </div>
                </div>

                <!-- end of single product -->
                    <!-- single product -->

                    <div class="thumbnail">
                        <div class = "product">
                       
                            <div class = "product-img2">
                                <img src = "images/pic9.png" alt = "product image">
                            </div>
                            <div class = "product-btns">
                                <button type = "button" class = "btn-cart"> add to cart
                                    <span><i class = "fas fa-plus"></i></span>
                                </button>
                            </div>
                      
                        <div class = "product-info2">
                            <a href = "#" class = "product-name">pineapple, per kg</a>
                            <p class = "product-price2">Rs400.00</p>
                        </div>
                    </div>
                </div>
                    <!-- end of single product -->
                    <!-- single product -->
                
                <div class="thumbnail">
                    <div class = "product">
                        
                            <div class = "product-img2">
                                <img src = "images/pic10.png" alt = "product image">
                            </div>
                            <div class = "product-btns">
                                <button type = "button" class = "btn-cart"> add to cart
                                    <span><i class = "fas fa-plus"></i></span>
                                </button>
                            </div>
                        

                        <div class = "product-info2">
                            <a href = "#" class = "product-name">blueberry cake </a>
                            <p class = "product-price2">Rs800.00</p>
                            
                        </div>
                    </div>
                </div>
     
                    <!-- end of single product -->
                    <!-- single product -->
             
        </section>
  <img id="slide-right" class="arrow" src="images/arrow-right.png">
</div>

    <script type="text/javascript">
        let thumbnails = document.getElementsByClassName('thumbnail');
let slider = document.getElementById('slider');

let buttonRight = document.getElementById('slide-right');
let buttonLeft = document.getElementById('slide-left');

buttonLeft.addEventListener('click', function(){
    slider.scrollLeft -= 125;
})

buttonRight.addEventListener('click', function(){
    slider.scrollLeft += 125;
})

const maxScrollLeft = slider.scrollWidth - slider.clientWidth;
// alert(maxScrollLeft);
// alert("Left Scroll:" + slider.scrollLeft);

//AUTO PLAY THE SLIDER 
function autoPlay() {
    if (slider.scrollLeft > (maxScrollLeft - 1)) {
        slider.scrollLeft -= maxScrollLeft;
    } else {
        slider.scrollLeft += 1;
    }
}
let play = setInterval(autoPlay, 50);

// PAUSE THE SLIDE ON HOVER
for (var i=0; i < thumbnails.length; i++){

thumbnails[i].addEventListener('mouseover', function() {
    clearInterval(play);
});

thumbnails[i].addEventListener('mouseout', function() {
    return play = setInterval(autoPlay, 50);
});
}

    </script>
</div>
</div>
</div>
<?php
include 'footer.php';
?>
</body>
</html>


