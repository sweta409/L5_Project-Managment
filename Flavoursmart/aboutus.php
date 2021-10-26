
<!DOCTYPE html>
<html>
<head>
	<title>flavours mart</title>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   
	  <link rel="stylesheet" href="css/aboutus.css">
        <link rel="stylesheet" href="css/ourteam.css">
         <!--font Awesome CDN-->   
  <script src="https://kit.fontawesome.com/462694daf9.js" crossorigin="anonymous"></script>
        
</head>
<body>
  <?php
  include 'header.php';
  ?>

  <div class="section">
    <div class="container">
        <h1 class = "lg-title">ABOUT US</h1>
  <p class="text">We have came up with the idea of ecommerce website to expand our customer service interms of geographical coverage as well as to step up our business. This is a new step taken and a complete new expereince to us. We will try our best to provide our customer an easy and reliable shopping experience.<span class="dots"> ...</span><span class="moreText"> Furthermore, we are looking for better co-operation and understanding with all our customers and in return, we will work on providing you all with expected range of product quality and better shopping. We have tried not to make our website more complex and keep it easy for our customers to access. THANKYOU. </span></p>
  <button class="readMoreBtn">Read More</button>
  <br />
  <br />


  <script type="text/javascript">
    const readMoreBtn = document.querySelector('.readMoreBtn');
const text = document.querySelector('.text');

readMoreBtn.addEventListener('click',(e)=>{
  text.classList.toggle('show-more');
  if(readMoreBtn.innerText === 'Read More'){
    readMoreBtn.innerText = 'Read Less';
  }else{
    readMoreBtn.innerText = 'Read More';
  }
})
  </script>
</div>
</div>

<?php
include 'footer.php';
?>
 
</body>
</html>