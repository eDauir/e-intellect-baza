<?php
function getList($db) {
    if(isset($_GET['authToken'])) {
        $authToken = convertStr($_GET['authToken']);

        $sql = "SELECT productId FROM likes WHERE userId = (SELECT id FROM users WHERE accessToken = '$authToken')";

        $data = $db->getAll($sql);

        return $data;
    }
}