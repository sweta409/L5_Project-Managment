<?php 
$connection = oci_connect('flavoursmart', 'flavoursmart', '//localhost/xe'); if (!$connection) {
   $m = oci_error();
   echo $m['message'], "\n";
   exit; 
} 
    ?>