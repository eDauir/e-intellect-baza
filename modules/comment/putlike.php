<?php
function putLike($db) {
    if(isset($_GET['authToken']) && isset($_GET['id'])) {
        $authToken = convertStr($_GET['authToken']);
        $id = convertStr($_GET['id']);

        $sql = "SELECT id FROM users WHERE accessToken = '$authToken'";
        $data = $db->getOne($sql);

        if($data != 0) {
            $sql = "INSERT INTO comment_likes (userId, commentId) VALUES ('$data', '$id')";
            $insertQuery = $db->query($sql);

            return true;
        }

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