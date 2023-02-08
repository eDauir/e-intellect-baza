<?php
function lessons($db) {
        
        if(!empty($_GET['id'])) {
            $id = convertStr($_GET['id']);

            $sql = "DELETE FROM lessons WHERE id = '$id'";
            $deleteQuery = $db->query($sql);

            return true;
        }

        return false;
}