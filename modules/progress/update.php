<?php
function update($db) {
        
        if(isset($_GET['authToken']) && isset($_GET['elemId'])  && isset($_GET['productId'])) {

                $authToken = convertStr($_GET['authToken']);
                $elemId = convertStr($_GET['elemId']);
                $productId = convertStr($_GET['productId']);

                $sql = "SELECT SQL_CALC_FOUND_ROWS id FROM users WHERE accessToken = '$authToken'";
		$data = $db->getAll($sql);
		$count = count($data);

                if($count > 0) {
                        $userId = $data[0]['id'];
                        $sql = "INSERT INTO progress (lessonId, productId, userId) VALUES ('$elemId', '$productId', '$userId')";
                        $insertQuery = $db->query($sql);

                        return true;
                }
                return false;
        }

        return false;
}