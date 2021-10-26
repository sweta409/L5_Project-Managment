<?php
    include 'connection.php'; 
    $desc = "Flavours Mart Payment"; // set to the order description to be appear on the PayPal website
    $order_no = $_POST['orderId']; // set to unique order number (retrieve previous order id from dB)
    $net_total = $_POST['total']; // set to productTotal + shipmentFee + tax
    $_SESSION["ss_last_order_no"] = $order_no;

    $url = "https://www.sandbox.paypal.com/cgi-bin/webscr"; //Test
    //$url = "https://www.paypal.com/cgi-bin/webscr"; //Live

    $pp_acc = "flavoursmart2021@gmail.com"; //PayPal account email

    $cancel_URL = "http://localhost/PM/Products/orderdetail2.php";
    //https://www.sandbox.paypal.com/businessmanage/preferences/website#

    $paypal_form =
    "<form action='$url' method='post' name='frmPayPal' id='paypal'>\n" .
    "<input type='hidden' name='business' value='$pp_acc'>\n" .
    "<input type='hidden' name='cmd' value='_xclick'>\n" .
    "<input type='hidden' name='item_name' value='$desc'>\n" .
    "<input type='hidden' name='item_number' value='$order_no'>\n" .
    "<input type='hidden' name='amount' value='$net_total'>\n" .
    "<input type='hidden' name='no_shipping' value='1'>\n" .
    "<input type='hidden' name='currency_code' value='USD'>\n" .
    "<input type='hidden' name='handling' value='0'>\n" .
    "<input type='hidden' name='cancel_return' value='$cancel_URL'>\n" .
    // "<button type='submit' name='pay_button'>Pay with PayPal</button>\n" .
    "</form>\n";

    echo ($paypal_form);

?>

<script>
    var form = document.getElementById("paypal");
    form.submit();
</script>