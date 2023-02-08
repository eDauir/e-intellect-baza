<?php
function put($db) {
    if(isset($_GET['authToken']) && isset($_GET['productId'])) {
        $authToken = convertStr($_GET['authToken']);
        $productId = convertStr($_GET['productId']);

        $sql = "SELECT id FROM users WHERE accessToken = '$authToken' LIMIT 1";
        $data = $db->getOne($sql);

        if($data != 0) {
            $sqlCheck = "SELECT id FROM likes WHERE productId = '$productId' AND userId = '$data'";
            $dataCheck = $db->getOne($sqlCheck);

            if($dataCheck == 0) {
                $sql = "INSERT INTO likes (userId, productId) VALUES ('$data', '$productId')";
                $insertQuery = $db->query($sql);

                return $insertQuery;
            }

            return false;
        }

        return false;
    }

    return false;
}