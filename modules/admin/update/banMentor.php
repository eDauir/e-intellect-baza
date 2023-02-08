<?php
function banMentor($db) {
        
        if(isset($_GET['id'])) {

                $id = convertStr($_GET['id']);

                $sql = "UPDATE users SET editor = 4 WHERE id = '$id'";
                $updateQuery = $db->query($sql);

                return true;
        }

        return false;
}