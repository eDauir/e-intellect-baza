<?php
function delAdmin($db) {
        
        if(isset($_GET['id'])) {

                $id = convertStr($_GET['id']);

                $sql = "UPDATE users SET editor = 0 WHERE id = '$id'";
                $updateQuery = $db->query($sql);

                return true;
        }

        return false;
}