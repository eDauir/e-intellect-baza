<?php
    header("Access-Control-Allow-Origin: *");

    if($_REQUEST['pg_result'] == '1') {

        if(!empty($_REQUEST['pg_payment_id']) && !empty($_REQUEST['pg_order_id'])) {

            include "../../db/safemysql.class.php";
            include "../../functions/shortFunctions.php";
        
            $db = new safeMysql();

            $paymentId = convertStr($_REQUEST['pg_payment_id']);
            $orderId = convertStr($_REQUEST['pg_order_id']);
    
            $sql = "UPDATE buyRates SET active = 1, activeDate = now() WHERE paymentId = '$paymentId' AND orderId = '$orderId' AND active = 0";
            $updateQuery = $db->query($sql);
    
            if ($updateQuery)
                return true;
    
            return false;
        }
    
        return false;
    }
    elseif($_REQUEST['pg_result'] == '0') {

        if(!empty($_REQUEST['pg_payment_id']) && !empty($_REQUEST['pg_order_id'])) {

            include "../../db/safemysql.class.php";
            include "../../functions/shortFunctions.php";
        
            $db = new safeMysql();

            $paymentId = convertStr($_REQUEST['pg_payment_id']);
            $orderId = convertStr($_REQUEST['pg_order_id']);

            $sql = "DELETE FROM buyRates WHERE paymentId = '$paymentId' AND orderId = '$orderId' AND active = 0'";
            $deleteQuery = $db->query($sql);
    
            if ($deleteQuery)
                return true;
    
            return false;
        }

    }

    return false;