<?php
function updateFinish($db) {
        
        if(isset($_GET['authToken']) && isset($_GET['elemId'])  && isset($_GET['productId'])) {

                $authToken = convertStr($_GET['authToken']);
                $elemId = convertStr($_GET['elemId']);
                $productId = convertStr($_GET['productId']);

                $sql = "SELECT SQL_CALC_FOUND_ROWS id FROM users WHERE accessToken = '$authToken'";
		$data = $db->getAll($sql);
		$count = count($data);

                if($count > 0) {
                        $userId = $data[0]['id'];

                        $sql = "SELECT SQL_CALC_FOUND_ROWS id FROM progressFinish WHERE productId = '$productId' AND userId = '$userId'";
                        $data2 = $db->getAll($sql);
                        $countFinish = count($data2);

                        if($countFinish > 0) {
                                $sql = "UPDATE progressFinish SET lastId = '$elemId' WHERE productId = '$productId' AND userId = '$userId'";
			        $updateQuery = $db->query($sql);
                        } else {
                                $sql = "INSERT INTO progressFinish (userId, productId, lastId) VALUES ('$userId', '$productId', '$elemId')";
                                $insertQuery = $db->query($sql);
                        }


                        return true;
                }
                return false;
        }

        return false;
}