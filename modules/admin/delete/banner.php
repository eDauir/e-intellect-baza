<?php
function banner($db) {
        
        if(!empty($_GET['id'])) {
            $id = convertStr($_GET['id']);

            $sql = "DELETE FROM banner WHERE id = '$id'";
            $deleteQuery = $db->query($sql);

            return true;
        }

        return false;
}