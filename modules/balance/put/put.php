<?php
	header('Access-Control-Allow-Origin: *');

    if($_REQUEST['android'] == '1')
        if($_REQUEST['pg_result'] != '1')
            echo 'false';

    include "../../../db/safemysql.class.php";
    include "../../../functions/shortFunctions.php";

    $db = new safeMysql();

    $authToken = convertStr($_REQUEST['authToken']);
    $amount = convertStr($_REQUEST['pg_amount']);

    $sql = "SELECT id FROM users WHERE accessToken = '$authToken'";
    $userId = $db->getOne($sql);

    if(!empty($userId)) {
        $sql = "UPDATE balance SET amount = amount + $amount WHERE userId = $userId";
        $updateQuery = $db->query($sql);

        $sql = "INSERT INTO balance_history (userId, type, amount) VALUES ($userId, 1, $amount)";
        $insertQuery = $db->query($sql);

        if ($updateQuery)
            echo 'true';
        else
            echo 'false';
    }
    else
        echo 'false';