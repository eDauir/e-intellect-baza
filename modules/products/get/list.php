<?php
function getList($db) {
    if(!empty($_GET['authToken']) && !empty($_GET['mentorId'])) {
        $authToken = convertStr($_GET['authToken']);
        $mentorId = convertStr($_GET['mentorId']);
       
        $sql = "SELECT id, name, online FROM products WHERE userId = '$mentorId'";
		$data = $db->getAll($sql);

        return $data;
    }
}           