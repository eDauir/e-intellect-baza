<?php
function contacts($db) {

        if(isset($_GET['youtube']) && isset($_GET['facebook']) && isset($_GET['insta'])  && isset($_GET['tel'])  && isset($_GET['geo']) && isset($_GET['id'])) {
                $youtube = convertStr($_GET['youtube']);
                $facebook = convertStr($_GET['facebook']);
                $insta = convertStr($_GET['insta']);
                $tel = convertStr($_GET['tel']);
                $geo = convertStr($_GET['geo']);
                $id = convertStr($_GET['id']);

                $sql = "UPDATE contacts SET youtube = '$youtube', facebook = '$facebook', insta = '$insta', telephone = '$tel', address = '$geo' WHERE id = '$id'";
                $updateQuery = $db->query($sql);

                return true;
        }

        return false;
}