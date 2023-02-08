<?php
function unit($db) {
    if(!empty($_GET['authToken']) && !empty($_GET['userId'])) {
        $authToken = convertStr($_GET['authToken']);
        $userId = convertStr($_GET['userId']);

        $sql = "SELECT COUNT(id) as id FROM users WHERE id = '$userId' AND editor = 0";
        $data = $db->getAll($sql);

        if(!empty($data) && $data > 0) {
            $sql = "SELECT id FROM users WHERE accessToken = '$authToken' AND editor = 3";
            $data = $db->getOne($sql);

            if($data != 0) {
                $sql = "UPDATE users SET editor = 5 WHERE id = '$userId'";
                $updateQuery = $db->query($sql);

                return true;
            }
        } 
    }

    return false;
}