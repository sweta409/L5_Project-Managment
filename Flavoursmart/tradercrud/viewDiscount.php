<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
    {
        box-sizing: border-box;
        font-family: sans-serif;
    }

.flexbox{
    display: flex;
    padding: 10px;
    width:40%;
    margin: 0 auto;
    flex-direction: column;
    justify-content:center;
    border: 2px solid #089E21;
    background-color: white;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
}

.button3{
    display: inline;
    width: 25%;
    background: #EFB126;
    padding: 10px 0;
    text-transform: uppercase;
    text-decoration: none;
    cursor: pointer;
    margin: 8px;
    border-radius:15px;
}

.button3 a{
    text-decoration: none;
    color:black;
}
</style>
</head>
<body>
<?php
        include "connection.php";

        $id=$_SESSION['id'];
        $query="SELECT * FROM DISCOUNT WHERE user_id='$id'"; 
        $result = oci_parse($connection,$query);
        oci_execute($result);
        echo '<center><h2>Discount</h2></center>';
        while($row = oci_fetch_assoc($result)){          
            echo '<div class="flexbox">';
            echo '<hr size="1px" width="100%" color="#089E21">';
            echo '<h2>'.$row['DISCOUNT_TYPE'].'</h2>';
            echo '<p>'.$row['DISCOUNT'].'</p>';
            echo '<button class="button3">'.'<a href="deleteDiscount.php?id='. $row['DISCOUNT_CODE'].'">Delete</a>'.'</button>'.'<br />';
            echo '<br />';
            echo '</div>';
        }
?>

</body>
</html>