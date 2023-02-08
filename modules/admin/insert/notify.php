<?php
function notify($db) {
        
        if(!empty($_GET['title']) && !empty($_GET['text']) && !empty($_GET['nType']) && !empty($_GET['userId'])) {
            $title = convertStr($_GET['title']);
            $text = convertStr($_GET['text']);
            $nType = convertStr($_GET['nType']);
            $userId = convertStr($_GET['userId']);

            $sql = "INSERT INTO notify (title, text, type, userId) VALUES ('$title', '$text', '$nType', '$userId')";
            $insertQuery = $db->query($sql);

            return true;
        }

        return false;
}