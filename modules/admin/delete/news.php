<?php
function news($db) {
        
        if(!empty($_GET['id'])) {
            $id = convertStr($_GET['id']);

            $sql = "DELETE FROM news WHERE id = '$id'";
            $deleteQuery = $db->query($sql);

            return true;
        }

        return false;
}