<?php
    //include connection
    include 'connection.php';
    
    //get id
    $id = $_GET['id'];
    
    //build query
    $query = "DELETE FROM PRODUCT WHERE product_id= '$id' ";
    $result=oci_parse($connection,$query);
    //run and return to the main page
    oci_execute($result);

    // check to see if any rows were affected    
    if (oci_num_rows($result) > 0) {
        ?>
    <script type="text/javascript">
    alert("Deleted  Successfully.");
    window.location = "trader.php";
     </script>
     <?php
}
       else
        {
        // print error message
        echo "Error in query: $query. " . oci_error($result);
        exit ;
       }
       

?>