
<?php
$id=$_GET['id'];

setcookie("cart[$id]", null, -1, "/");

header('Location:cart.php?success='. urlencode('Product removed from favourites!'));

?>
