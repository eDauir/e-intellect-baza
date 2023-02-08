<?php
function checkId($db) {
    if(isset($_GET['id'])) {
        $id = convertStr($_GET['id']);

        $sql = "SELECT users_profile.name, users_profile.surname, users_profile.user_id FROM balance INNER JOIN users_profile ON balance.userId = users_profile.user_id WHERE balance.userId = '$id'";
        $data = $db->getAll($sql);

        return $data;
    }
}