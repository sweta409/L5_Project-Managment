<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
    {
        box-sizing: border-box,
    }

.box{
    width: 70%;
    height: 150px;
    margin: 0 auto;
    border: 2px solid #089E21;
    background-color: white;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    padding: 10px;
}

.box h1{
    display: inline;
    color: #EFB126;
    font-size: 20px;
}

.button1{
    display: inline;
    float: right;
    width: 15%;
    background: #EFB126;
    padding: 10px 0;
    text-transform: uppercase;
    text-decoration: none;
    cursor: pointer;
    margin: 8px;
    border-radius:15px;
}

.button1 a{
    text-decoration: none;
    color:black;
}

.box h2{
    color: #333;
    font-size: 15px;
    float: left;
}

.box p{
    color: grey;
    font-size: 20px;
}

</style>
</head>
<body>
<?php
include "connection.php";

        $id=$_SESSION['id'];
        $query="SELECT * FROM SHOP WHERE user_id='$id'"; 
        $result = oci_parse($connection,$query);
        oci_execute($result);
        echo '<center><h2 style="color: green; text-decoration:underline;">Shops</h2></center>';
        while($row = oci_fetch_assoc($result)){          
        echo '<div class = "box">';
        echo '<hr size="1px" width="100%" color="#089E21">';
        echo '<h1>'.$row['SHOP_NAME'] .'</h1>';
        echo '<button class="button1">'.'<a href="deleteShop.php?id='. $row['SHOP_ID'].'">Delete</a>'.'</button>';
        echo '<button class="button1">'.'<a href="updateShop.php?id='. $row['SHOP_ID'].'">Update</a>'.'</button>'.'<br />';
        echo '<h2>'. $row['SHOP_ADDRESS'].'</h2>'.'<br />'.'<br />';
        echo '<p>Trader Name:'.$row['TRADER_NAME'].'</p>';
        echo '</div>';
        echo '<br />';
        }
?>


</body>
</html>