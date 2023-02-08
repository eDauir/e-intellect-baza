<?php
function put($db) {
    if(isset($_GET['authToken']) && isset($_GET['productId']) && isset($_GET['text'])  && isset($_GET['rating'])) {
        $authToken = convertStr($_GET['authToken']);
        $productId = convertStr($_GET['productId']);
        $text = convertStr($_GET['text']);
        $rating = convertStr($_GET['rating']);

        $sql = "SELECT id FROM users WHERE accessToken = '$authToken'";
        $data = $db->getOne($sql);

        if($data != 0) {
            $sql = "INSERT INTO comments (userId, productId, text, rating) VALUES ('$data', '$productId', '$text', '$rating')";
            $insertQuery = $db->query($sql);

            return true;
        }
    }

    return false;
}