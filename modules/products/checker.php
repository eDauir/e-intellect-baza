<?php
function checker($db) {
    $authToken = convertStr($_GET['authToken']);

    $sql = "SELECT id FROM users WHERE accessToken = '$authToken' AND editor = 3";
    return $db->getOne($sql);
}