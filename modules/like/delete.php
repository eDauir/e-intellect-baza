<?php
function delete($db) {
    if(isset($_GET['authToken']) && isset($_GET['productId'])) {
        $authToken = convertStr($_GET['authToken']);
        $productId = convertStr($_GET['productId']);

        $sql = "SELECT id FROM users WHERE accessToken = '$authToken'";
        $data = $db->getOne($sql);

        if($data != 0) {
            $sql = "DELETE FROM likes WHERE userId = $data AND productId = $productId";
            $insertQuery = $db->query($sql);
        }
    }
}