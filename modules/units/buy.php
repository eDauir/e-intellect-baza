<?php
	header('Access-Control-Allow-Origin: *');

    if($_REQUEST['ios'] != 'true')
        if($_REQUEST['pg_result'] != '1')
            return false;

    include "../../db/safemysql.class.php";
    include "../../functions/shortFunctions.php";

    $db = new safeMysql();

    $authToken = convertStr($_REQUEST['authToken']);
    $amount = convertStr($_REQUEST['pg_amount']);
    $unit = convertStr($_REQUEST['unit']);

    $sql = "SELECT id FROM users WHERE accessToken = '$authToken'";
    $userId = $db->getOne($sql);

    if(empty($userId)) {
        echo 'invalid token';
        return false;
    }

    $sql = "SELECT SUM(amount) as sum FROM units";
    $unitSum = $db->getOne($sql);

    if($unitSum + $unit > 1000) {
        echo 'units sum dont be > 1000';

        if($_REQUEST['ios'] != 'true') {
            $sql = "UPDATE balance SET amount = amount + $amount WHERE userId = '$userId'";
            $updateQuery = $db->query($sql);
        }

        return false;
    }

    if($_REQUEST['ios'] == 'true') {
        $sql = "SELECT amount FROM balance WHERE userId = '$userId'";
        $currentMoney = $db->getOne($sql);

        if($currentMoney > $amount) {
            $sql = "UPDATE balance SET amount = amount - $amount WHERE userId = '$userId'";
            $updateQuery = $db->query($sql);
        } 
        return false;
    }
 
    $sql = "SELECT id FROM units WHERE userId = '$userId'";
    $data = $db->getOne($sql);

    if($data == 0) {
        $sql = "INSERT INTO units (userId, amount) VALUES ('$userId', '$unit')";
        $db->query($sql);

        $sql = "UPDATE users SET editor = 5 WHERE id = '$userId'";
        $db->query($sql);
    } else {
        $sql = "UPDATE units SET amount = amount + $unit WHERE userId = '$userId'";
        $db->query($sql);
    }

    $sql = "INSERT INTO balance_history (userId, type, amount) VALUES ($userId, 7, $amount)";
    $db->query($sql);        

    echo 'true';
