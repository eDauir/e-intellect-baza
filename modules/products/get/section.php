<?php
function getSection($db) {
    if(!empty($_GET['productId'])) {
        $productId = convertStr($_GET['productId']);
       
        $sql = "SELECT id, name FROM sections WHERE productId = '$productId'";
		$data = $db->getAll($sql);

        return $data;
    }
}           