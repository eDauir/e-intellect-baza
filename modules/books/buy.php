<?php
	header('Access-Control-Allow-Origin: *');

    if($_REQUEST['ios'] != 'true')
        if($_REQUEST['pg_result'] != '1')
            return false;

    include "../../db/safemysql.class.php";
    include "../../functions/shortFunctions.php";

    $db = new safeMysql();

    $authToken = convertStr($_REQUEST['authToken']);
    $bookId = convertStr($_REQUEST['productId']);
    $amount = convertStr($_REQUEST['pg_amount']);

    $sql = "SELECT id FROM users WHERE accessToken = '$authToken'";
    $userId = $db->getOne($sql);
 
    $sql = "SELECT id FROM orderBook WHERE bookId = '$bookId' AND userId = '$userId'";
    $data = $db->getOne($sql);

    if($data == 0) {

        if($_REQUEST['isPartner'] == true) {
            if(!empty($userId)) {
            
                    $sql = "INSERT INTO orderBook (userId, bookId) VALUES ('$userId', '$bookId')";
                    $insertQuery = $db->query($sql);
                    $orderId = $db->insertId();
        
        
                    if ($insertQuery)
                        echo 'partner buyed';
                    else 
                        echo 'partner dont buyed';
            }
            else 
                echo 'empty userId';
        } else {

            $sql = "SELECT amount FROM balance WHERE userId = '$userId'";
            $currentMoney = $db->getOne($sql);
        
            if($_REQUEST['ios'] != 'true') {
                    if(!empty($userId)) {
                        include "query.php";
            
                        if ($insertQuery)
                            echo 'true';
                        else 
                            echo 'false';
                }
                else 
                    echo 'false';
            } else {
                if(!empty($userId)) {
                    if($currentMoney > $amount) {
                        $sql = "UPDATE balance SET amount = amount - $amount WHERE userId = '$userId'";
                        $updateQuery = $db->query($sql);
            
                        include "query.php";
            
                        if ($insertQuery)
                            echo 'true';
                        else 
                            echo 'false';
                    }
                    else 
                        echo 'false';
                }
                else 
                    echo 'false';
            }
        

        }

    } else {
        echo 'invalid rows';
    }

