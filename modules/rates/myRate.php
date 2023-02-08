<?php
function myRates($db) {

    if(!empty($_GET['authToken'])) {
        $authToken = convertStr($_GET['authToken']);

        $sql = "SELECT buyRates.*, rates.day FROM buyRates INNER JOIN rates ON rates.id = buyRates.rateId WHERE buyRates.userId = (SELECT id FROM users WHERE accessToken = '$authToken')";
        $data = $db->getAll($sql);

        return $data;
    } 
}