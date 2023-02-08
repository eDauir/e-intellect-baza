<?php
function settings($db) {

        if(isset($_GET['title']) && isset($_GET['seoTitle']) && isset($_GET['info']) && isset($_GET['id'])) {
                $title = convertStr($_GET['title']);
                $seoTitle = convertStr($_GET['seoTitle']);
                $info = convertStr($_GET['info']);
                $id = convertStr($_GET['id']);

                $sql = "UPDATE settings SET title = '$title', seoTitle = '$seoTitle', info = '$info' WHERE id = '$id'";
                $updateQuery = $db->query($sql);

                return true;
        }

        return false;
}