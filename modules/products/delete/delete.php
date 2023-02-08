<?php
function delProduct($db) {
    if(isset($_GET['authToken']) && isset($_GET['productId']) && isset($_GET['mentorId'])) {
        $authToken = convertStr($_GET['authToken']);
        $productId = convertStr($_GET['productId']);
        $mentorId = convertStr($_GET['mentorId']);

        $sql = "UPDATE products SET active = 0 WHERE id = '$productId' AND userId = '$mentorId'";
		$updateQuery = $db->query($sql);

        if($updateQuery)
            return true;
        else
            return false;
    }

    return false;
}